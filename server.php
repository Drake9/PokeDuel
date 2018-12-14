 <?php      //                          php C:\xampp\htdocs\pokemony\server.php > C:\xampp\htdocs\pokemony\serverlog.txt
	require 'class.PHPWebSocket.php';
	require 'class.PokeGame.php';

	$usersOnline = array();
	$numberOfUsers = 0;
	$games = array();
	$numberOfGames = 0;
	$attackDex = new attackdex();
	
    // Funkcja będzie wywoływana przy każdej przychodzącej wiadomości
    function wsOnMessage($clientID, $message, $messageLength, $binary) {
        global $Server, $usersOnline, $numberOfUsers;
		
        // wypisujemy w konsoli to, co przyszło
        //printf("Client %s sent: %s\n", $clientID, $message);
        
        // odsyłamy wiadomość z przedrostkiem "Re:"  <- nie wiem, czy to się przyda?
        //$Server->wsSend($clientID, "Re: $message");
		$words = explode(" ", $message);
		$keyword = $words[0];
		
		switch($keyword){
			case "Connected:":
				dealWithConnected($clientID, $words);
				break;
			case "Disconnected:":
				dealWithDisconnected($clientID, $words);
				break;
			case "Challenged:":
				dealWithChallenged($clientID, $words);
				break;
			case "Match:":
				dealWithMatch($clientID, $words);
				break;
			case "Player":
				dealWithPlayer($clientID, $words);
				break;
			default:
				printf("Incorrect message:\n".$message."\n");
				break;
		}

    }
	
	function dealWithPlayer($clientID, $words){
		global $games, $Server;
		
		$nick = $words[2];
		$gameIndex = findGame($nick);
		
		if($gameIndex != 0){
			$game = $games[$gameIndex];
			
			if($game->player1->playerNick == $nick){
				$player = $game->player1;
				$opponent = $game->player2;
			}
			else{
				$player = $game->player2;
				$opponent = $game->player1;
			}
			
			$keyword = $words[1];
			
			switch($keyword){
				case "GameDataRequest:":
					dealWithGameDataRequest($clientID, $game, $player, $opponent);
					break;
				case "DisconnectedInGame:":
					dealWithDisconnectedInGame($game, $player, $opponent);
					break;
				case "Chosen:":
					dealWithPokemonChoice($words, $game, $player, $opponent);
					break;
				case "CardPlayed:":
					dealWithCardPlayed($clientID, $words, $game, $player, $opponent);
					break;
				case "Response:":
					dealWithResponse($clientID, $words, $game, $player, $opponent);
					break;
				case "SwitchPokemonRequest:":
					dealWithSwitchRequest($game, $player, $opponent);
					break;
				case "PassTurnRequest:":
					dealWithPassRequest($game, $player, $opponent);
					break;
				case "ContinueRequest:":
					dealWithContinueRequest($game, $player, $opponent);
					break;
				case "DiscardRequest:":
					dealWithDiscardRequest($words, $game, $player, $opponent);
					break;
				case "RPS:":
					dealWithRPS($words, $game, $player, $opponent);
					break;
				case "ConcedeRequest:":
					dealWithConcedeRequest($game, $player, $opponent);
					break;
				default:
					printf("Incorrect message from player:\n".$message."\n");
					break;
			}
		}
		else{
			$Server->wsSend($clientID, "Sorry, it seems that you aren't currently playing.");
		}		
	}

	function dealWithConnected($clientID, $words){
		global $Server, $usersOnline, $numberOfUsers;
		
		$nick = $words[1];
		
		$numberOfUsers++;	
		$usersOnline[$clientID] = $nick;
			
		$size = sizeof($usersOnline);
		$index=1;
		printf("List of users online: \n");
		while($index <= $size){
			if($usersOnline[$index]!=NULL){
				printf("%s  %s\n",$index,$usersOnline[$index]);
				$Server->wsSend($index, json_encode($usersOnline));
				$index++;
			}
			else
				$index++;
		}
			
	}
	
	function dealWithDisconnected($clientID, $words){
		global $Server, $usersOnline, $numberOfUsers;
		
		$nick = $words[1];
		
		$numberOfUsers--;
		$usersOnline[$clientID] = NULL;
			
		$size = sizeof($usersOnline);
		$index=1;
		while($index <= $size){
			if($usersOnline[$index]!=NULL){
				printf("%s  %s\n", $index, $usersOnline[$index]);
				$Server->wsSend($index, "Disconnected: $nick");
				$Server->wsSend($index, json_encode($usersOnline));
				$index++;
			}
			else
				$index++;
		}	
	}
	
	function dealWithChallenged($clientID, $words){
		global $Server, $usersOnline, $numberOfUsers;
		
		$challenger = $words[1];
		$challenged = $words[3];
		$challengedID = array_search($challenged, $usersOnline);
		
		$Server->wsSend($challengedID, "Challenged by $challenger");
		
	}
	
	function dealWithMatch($clientID, $words){
		global $Server, $usersOnline, $games, $numberOfGames;
		
		$challenged = $words[1];
		$challenger = $words[3];
		$challengerID = array_search($challenger, $usersOnline);
		
		printf("Starting new game.\n Player1: %s\n Player2: %s\n", $challenger, $challenged);
		
		$index = 1;
		while(isset($games[$index]))
			$index++;
		
		$games[$index] = new game($challenger, $challenged, $index);
		$numberOfGames++;
		
		$Server->wsSend($clientID, "Game");
		$Server->wsSend($challengerID, "Game");
		
	}
	
	function dealWithDisconnectedInGame(&$game, &$player, &$opponent){
		global $Server;
		
		printf("Player disconnected: %s\n", $player->playerNick);
		
		$player->inGame = false;
		
		if($opponent->inGame == true){
			$Server->wsSend($opponent->currentID, "Your opponent has disconnected.");
		}
		else{
			$game->endingGame == true;
			printf("Game %s: Players disconnected - %s, %s. This game is being closed.\n", $game->gameIndex, $player->playerNick, $opponent->playerNick);
			$noone = null;
			closeGame($game, $noone);
		}
	}
	
	function dealWithGameDataRequest($clientID, &$game, &$player, &$opponent){
		global $Server;
		
		$player->currentID = $clientID;
		$player->inGame = true;

		sendPokemons($clientID, $player);
		sendCardsInHand($clientID, $player);
		sendOpPokemons($clientID, $player, $opponent);
		
		$Server->wsSend($clientID, "Opponent:/".$opponent->playerNick);
		
		$cardsLeft = constant("DECK_SIZE") - $player->playerDeckIndex + 1;
		$Server->wsSend($clientID, "Cards left:/".$cardsLeft);
		
		$opCardsLeft = constant("DECK_SIZE") - $opponent->playerDeckIndex + 1;
		$Server->wsSend($player->currentID, "OpCards left:/".$opCardsLeft);
		
		$Server->wsSend($clientID, "Weather:/".$game->weather);
		
		if($player->cardOnTable)			
			$Server->wsSend($player->currentID, "Continue:/true");
		
		if(($player->activePokemon == 0 && $game->startingGame == false) || ($game->player1->playerNick == $player->playerNick && $game->startingGame == true)){
			sendAskToPickPockemon($clientID, $opponent->currentID);
		}
		
		if($player->activePokemon != 0)
			$Server->wsSend($clientID, "Your active Pokemon:/".$player->activePokemon."/".$player->pokemons[$player->activePokemon]->pokeName);
		
		if($opponent->activePokemon != 0){
			$Server->wsSend($clientID, "Opponent active Pokemon:/".$opponent->activePokemon."/".$opponent->pokemons[$opponent->activePokemon]->pokeName);
		}
		
		if($player->hasTurn == true)
			$Server->wsSend($clientID, "Your turn!");
		else if($game->startingGame == false)
			$Server->wsSend($clientID, "Opponent's turn!");
		
		printf("Game %s: Full game data has been sent to %s.\n", $game->gameIndex, $player->playerNick);
	}
	
	function findGame($nick){
		global $games, $numberOfGames;
		
		$gameIndex = 0;
		for($index = 1; $index <= $numberOfGames; $index++)
			if($games[$index]->player1->playerNick == $nick || $games[$index]->player2->playerNick == $nick)
				$gameIndex = $index;
		
		return $gameIndex;
	}
	
	function sendPokemons($clientID, $player){
		global $Server, $games;
		$pokemons = $player->pokemons;
		
		for($index=1; $index<=6; $index++){
			$data = $pokemons[$index]->getStats();
			$data = json_encode($data);
			$Server->wsSend($clientID, "Pokemon:/".$index."/".$data);
		}
	}
	
	function sendCardsInHand($clientID, $player){
		global $Server, $games, $attackDex;
		$hand = $player->playerHand;
		
		for($index=1; $index<=5; $index++){
			$data = $attackDex->readCard($hand[$index]);
			$data = json_encode($data);
			$Server->wsSend($clientID, "Card:/".$index."/".$data);
		}
	}
	
	function sendOpPokemons($clientID, &$player, &$opponent){
		global $Server, $games;
		
		for($index=1; $index<7; $index++){
			if($player->knownOpPokemons[$index] == true){
				$data = $opponent->pokemons[$index]->getStats();
				$data = json_encode($data);
				$Server->wsSend($clientID, "OpPokemon:/".$index."/".$data);
			}
		}
	}
	
	function sendActivePokemonInfo(&$player, $opponentID){
		global $Server;
		
		$playersPokemon = $player->pokemons[$player->activePokemon];
		
		$data = $playersPokemon->getStats();
		$data = json_encode($data);
		
		$Server->wsSend($player->currentID, "Pokemon:/".$player->activePokemon."/".$data);
		$Server->wsSend($opponentID, "OpPokemon:/".$player->activePokemon."/".$data);
					
		$Server->wsSend($player->currentID, "Your active Pokemon:/".$player->activePokemon."/".$playersPokemon->pokeName);
		$Server->wsSend($opponentID, "Opponent active Pokemon:/".$player->activePokemon."/".$playersPokemon->pokeName);
	}
	
	function dealWithDiscardRequest($words, &$game, &$player, &$opponent){
		global $Server;
		
		if($player->hasTurn == true && $player->hasDiscarded == false){
			$player->hasDiscarded = true;
			
			$cardHandNumber = $words[3];
			$player->playerHand[$cardHandNumber] = 0;
			$Server->wsSend($player->currentID, "Card:/".$cardHandNumber."/no card");
			$Server->wsSend($opponent->currentID, "Opponent is discarding.");
			
			printf("Game %s: %s has discarded card number %s.\n", $game->gameIndex, $player->playerNick, $cardHandNumber);
		}
	}
	
	function dealWithPassRequest(&$game, &$player, &$opponent){
		global $Server;
		
		if($player->hasTurn == true){
			$player->hasTurn = false;
			
			$playersPokemon = $player->pokemons[$player->activePokemon];
			$playersPokemon->increaseEnergy(1);
			$playersPokemon->currentStatus['exhausted'] = false;
			printf("Game %s: %s is waiting.\n", $game->gameIndex, $player->playerNick);
			goToStatusPhase($game, $player, $opponent);
		}
	}
	
	function dealWithContinueRequest(&$game, &$player, &$opponent){
		global $Server;
		
		if($player->hasTurn == true){
			$player->hasTurn = false;
			
			$playersPokemon = $player->pokemons[$player->activePokemon];
			$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
			
			if($player->cardOnTable == null){
				$Server->wsSend($player->currentID, "No card on table. If you want to continue doing nothing - just pass.");
			}
			else if($playersPokemon->currentStatus['sleeping']){
				$Server->wsSend($player->currentID, "Your active Pokemon is sleeping. Switch or wait for taking damage.");
			}
			else{
				$cardData = $player->cardOnTable;
				$player->increaseCounter();
				
				$playersPokemon = $player->pokemons[$player->activePokemon];
				$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
				
				$playersPokemon->decreaseEnergy($cardData->attackCost);
				$modificator = $opponentsPokemon->getWRModificator($cardData->attackType);
				$damage = countDamage($modificator, $cardData->attackCategory, $cardData->attackPower, $playersPokemon, $opponentsPokemon, $cardData->attackKeywords, $player->counter, $game->weather);
				$player->dmgOnTable = $damage;
					
				printf("Game %s: %s's %s is using %s which is going to deal %s damage.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName, $damage);
				$Server->wsSend($player->currentID, "Your ".$playersPokemon->pokeName."'s ".$cardData->attackName." is going to deal ".$damage." damage.");
				$Server->wsSend($opponent->currentID, "Opponent's move:/Opponent&#39s ".$playersPokemon->pokeName." uses ".$cardData->attackName." which is going to deal ".$damage." damage.");
			}
		}
	}
	
	function dealWithSwitchRequest(&$game, &$player, &$opponent){
		global $Server;
		
		if($player->hasTurn == true){
			if($player->pokemons[$player->activePokemon]->currentStatus['trapped'] == true){
				$Server->wsSend($clientID, "Your Pokemon is trapped and can't be switched out.");
			}
			else{
				$player->hasTurn == false;
				$player->withdrawPokemon();
				printf("Game %s: %s is switching out.\n", $game->gameIndex, $player->playerNick);
				sendAskToPickPockemon($player->currentID, $opponent->currentID);
			}
		}
	}
	
	function sendAskToPickPockemon($clientID, $oppID){
		global $Server;
		
		$Server->wsSend($clientID, "Choose your Pokemon!");
		if($oppID > 0)
			$Server->wsSend($oppID, "Your opponent is choosing Pokemon.");
	}
	
	function dealWithPokemonChoice($words, &$game, &$player, &$opponent){
		global $Server;
			
		$opponentID = $opponent->currentID;
		
		if($player->activePokemon != 0){
			$Server->wsSend($clientID, "You must withdraw your active Pokémon first!");
		}
		else{
			$index = (int)$words[5];
			
			if($player->pokemons[$index]->currentHP == 0)
				$Server->wsSend($player->currentID, "This Pokémon has fainted and can't fight.");
			
			else{
				printf("Game %s: %s is switching in with %s.\n", $game->gameIndex, $player->playerNick, $player->pokemons[$index]->pokeName);
				$player->choosePokemon($index);
				$opponent->knownOpPokemons[$index] = true;
				
				sendActivePokemonInfo($player, $opponent->currentID);
			
				if($opponent->activePokemon == 0){
					sendAskToPickPockemon($opponentID, $player->currentID);
				}
				else{
					if($game->startingGame == true)
						$game->startingGame = false;
					
					if($game->activePlayer == 1){
						goToStatusPhase($game, $game->player1, $game->player2);
					}
					else{
						goToStatusPhase($game, $game->player2, $game->player1);
					}
				}
			}
		}
	}
	
	function dealWithCardPlayed($clientID, $words, &$game, &$player, &$opponent){
		global $Server, $attackDex;
		
		if($player->hasTurn == true){
			$cardHandNumber = (int)$words[3];
			$cardID = $player->playerHand[$cardHandNumber];
			$cardData = $attackDex->readCard($cardID);
			
			$playersPokemon = $player->pokemons[$player->activePokemon];
			$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
			
			if($cardID < 1){
				$Server->wsSend($clientID, "You can't play a blank card, Taylor Swift.");
			}
			else if(strpos($cardData->attackKeywords, "react") !== false){
				$Server->wsSend($clientID, "There is nothing to react to. Pick another card.");
			}
			else if($playersPokemon->currentStatus['sleeping']){
				$Server->wsSend($clientID, "Your Pokémon is sleeping. Pass a turn or switch.");
			}
			else if($playersPokemon->currentStatus['exhausted']){
				$Server->wsSend($clientID, "Your Pokémon is exhausted. Pass a turn or switch.");
			}
			else if($opponentsPokemon->currentStatus['hidden'] && ($cardData->attackCategory != "S" || strpos($cardData->attackKeywords, "opp") !== false)){
				$Server->wsSend($clientID, "Opponent's Pokémon is hidden and invulnerable.");
			}
			else if($playersPokemon->typePrimary != $cardData->attackType && $playersPokemon->typeSecondary != $cardData->attackType && $playersPokemon->pokeName != $cardData->attackSignature && $cardData->attackType != "normal"){
				$Server->wsSend($clientID, "Your Pokémon can not use this attack. Pick an attack that matches the type or switch your Pokémon.");
			}
			else if($playersPokemon->currentEnergy < $cardData->attackCost){
				$Server->wsSend($clientID, "Your Pokémon is too tired to use this attack. Pick a weaker one or switch your Pokémon or wait a turn to regain energy.");
			}
			else{//ostatni przypadek: rzucamy kartę i rozpatrujemy efekty
			
				$player->hasTurn = false;
				$player->playerHand[$cardHandNumber] = 0;
				$Server->wsSend($player->currentID, "Card:/".$cardHandNumber."/no card");
				
				if(strpos($cardData->attackKeywords, "loaded") !== false || strpos($cardData->attackKeywords, "reuse") !== false)
					$player->increaseCounter();
				
				
				if(strpos($cardData->attackKeywords, "attempt:KO") !== false){
					$playersPokemon->decreaseEnergy($cardData->attackCost);
					$player->cardOnTable = $cardData;
					$player->dmgOnTable = 0;
					
					printf("Game %s: %s's %s uses %s which might be a KO.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					
					$Server->wsSend($player->currentID, "Your ".$playersPokemon->pokeName." is using ".$cardData->attackName.".");
					$Server->wsSend($opponent->currentID, "Opponent's move:/Opponent's Pokémon uses ".$cardData->attackName.".");
				}
				else if(strpos($cardData->attackKeywords, "loaded") !== false){
					//atak ładowany
					$playersPokemon->decreaseEnergy(1);
					$player->cardOnTable = $cardData;
					printf("Game %s: %s's %s is preparing %s.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					$Server->wsSend($player->currentID, "Your ".$playersPokemon->pokeName." is preparing ".$cardData->attackName.".");
					$Server->wsSend($opponent->currentID, "Opponent's move:/Opponent's Pokémon is preparing for ".$cardData->attackName.".");
				}
				else{//atak normalny
					$playersPokemon->decreaseEnergy($cardData->attackCost);
					$player->cardOnTable = $cardData;
					$modificator = $opponentsPokemon->getWRModificator($cardData->attackType);
					$damage = countDamage($modificator, $cardData->attackCategory, $cardData->attackPower, $playersPokemon, $opponentsPokemon, $cardData->attackKeywords, $player->counter, $game->weather);
					$player->dmgOnTable = $damage;
					
					printf("Game %s: %s's %s uses %s which is going to deal %s damage.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName, $damage);
					$Server->wsSend($player->currentID, "Your ".$playersPokemon->pokeName."'s ".$cardData->attackName." is going to deal ".$damage." damage.");
					$Server->wsSend($opponent->currentID, "Opponent's move:/Opponent&#39s ".$playersPokemon->pokeName." uses ".$cardData->attackName." which is going to deal ".$damage." damage.");
				}
			}
		}
				
	}	
	
	
	function dealWithResponse($clientID, $words, &$game, &$player, &$opponent){
		global $Server, $attackDex;
		
		$playersPokemon = $player->pokemons[$player->activePokemon];
		$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
		$dodge = false;
		
		if($player->hasTurn == false){
			if((int)$words[3] != 0){
				$cardHandNumber = $words[3];
				$cardID = $player->playerHand[$cardHandNumber];
				$cardData = $attackDex->readCard($cardID);
				
				if($cardID < 1){
					$Server->wsSend($clientID, "You can't play a blank card, Taylor Swift.");
				}
				else if(strpos($cardData->attackKeywords, "quick") === false && strpos($cardData->attackKeywords, "react") === false){
					$Server->wsSend($clientID, "Your Pokémon can't use this attack out of your turn.");
				}
				else if($playersPokemon->currentStatus['exhausted']){
					$Server->wsSend($clientID, "Your Pokémon is exhausted.");
				}
				else if($playersPokemon->currentStatus['paralyzed']){
					$Server->wsSend($clientID, "Your Pokémon is paralyzed.");
				}
				else if($playersPokemon->speed < $opponentsPokemon->speed && (!$opponentsPokemon->currentStatus['paralyzed'] || $playersPokemon->speed < $opponentsPokemon->speed/2) && strpos($cardData->attackKeywords, "Teleport") === false){
					$Server->wsSend($clientID, "Your Pokémon is too slow to do it.");
				}
				else if(strpos($opponent->cardOnTable->attackKeywords, "area") !== false && strpos($cardData->attackKeywords, "dodge") !== false){
					$Server->wsSend($clientID, "There is nowhere to run!");
				}
				else if($playersPokemon->typePrimary != $cardData->attackType && $playersPokemon->typeSecondary != $cardData->attackType && $playersPokemon->pokeName != $cardData->attackSignature && $cardData->attackType != "normal"){
					$Server->wsSend($clientID, "Your Pokémon can not use this attack. Pick an attack that matches the type or switch your Pokémon.");
				}
				else if($playersPokemon->currentEnergy < $cardData->attackCost){
					$Server->wsSend($clientID, "Your Pokémon is too tired to use this attack. Pick a weaker one or switch your Pokémon or wait a turn to regain energy.");
				}
				else if((strpos($cardData->attackKeywords, "counterattack:PA") !== false && $opponent->cardOnTable->attackCategory != "PA") || (strpos($cardData->attackKeywords, "counterattack:SA") !== false && $opponent->cardOnTable->attackCategory != "SA")){
					$Server->wsSend($clientID, "Category of a counterattack must match attack's category.");
				}
				else{ // ostatni przypadek, rozpatrujemy karty na stole
					printf("%s's %s uses %s \n", $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					$player->playerHand[$cardHandNumber] = 0;
					$playersPokemon->decreaseEnergy($cardData->attackCost);
					$player->cardOnTable = $cardData;
					
					$Server->wsSend($player->currentID, "Card:/".$cardHandNumber."/no card");
					
					//rozpatrujemy efekty karty reakcji
					
					if(strpos($cardData->attackKeywords, "dodge") !== false){ //unik
					
						$dodge = true;
						printf("Game %s: %s's %s used %s.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
						$Server->wsSend($opponent->currentID, "Opponent's ".$playersPokemon->pokeName." has avoided your attack.");
						$Server->wsSend($player->currentID, "Your ".$playersPokemon->pokeName." has avoided opponent's attack.");
						
						//sleep(2); //ten sleep musi potem zostać usunięty albo jakoś przeniesiony do game.js
					}
					else if(strpos($cardData->attackKeywords, "quick") !== false){ //atak wyprzedzający
						
						$modificator = $opponentsPokemon->getWRModificator($cardData->attackType);
							
						$damage = countDamage($modificator, $cardData->attackCategory, $cardData->attackPower, $playersPokemon, $opponentsPokemon, $cardData->attackKeywords, $player->counter, $game->weather);
							
						$opponentsPokemon->decreaseHP($damage);
						
						applyEffects($game, $player, $playersPokemon, $opponent, $opponentsPokemon, $cardData->attackCategory, $cardData->attackKeywords, $dodge, $damage);
						
						printf("Game %s: %s's %s used %s dealing %s damage.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName, $damage);
						$Server->wsSend($player->currentID, "Attack:/1/$damage/Your attack did $damage damage.");
						$Server->wsSend($opponent->currentID, "Attack:/2/$damage/Opponent's attack did $damage damage.");	
						
						//sleep(2); // j.w.
					}
					else if(strpos($cardData->attackKeywords, "counterattack") !== false){ //kontratak
						$dodge = true;
						
						$modificator = $opponentsPokemon->getWRModificator($opponent->cardOnTable->attackType);
						
						$damage = countDamage($modificator, $cardData->attackCategory, $opponent->cardOnTable->attackPower, $opponentsPokemon, $opponentsPokemon, $opponent->cardOnTable->attackKeywords, $player->counter, $game->weather);
							
						$opponentsPokemon->decreaseHP($damage);
						
						applyEffects($game, $player, $playersPokemon, $opponent, $opponentsPokemon, $cardData->attackCategory, $cardData->attackKeywords, $dodge, $damage);
						
						printf("Game %s: %s's %s used %s dealing %s damage.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName, $damage);
						$Server->wsSend($player->currentID, "Attack:/1/$damage/Your counterattack did $damage damage.");
						$Server->wsSend($opponent->currentID, "Attack:/2/$damage/Opponent's counterattack did $damage damage.");	
						
						//sleep(2); // j.w.
					}
					$player->cardOnTable = NULL;
					$player->dmgOnTable = 0;
				}
			}
			
			//tutaj rozpatrujemy kartę gracza mającego ruch, zagraną wcześniej
			$cardData = $opponent->cardOnTable;
			if(strpos($cardData->attackKeywords, "attempt:KO") !== false && $dodge == false && $playersPokemon->currentHP > 0  && $opponentsPokemon->currentHP > 0 && $playersPokemon->currentStatus['hidden'] == false){
				$game->rps = true;
				$Server->wsSend($player->currentID, "RPS Request!/$cardData->attackName");
				$Server->wsSend($opponent->currentID, "RPS Request!/$cardData->attackName");
			}
			else{
				resolveAttackNormally($game, $opponent, $player, $opponentsPokemon, $playersPokemon, $dodge);
			}
		}
	}
	
	function dealWithRPS($words, &$game, &$player, &$opponent){
		global $Server, $attackDex;
		
		$response = $words[3];
		
		if($game->rps){
			
			$player->rps = $response;
			
			if($opponent->rps){ // jeżeli drugi gracz już odpowiedział to rozpatrujemy dalej; zmieniamy oznaczenia na wygodniejsze
			
				$game->rps = false;
			
				if($game->activePlayer == 1){
					$player = $game->player1;
					$opponent = $game->player2;
				}
				else{
					$player = $game->player2;
					$opponent = $game->player1;
				}
			
				$playersPokemon = $player->pokemons[$player->activePokemon];
				$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
				
				if(($opponent->rps == "none") || ($player->rps == "rock" && $opponent->rps == "scissors") || ($player->rps == "paper" && $opponent->rps == "rock") || ($player->rps == "scissors" && $opponent->rps == "paper")){
					$damage = $opponentsPokemon->currentHP;
					$opponentsPokemon->decreaseHP($damage);
					
					printf("Game %s: %s's %s knocked his foe down with %s.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					$Server->wsSend($player->currentID, "Attack:/1/9/Your attack is a K.O.!");
					$Server->wsSend($opponent->currentID, "Attack:/2/9/Opponent's attack is a K.O.!");
					
					continueAfterAttackResolved($game, $player, $opponent, $playersPokemon, $opponentsPokemon);
				}
				else if(($player->rps == "none" && $opponent->rps != "none") || ($player->rps == "rock" && $opponent->rps == "paper") || ($player->rps == "paper" && $opponent->rps == "scissors") || ($player->rps == "scissors" && $opponent->rps == "rock")){
					$damage = 4;
					$playersPokemon->decreaseHP($damage);
					
					printf("Game %s: %s's %s used %s and missed badly.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					$Server->wsSend($player->currentID, "Miss. Recoil: 4 dmg.");
					$Server->wsSend($opponent->currentID, "Opponent have missed. Badly.");
					
					continueAfterAttackResolved($game, $player, $opponent, $playersPokemon, $opponentsPokemon);
				}
				else{
					$damage = 2;
					$playersPokemon->decreaseHP($damage);
					
					printf("Game %s: %s's %s used %s and missed.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName);
					$Server->wsSend($player->currentID, "Miss. Recoil: 2 dmg.");
					$Server->wsSend($opponent->currentID, "Opponent have missed.");
					
					continueAfterAttackResolved($game, $player, $opponent, $playersPokemon, $opponentsPokemon);
				}
			}
		}
	}
	
	function resolveAttackNormally(&$game, &$player, &$opponent, &$playersPokemon, &$opponentsPokemon, $dodge){
		global $Server;
		
		$cardData = $player->cardOnTable;
		$damage = $player->dmgOnTable;
		
		if($playersPokemon->currentHP > 0 && $dodge == false && $opponentsPokemon->currentHP > 0 && $opponentsPokemon->currentStatus['hidden'] == false){	//bo mógł dostać szybkim atakiem i paść; a tamten mógł paść od confused
			$opponentsPokemon->decreaseHP($damage);
					
			if($cardData->attackKeywords != null)
				applyEffects($game, $player, $playersPokemon, $opponent, $opponentsPokemon, $cardData->attackCategory, $cardData->attackKeywords, $dodge, $damage);
			
			printf("Game %s: %s's %s used %s. It has done %s damage.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName, $cardData->attackName, $damage);
			$Server->wsSend($player->currentID, "Attack:/1/$damage/Your attack did $damage damage.");
			$Server->wsSend($opponent->currentID, "Attack:/2/$damage/Opponent's attack did $damage damage.");
		}
		
		continueAfterAttackResolved($game, $player, $opponent, $playersPokemon, $opponentsPokemon);
	}
	
	function continueAfterAttackResolved(&$game, &$player, &$opponent, &$playersPokemon, &$opponentsPokemon){
		$cardData = $player->cardOnTable;
		
		//odsyłamy nowe staty poków
			
		sendActivePokemonInfo($player, $opponent->currentID);
		sendActivePokemonInfo($opponent, $player->currentID);
		
		//kończymy turę gracza
		
		if($playersPokemon->currentStatus['hidden'] && $player->counter >= 2)
			$playersPokemon->currentStatus['hidden'] = false;
		
		if((strpos($cardData->attackKeywords, "reuse") === false && strpos($cardData->attackKeywords, "loaded") === false) ||
			(strpos($cardData->attackKeywords, "reuse") !== false && $opponent->counter >= 3) ||
			(strpos($cardData->attackKeywords, "loaded") !== false && $opponent->counter >= 2) ){
				
			$player->cardOnTable = null;
			$player->counter = 0;
		}
		
		$player->dmgOnTable = 0;
		
		//sprawdzamy, czy oba poki żyją i czy któryś z graczy wygrał i wysyłamy odpowiednie info
		
		if($opponentsPokemon->currentHP <= 0){
			printf("Game %s: %s's%s has fainted.\n", $game->gameIndex, $opponent->playerNick, $opponentsPokemon->pokeName);
			dealWithFainted($opponentsPokemon, $opponent, $player);
		}
		if($playersPokemon->currentHP <= 0){
			printf("Game %s: %s's%s has fainted.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName);
			dealWithFainted($playersPokemon, $player, $opponent);
		}
		
		//sprawdzamy, czy ktoś wygrał - jeżeli nie, gramy dalej
		
		if($player->victory && $opponent->victory){
			printf("Game %s: The game has ended in a draw.\n", $game->gameIndex);
			sendEndGameMessagesDraw($player, $opponent);
			closeGame($game, null);
		}
		else if($player->victory){
			printf("Game %s: The game has ended. %s is the winner.\n", $game->gameIndex, $player->playerNick);
			sendEndGameMessagesNoDraw($player, $opponent);
			closeGame($game, $player);
		}
		else if($opponent->victory){
			printf("Game %s: The game has ended. %s is the winner.\n", $game->gameIndex, $opponent->playerNick);
			sendEndGameMessagesNoDraw($opponent, $player);
			closeGame($game, $opponent);
		}
		else{
		
			if($opponent->activePokemon == 0){
				sendAskToPickPockemon($opponent->currentID, $player->currentID);
			}
			else if($player->activePokemon == 0){
				sendAskToPickPockemon($player->currentID, $opponent->currentID);
			}
			else{
				goToStatusPhase($game, $player, $opponent);
			}
		}
	}
	
	function sendEndGameMessagesDraw(&$player, &$opponent){
		global $Server;
		
		$Server->wsSend($player->currentID, "Game over!/Draw!/Such an outstanding duel!");
		$Server->wsSend($opponent->currentID, "Game over!/Draw!/Such an outstanding duel!");
	}
	
	function sendEndGameMessagesNoDraw(&$victor, &$loser){
		global $Server;
		
		$Server->wsSend($victor->currentID, "Game over!/Victory!/Congratulations! You have won!");
		$Server->wsSend($loser->currentID, "Game over!/Defeat!/You have lost. Don't be sad. Even best trainers lose sometimes.");
	}
	
	function countDamage($modificator, $attackCategory, $attackPower, &$attackingPokemon, &$defendingPokemon, $keywords, $counter, $weather){
		
		if($attackCategory == "S"){
			$damage = 0;
		}
		else if($modificator === 0){
			$damage = 0;
		}
		else if($attackCategory == "PA"){
			$damage = $attackPower + $attackingPokemon->attack - $defendingPokemon->defence + intval($modificator);
			if($attackingPokemon->currentStatus['burned'])
				$damage--;
		}
		else if($attackCategory == "SA"){
			$damage = $attackPower + $attackingPokemon->specialAttack - $defendingPokemon->specialDefence + intval($modificator);
			if($weather == "sandstorm")
				$damage--;
		}
		
		//rozpatrujemy różne modyfikatory
		
		if($modificator !== 0){
			
			if(strpos($keywords, "rising") !== false)
				$damage = $damage + $counter - 1;
			
			if(strpos($keywords, "bonus:mass") !== false && $attackingPokemon->pokeWeight > $defendingPokemon->pokeWeight)
				$damage+=2;;
			
			if(strpos($keywords, "bonus:speed") !== false && $attackingPokemon->speed > $defendingPokemon->speed)
				$damage+=2;;
			
			if(strpos($keywords, "bonus:poisoned") !== false && $defendingPokemon->currentStatus['poisoned'])
				$damage+=2;
			
			if(strpos($keywords, "bonus:water") !== false && ($defendingPokemon->typePrimary == "water" || $defendingPokemon->typeSecondary == "water"))
				$damage+=3;
			
			if(strpos($keywords, "power:massRatio") !== false){
				$ratio = $attackingPokemon->pokeWeight / $defendingPokemon->pokeWeight;
				
				if($ratio < 2)
					$damage++;
				else if($ratio < 3)
					$damage+=2;
				else if($ratio < 4)
					$damage+=3;
				else if($ratio < 5)
					$damage+=4;
				else
					$damage+=5;
			}
			
			if(strpos($keywords, "power:oppMass") !== false){
				$mass = $defendingPokemon->pokeWeight;
				
				if($mass < 10)
					$damage++;
				else if($mass < 25)
					$damage+=2;
				else if($mass < 50)
					$damage+=3;
				else if($mass < 100)
					$damage+=4;
				else if($mass < 200)
					$damage+=5;
				else
					$damage+=6;
			}
			
			if(strpos($keywords, "power:speed") !== false){
				$damage += ($attackingPokemon->speed - $defendingPokemon->speed);
			}
			
			if(strpos($keywords, "chance crit") !== false){
				$damage += mt_rand(0, 1);
			}
			
			if(strpos($keywords, "power:random") !== false){
				$damage += mt_rand(1, 5);
			}
			
			if(strpos($keywords, "bonus:status") !== false){
				if($defendingPokemon->currentStatus['poisoned'] || $defendingPokemon->currentStatus['burned'] || $defendingPokemon->currentStatus['confused'] || $defendingPokemon->currentStatus['paralyzed'] || $defendingPokemon->currentStatus['sleeping'] || $defendingPokemon->currentStatus['trapped'] || $defendingPokemon->currentStatus['exhausted'] || $defendingPokemon->currentStatus['seeded'])
					$damage += 2;
			}
			
			if(strpos($keywords, "power:3") !== false){
				$damage = 3;
			}
			
			if(strpos($keywords, "power:slow") !== false){
				$damage += ($defendingPokemon->speed - $attackingPokemon->speed);
			}
		}
				
		//normalizujemy dmg
				
		if($damage <= 0 && $attackCategory != "S"){
			
			if($modificator > 0)
				$damage = $modificator;
			else
				$damage = 0;
		}
		
		return $damage;
	}
	
	function applyEffects(&$game, &$player, &$playersPokemon, &$opponent, &$opponentsPokemon, $category, $words, $dodge, $damage){
		global $Server;
		
		$keywords = explode(" ", $words);
		$flag = 1;
		
		if(strpos($words, "chance") !== false){
			$flag = mt_rand(0, 1);
		}
		
		for($index = 0; $index < count($keywords); $index++){
			
			if($flag){
				if(strpos($keywords[$index], "stats") !== false){ //zmieniamy statystyki
					$statsInfo = explode(":", $keywords[$index]);
					$value = $statsInfo[count($statsInfo) - 1];
					
					if($statsInfo[1] == "self"){
						if(strpos($statsInfo[2], "attack") !== false)
							$playersPokemon->changeStatAttack($value);
						if(strpos($statsInfo[2], "defence") !== false)
							$playersPokemon->changeStatDefence($value);
						if(strpos($statsInfo[2], "specatt") !== false)
							$playersPokemon->changeStatSpecialAttack($value);
						if(strpos($statsInfo[2], "specdef") !== false)
							$playersPokemon->changeStatSpecialDefence($value);
						if(strpos($statsInfo[2], "speed") !== false)
							$playersPokemon->changeStatSpeed($value);
					}
					else if($statsInfo[1] == "opp" && $dodge == false && ($category == "S" || $damage > 0)){
						if(strpos($statsInfo[2], "attack") !== false)
							$opponentsPokemon->changeStatAttack($value);
						if(strpos($statsInfo[2], "defence") !== false)
							$opponentsPokemon->changeStatDefence($value);
						if(strpos($statsInfo[2], "specatt") !== false)
							$opponentsPokemon->changeStatSpecialAttack($value);
						if(strpos($statsInfo[2], "specdef") !== false)
							$opponentsPokemon->changeStatSpecialDefence($value);
						if(strpos($statsInfo[2], "speed") !== false)
							$opponentsPokemon->changeStatSpeed($value);
					}
				}
				else if(strpos($keywords[$index], "status") !== false){ //zmieniamy status
					$statusInfo = explode(":", $keywords[$index]);
					$value = $statusInfo[count($statusInfo) - 1];
					
					if($statusInfo[1] == "self")
						$playersPokemon->changeCurrentStatus($value);
					else if($statusInfo[1] == "opp" && $dodge == false && ($category == "S" || $damage > 0))
						$opponentsPokemon->changeCurrentStatus($value);
				}
				
				if(strpos($keywords[$index], "weather") !== false){ //zmieniamy pogodę
					$weatherInfo = explode(":", $keywords[$index]);
					$value = $weatherInfo[count($weatherInfo) - 1];
					printf("Game %s: changing weather - %s. \n", $game->gameIndex, $value);
					
					$game->changeWeather($value);
					$Server->wsSend($player->currentID, "Weather:/".$game->weather);
					$Server->wsSend($opponent->currentID, "Weather:/".$game->weather);
				}
			}
			
		}
		
		if(strpos($words, "recoil") !== false){
			$playersPokemon->decreaseHP(2);
		}
		
		if($playersPokemon->currentStatus['confused']){
			$playersPokemon->decreaseHP(1);
		}
		
		if(strpos($words, "drain") !== false && $dodge == false){
			if(strpos($words, "drain:1") !== false)
				$playersPokemon->increaseHP(1);
			else if(strpos($words, "drain:2") !== false)
				$playersPokemon->increaseHP(2);
		}
		
		//efekty unikalne // unique effects
		
		if(strpos($words, "unique") !== false){
			
			if(strpos($words, "RapidSpin") !== false){
				$playersPokemon->currentStatus['trapped'] = false;
				if($playersPokemon->currentStatus['seeded']){
					$opponent->pokemons[$playersPokemon->currentStatus['seeded']]->currentStatus['seeding'] = false;
					$playersPokemon->currentStatus['seeded'] = false;
				}
			}
			
			if(strpos($words, "LeechSeed") !== false && $dodge == false && $opponentsPokemon->typePrimary != "grass" && $opponentsPokemon->typeSecondary != "grass"){
				if($playersPokemon->currentStatus['seeding'])
					$opponent->pokemons[$playersPokemon->currentStatus['seeding']]->currentStatus['seeded'] = false;
				if($opponentsPokemon->currentStatus['seeded'])
					$player->pokemons[$opponentsPokemon->currentStatus['seeded']]->currentStatus['seeding'] = false;
				
				$playersPokemon->currentStatus['seeding'] = $opponentsPokemon->index;
				$opponentsPokemon->currentStatus['seeded'] = $playersPokemon->index;
			}
			
			if(strpos($words, "times:3") !== false && $dodge == false){
				$opponentsPokemon->decreaseHP($player->dmgOnTable);
				$opponentsPokemon->decreaseHP($player->dmgOnTable);
			}
			
			if(strpos($words, "FellStinger") !== false && $dodge == false){
				if($opponentsPokemon->currentHP == 0)
					$playersPokemon->changeStatAttack(2);
			}
			
			if(strpos($words, "Spite") !== false && $dodge == false){
				$opponent->cardOnTable = null;
				$opponent->dmgOnTable = 0;
				$opponent->counter = 0;
			}
			
			if(strpos($words, "Nightmare") !== false && $opponentsPokemon->currentStatus['sleeping'] == 'waking'){
				if(mt_rand(0, 1))
					$opponentsPokemon->currentStatus['sleeping'] = true;
			}
			
			if(strpos($words, "heal:4") !== false && $dodge == false){
				$playersPokemon->increaseHP(4);
			}
			
		}
	}
	
	function dealWithFainted(&$pokemon, &$player, &$opponent){
		if($pokemon->currentStatus['seeded']){
			$opponent->pokemons[$pokemon->currentStatus['seeded']]->currentStatus['seeding'] = false;
			$pokemon->currentStatus['seeded'] = false;
		}
		if($pokemon->currentStatus['seeding']){
			$opponent->pokemons[$pokemon->currentStatus['seeding']]->currentStatus['seeded'] = false;
			$pokemon->currentStatus['seeding'] = false;
		}
		
		$player->withdrawPokemon();
		$opponent->awardPoint();
	}
	
	function goToStatusPhase(&$game, &$player, &$opponent){
		global $Server;
		
		$playersPokemon = $player->pokemons[$player->activePokemon];
		$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
		
		if($game->damageFromStatusesApplied == false){
			
			$playersPokemon->applyDamageFromStatuses($game->weather);
			$opponentsPokemon->applyDamageFromStatuses($game->weather);
			if($opponentsPokemon->currentStatus['seeded'] == $playersPokemon->index)
				$playersPokemon->increaseHP(0.5);
			if($playersPokemon->currentStatus['seeded'] == $opponentsPokemon->index)
				$opponentsPokemon->increaseHP(0.5);
			$game->damageFromStatusesApplied = true;
			
			sendActivePokemonInfo($player, $opponent->currentID);
			sendActivePokemonInfo($opponent, $player->currentID);
			
			if($playersPokemon->currentHP <= 0){
				printf("Game %s: %s's%s has fainted.\n", $game->gameIndex, $player->playerNick, $playersPokemon->pokeName);
				dealWithFainted($playersPokemon, $player, $opponent);
			}
			if($opponentsPokemon->currentHP <= 0){
				printf("Game %s: %s's%s has fainted.\n", $game->gameIndex, $opponent->playerNick, $opponentsPokemon->pokeName);
				dealWithFainted($opponentsPokemon, $opponent, $player);
			}
			
			//sprawdzamy, czy ktoś wygrał
			
			if($player->victory && $opponent->victory){
				printf("Game %s: The game has ended in a draw.\n", $game->gameIndex);
				sendEndGameMessagesDraw($player, $opponent);
				closeGame($game, null);
			}
			else if($player->victory){
				printf("Game %s: The game has ended. %s is the winner.\n", $game->gameIndex, $player->playerNick);
				sendEndGameMessagesNoDraw($player, $opponent);
				closeGame($game, $player);
			}
			else if($opponent->victory){
				printf("Game %s: The game has ended. %s is the winner.\n", $game->gameIndex, $opponent->playerNick);
				sendEndGameMessagesNoDraw($opponent, $player);
				closeGame($game, $opponent);
			}
			else{
			
				if($opponent->activePokemon == 0){
					sendAskToPickPockemon($opponent->currentID, $player->currentID);
				}
				else if($player->activePokemon == 0){
					sendAskToPickPockemon($player->currentID, $opponent->currentID);
				}
				else{
					goToNextTurn($game, $player, $opponent);
				}
			}

		}
		else{
			goToNextTurn($game, $player, $opponent);
		}
	}
	
	function goToNextTurn(&$game, &$player, &$opponent){
		global $Server, $attackDex, $numberOfGames;
		
		$opponentsPokemon = $opponent->pokemons[$opponent->activePokemon];
		$player->hasTurn = false;
		$opponent->hasTurn = true;
		$game->activePlayer = 3 - $game->activePlayer;
		$game->damageFromStatusesApplied = false;
		$opponent->hasDiscarded = false;
		
		$player->rps = null;
		$opponent->rps = null;
		
		if($opponentsPokemon->currentStatus['sleeping'] === 'waking'){
			$opponentsPokemon->currentStatus['sleeping'] = false;
			printf("Game %s: %s's %s has awaken.", $game->gameIndex, $opponent->playerNick, $opponentsPokemon->pokeName);
		}
		
		for($index=1; $index<6; $index++){
			if($opponent->playerHand[$index] == 0){
			
				$temp = $opponent->drawCard($index);
				
				if($temp[0] == "OK"){
					
					$data = $attackDex->readCard($opponent->playerHand[$index]);
					$data = json_encode($data);
					$Server->wsSend($opponent->currentID, "Card:/".$index."/".$data);
					$Server->wsSend($opponent->currentID, "Cards left:/".$temp[1]);
					$Server->wsSend($player->currentID, "OpCards left:/".$temp[1]);
				}
				else if($temp[0] == "end of deck"){
					$game->endingGame = true;
					$player->victory = true;
					printf("Game %s: The game has ended. %s is the winner.\n", $game->gameIndex, $player->playerNick);
					sendEndGameMessagesNoDraw($player, $opponent);
				}
				else{
					printf("Game %s: %s's draw error: wrong hand index or slot not empty.", $game->gameIndex, $opponent->playerNick);
				}
			}
		}
		
		if($game->endingGame == false){
			$opponentsPokemon->increaseEnergy(1);
			sendActivePokemonInfo($opponent, $player->currentID);
						
			if($opponent->cardOnTable)			
				$Server->wsSend($opponent->currentID, "Continue:/true");
			else
				$Server->wsSend($opponent->currentID, "Continue:/false");
			
			$Server->wsSend($opponent->currentID, "Your turn!");
			$Server->wsSend($player->currentID, "Opponent's turn!");
		}
		else
			closeGame($game, $player);
	}
	
	function closeGame(&$game, &$player){
		global $numberOfGames;
		
		if($player){
			increaseWins($player->playerID);
		}
		
		unset($game);
		$numberOfGames--;
	}
	
	function dealWithConcedeRequest(&$game, &$player, &$opponent){
		global $Server;
		
		$opponent->victory = true;
		$game->endingGame = true;
		
		sendEndGameMessagesNoDraw($opponent, $player);
		closeGame($game, $opponent);
	}
	
	function increaseWins($id){
		require "connect.php";
		try{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
		
				if($result = $connection->query("SELECT wins FROM players WHERE id=".$id)){
					
					$data = $result->fetch_assoc();
					$result->free_result();
					$wins = implode($data);
					$wins++;
					$connection->query("UPDATE players SET wins='$wins' WHERE id='$id'");
				}
				else throw new Exception($connection->error);
				
			}
			$connection->close();
		}
		catch(Exception $err){
			printf('Błąd serwera. Przepraszamy. Spróbuj ponownie później.');
			printf('Informacja deweloperska: '.$err);
		}	
	}
	
    // Tworzymy klasę, podłączamy naszą funckję i uruchamiamy serwer 
    $Server = new PHPWebSocket();
    $Server->bind('message', 'wsOnMessage');
    $Server->wsStartServer('127.0.0.1', 9000);
	
?>