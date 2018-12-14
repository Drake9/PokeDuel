<?php

define("POKE_MAX_ENERGY", 5, true);
define("STARTING_ENERGY", 3, true);
define("HEALTH_MODIFICATOR", 6, true);
define("HEALTH_MULTIPLIER", 2, true);
define("DECK_SIZE", 36, true);

class card{
	
	public $cardID;
	public $attackName;
	public $attackType;
	public $attackCategory;
	public $attackPower;
	public $attackCost;
	public $attackKeywords;
	public $attackDescription;
	public $attackSignature;
	
	function __construct($ID, $name, $type, $category, $power, $cost, $keywords, $description, $signature){
		
		$this->cardID = $ID;
		$this->attackName = $name;
		$this->attackType = $type;
		$this->attackCategory = $category;
		$this->attackPower = $power;
		$this->attackCost = $cost;
		$this->attackKeywords = $keywords;
		$this->attackDescription = $description;
		$this->attackSignature = $signature;
	}
}

class attackdex{
	
	public $attackdex = array();
	
	function __construct(){
		$data = getAttackdex();
		$size = count($data);
		
		for($index=1; $index<=$size; $index++){
			$this->attackdex[$index] = new card($data[$index]['id'], $data[$index]['attackname'], $data[$index]['type'], $data[$index]['category'], $data[$index]['power'], $data[$index]['cost'], $data[$index]['keywords'], $data[$index]['description'], $data[$index]['signature']);
		}
	}
	
	function readCard($searchedID){
		if($searchedID > 0)
			return $this->attackdex[$searchedID];
		else
			return $this->attackdex[1];
	}
}

class pokemon{
	
	public $index;
	public $pokeNumber;
	public $pokeName;
	public $typePrimary;
	public $typeSecondary;
	public $pokeSpecies;
	public $pokeHeight;
	public $pokeWeight;
	public $pokeAbilities;
	
	public $maxHP;
	public $attack;
	public $defence;
	public $specialAttack;
	public $specialDefence;
	public $speed;
	
	public $currentHP;
	public $currentEnergy;
	public $currentStatus = array("poisoned", "burned", "confused", "paralyzed", "sleeping", "trapped", "frozen", "hidden", "exhausted", "seeded", "seeding");
	public $active;
	
	//RESISTANCES AND WEAKNESSES
	
	public $normal;
	public $fire;
	public $water;
	public $electric;
	public $grass;
	public $ice;
	public $fighting;
	public $poison;
	public $ground;
	public $flying;
	public $psychic;
	public $bug;
	public $rock;
	public $ghost;
	public $dragon;
	public $darkness;
	public $steel;
	public $fairy;
	
	function __construct($index, $number, $name, $primary, $secondary, $species, $height, $weight, $abilities, $health, $att, $def, $spatt, $spdef, $spd, $norm, $fir, $wat, $ele, $grs, $ice, $fight, $pois, $grd, $fly, $psy, $bug, $rck, $ghst, $drg, $dark, $stl, $fry){
		
		$this->index = $index;
		$this->pokeNumber = $number;
		$this->pokeName = $name;
		$this->typePrimary = $primary;
		$this->typeSecondary = $secondary;
		$this->pokeSpecies = $species;
		$this->pokeHeight = $height;
		$this->pokeWeight = $weight;
		$this->pokeAbilities = $abilities;
		
		$this->maxHP = $health * constant("HEALTH_MULTIPLIER") + constant("HEALTH_MODIFICATOR");
		$this->attack = $att;
		$this->defence = $def;
		$this->specialAttack = $spatt;
		$this->specialDefence = $spdef;
		$this->speed = $spd;
		
		$this->currentHP = $health * constant("HEALTH_MULTIPLIER") + constant("HEALTH_MODIFICATOR");
		$this->currentEnergy = constant("STARTING_ENERGY");
		$this->currentStatus['poisoned'] = false;
		$this->currentStatus['burned'] = false;
		$this->currentStatus['confused'] = false;
		$this->currentStatus['paralyzed'] = false;
		$this->currentStatus['sleeping'] = false;
		$this->currentStatus['trapped'] = false;
		$this->currentStatus['frozen'] = false;
		$this->currentStatus['hidden'] = false;
		$this->currentStatus['exhausted'] = false;
		$this->currentStatus['seeded'] = false;
		$this->currentStatus['seeding'] = false;
		$this->active = false;
		
		$this->normal = $norm;
		$this->fire = $fir;
		$this->water = $wat;
		$this->electric = $ele;
		$this->grass = $grs;
		$this->ice = $ice;
		$this->fighting = $fight;
		$this->poison = $pois;
		$this->ground = $grd;
		$this->flying = $fly;
		$this->psychic = $psy;
		$this->bug = $bug;
		$this->rock = $rck;
		$this->ghost = $ghst;
		$this->dragon = $drg;
		$this->darkness = $dark;
		$this->steel = $stl;
		$this->fairy = $fry;
	}
	
	//FUNCTIONS FOR DECREASING OR INCREASING HEALTH OR ENERGY
	
	function decreaseHP($amount){
		if($amount > 0){
			$this->currentHP = $this->currentHP - $amount;
			if($this->currentHP < 0)
				$this->currentHP = 0;
			
			if($this->currentStatus['sleeping'] == true){
				$this->currentStatus['sleeping'] = 'waking';
				printf("Waking...");
			}
		}
	}
	
	function increaseHP($amount){
		if($amount > 0){
			$this->currentHP = $this->currentHP + $amount;
			if($this->currentHP > $this->maxHP)
				$this->currentHP = $this->maxHP;
		}
	}
	
	function decreaseEnergy($amount){
		if($amount > 0){
			$this->currentEnergy = $this->currentEnergy - $amount;
			if($this->currentEnergy < 0)
				$this->currentEnergy = 0;
		}
	}
	
	function increaseEnergy($amount){
		if($amount > 0){
			$this->currentEnergy = $this->currentEnergy + $amount;
			if($this->currentEnergy > constant("POKE_MAX_ENERGY"))
				$this->currentEnergy = constant("POKE_MAX_ENERGY");
		}
	}
	
	//FUNCTIONS FOR CHANGING STATS
	
	function changeStatAttack($amount){
		$this->attack = $this->attack + $amount;
		if($this->attack < 0)
			$this->attack = 0;
	}
	
	function changeStatDefence($amount){
		$this->defence = $this->defence + $amount;
		if($this->defence < 0)
			$this->defence = 0;
	}
	
	function changeStatSpecialAttack($amount){
		$this->specialAttack = $this->specialAttack + $amount;
		if($this->specialAttack < 0)
			$this->specialAttack = 0;
	}
	
	function changeStatSpecialDefence($amount){
		$this->specialDefence = $this->specialDefence + $amount;
		if($this->specialDefence < 0)
			$this->specialDefence = 0;
	}
	
	
	function changeStatSpeed($amount){
		$this->speed = $this->speed + $amount;
		if($this->speed < 0)
			$this->speed = 0;
	}
	
	//FUNCTIONS FOR CHANGING STATUS
	
	function changeCurrentStatus($status){
		switch ($status){
			
			case "poisoned":
				if($this->typePrimary != "poison" && $this->typeSecondary != "poison" && $this->typePrimary != "steel" && $this->typeSecondary != "steel")
					$this->currentStatus['poisoned'] = true;
				break;
				
			case "burned":
				if($this->typePrimary != "fire" && $this->typeSecondary != "fire")
					$this->currentStatus['burned'] = true;
				break;
				
			case "confused";
				$this->currentStatus['confused'] = true;
				break;
			case "paralyzed";
				$this->currentStatus['paralyzed'] = true;
				break;
			case "sleeping";
				$this->currentStatus['sleeping'] = true;
				break;
			case "trapped";
				$this->currentStatus['trapped'] = true;
				break;
			case "frozen";
				$this->currentStatus['frozen'] = true;
				break;
			case "hidden";
				$this->currentStatus['hidden'] = true;
				break;
			case "exhausted";
				$this->currentStatus['exhausted'] = true;
				break;
		}
	}
	
	function setActive(){
		$this->active = true;
	}
	
	function setInactive(){
		$this->active = false;
		
		$this->currentStatus['confused'] = false;
		$this->currentStatus['paralyzed'] = false;
		//$this->currentStatus['sleeping'] = false;
		$this->currentStatus['hidden'] = false;
		$this->currentStatus['exhausted'] = false;
	}
	
	//FUNCTION FOR RETURNING STATS IN ASSOCIATIVE ARRAY
	
	function getStats(){
		$poisoned = $this->currentStatus['poisoned'];
		$burned = $this->currentStatus['burned'];
		$confused = $this->currentStatus['confused'];
		$paralyzed = $this->currentStatus['paralyzed'];
		$sleeping = $this->currentStatus['sleeping'];
		$trapped = $this->currentStatus['trapped'];
		$frozen = $this->currentStatus['frozen'];
		$hidden = $this->currentStatus['hidden'];
		$exhausted = $this->currentStatus['exhausted'];
		$seeded = $this->currentStatus['seeded'];
		$seeding = $this->currentStatus['seeding'];
		
		$requestedData = ["pokeNumber"=>"$this->pokeNumber", "pokeName"=>"$this->pokeName", "typePrimary"=>"$this->typePrimary", "typeSecondary"=>"$this->typeSecondary", "pokeSpecies"=>"$this->pokeSpecies", "pokeHeight"=>"$this->pokeHeight", "pokeWeight"=>"$this->pokeWeight", "pokeAbilities"=>"$this->pokeAbilities", "maxHP"=>"$this->maxHP", "attack"=>"$this->attack", "defence"=>"$this->defence", "specialAttack"=>"$this->specialAttack", "specialDefence"=>"$this->specialDefence", "speed"=>"$this->speed", "currentHP"=>"$this->currentHP", "currentEnergy"=>"$this->currentEnergy", "poisoned"=>"$poisoned", "burned"=>"$burned", "confused"=>"$confused", "paralyzed"=>"$paralyzed", "sleeping"=>"$sleeping", "trapped"=>"$trapped", "frozen"=>"$frozen", "hidden"=>"$hidden", "exhausted"=>"$exhausted", "seeded"=>"$seeded", "seeding"=>"$seeding"];
		
		return $requestedData;
	}
	
	function getWRModificator($type){
		switch ($type){
			case "normal":
				$modificator = $this->normal;
				break;
			case "fire":
				$modificator = $this->fire;
				break;
			case "water":
				$modificator = $this->water;
				break;
			case "electric":
				$modificator = $this->electric;
				break;
			case "grass":
				$modificator = $this->grass;
				break;
			case "ice":
				$modificator = $this->ice;
				break;
			case "fighting":
				$modificator = $this->fighting;
				break;
			case "poison":
				$modificator = $this->poison;
				break;
			case "ground":
				$modificator = $this->ground;
				break;
			case "flying":
				$modificator = $this->flying;
				break;
			case "psychic":
				$modificator = $this->psychic;
				break;
			case "bug":
				$modificator = $this->bug;
				break;
			case "rock":
				$modificator = $this->rock;
				break;
			case "ghost":
				$modificator = $this->ghost;
				break;
			case "dragon":
				$modificator = $this->dragon;
				break;
			case "darnkess":
				$modificator = $this->darkness;
				break;
			case "steel":
				$modificator = $this->steel;
				break;
			case "fairy":
				$modificator = $this->fairy;
				break;
		}
		if($modificator >= 1)
			$modificator *= 2;
		return $modificator;
	}
	
	function applyDamageFromStatuses($weather){
		if($this->currentStatus['poisoned'] == true)
			$this->decreaseHP(0.5);
		if($this->currentStatus['burned'] == true)
			$this->decreaseHP(0.5);
		if($this->currentStatus['trapped'] == true)
			$this->decreaseHP(0.5);
		if($this->currentStatus['seeded'] == true)
			$this->decreaseHP(0.5);
		
		if($weather == "sandstorm" && ($this->typePrimary != "ground" && $this->typePrimary != "rock" && $this->typePrimary != "steel") && ($this->typeSecondary != "ground" && $this->typeSecondary != "rock" && $this->typeSecondary != "steel"))
			$this->decreaseHP(0.5);
		else if($weather == "hailstorm" && $this->typePrimary != "ice" && $this->typeSecondary != "ice")
			$this->decreaseHP(0.5);
	}
}

class player{
	
	public $playerID;
	public $currentID;
	public $playerNick;
	public $inGame;
	
	public $hasTurn;
	public $hasDiscarded;
	public $rps;
	public $cardOnTable;
	public $dmgOnTable;
	public $counter;
	
	public $pokemons = array(); 
	public $activePokemon;
	
	public $knownOpPokemons = array(1=>false, 2=>false, 3=>false, 4=>false, 5=>false, 6=>false);
	
	public $playerDeck = array();
	public $playerHand = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
	public $playerDeckIndex;
	
	public $points;
	public $victory;
	
	function __construct($nick){
		
		$this->playerID = getPlayerID($nick);
		$this->currentID = 0;
		$this->playerNick = $nick;
		$this->inGame = true;
		
		$this->hasTurn = false;
		$this->hasDiscarded = false;
		$this->rps = null;
		$this->cardOnTable = null;
		$this->dmgOnTable = 0;
		$this->counter = 0;
		
		$this->points = 0;
		$this->victory = false;
		
		//GET INFO ABOUT PLAYER'S POKEMON AND CARDS
		
		$data = getPlayerPokemons($this->playerID);
		
		for($i=1; $i<7; $i++){
			$this->pokemons[$i] = new pokemon($i, $data[$i]['number'], $data[$i]['name'], $data[$i]['typeprim'], $data[$i]['typesec'], $data[$i]['species'], $data[$i]['height'], $data[$i]['weight'], $data[$i]['abilities'], $data[$i]['hp'], $data[$i]['attack'], $data[$i]['defence'], $data[$i]['specattack'], $data[$i]['specdefence'], $data[$i]['speed'], $data[$i]['normal'], $data[$i]['fire'], $data[$i]['water'], $data[$i]['electric'], $data[$i]['grass'], $data[$i]['ice'], $data[$i]['fighting'], $data[$i]['poison'], $data[$i]['ground'], $data[$i]['flying'], $data[$i]['psychic'], $data[$i]['bug'], $data[$i]['rock'], $data[$i]['ghost'], $data[$i]['dragon'], $data[$i]['darkness'], $data[$i]['steel'], $data[$i]['fairy']);
		}
		
		$this->activePokemon = 0;
		
		for($ijk=1; $ijk<7; $ijk++)
			$this->knownOpPokemons[$ijk] = false;
		
		for($i=1; $i<7; $i++){
			for($j=1; $j<7; $j++){
				$this->playerDeck[6*($i-1)+$j] = $data[$i]['attack'.$j];
			}
		}
		
		shuffle($this->playerDeck);
		$this->playerDeckIndex = 1;
		
		for($i=1; $i<6; $i++)
			$this->drawCard($i);
		
	}
	
	function drawCard($indexHand){
		
		if($this->playerHand[$indexHand] != 0){
			$temp = array("slot not empty", null);
			return $temp;
		}
		else if($this->playerDeckIndex > constant("DECK_SIZE")){
			$temp = array("end of deck", null);
			return $temp;
		}		
		else{

			$this->playerHand[$indexHand] = $this->playerDeck[$this->playerDeckIndex];
			$this->playerDeckIndex++;
			
			$temp = array("OK", constant("DECK_SIZE") - $this->playerDeckIndex + 1);
			return $temp;
		}
	}
	
	function withdrawPokemon(){
		
		$this->pokemons[$this->activePokemon]->increaseEnergy(1);
		$this->pokemons[$this->activePokemon]->setInactive();
		$this->activePokemon = 0;
		
		$this->cardOnTable = NULL;
		$this->counter = 0;
		$this->dmgOnTable = 0;
	}
	
	function choosePokemon($number){
		
		$this->pokemons[$number]->setActive();
		$this->activePokemon = $number;
	}
	
	function increaseCounter(){
		
		$this->counter++;
	}
	
	function awardPoint(){
		$this->points++;
		if($this->points == 6 || ($this->points == 5 && $this->pokemons[$this->activePokemon]->currentStatus['sleeping']))
			$this->victory = true;
	}
	
}

class game{
	
	public $gameIndex;
	public $startingGame;
	public $endingGame;
	public $damageFromStatusesApplied;
	public $activePlayer;
	public $weather;
	public $rps;
	
	public $player1;
	public $player2;
	
	function __construct($nick1, $nick2, $index){
		
		$this->gameIndex = $index;
		$this->player1 = new player($nick1);
		$this->player2 = new player($nick2);
		
		$this->activePlayer = 2;
		$this->startingGame = true;
		$this->endingGame = false;
		$this->damageFromStatusesApplied = false;
		
		$this->weather = "clear skies";
		$this->rps = false;
	}
	
	function changeWeather($something){
		$this->weather = $something;
	}
	
}

function getPlayerID($nick){
	require "connect.php";
	
	$query = 'SELECT id FROM players WHERE nick="'.$nick.'"';
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			if($result=$connection->query($query)){
				$searchedID = $result->fetch_assoc();		
				$result->free_result();
			}
			else throw new Exception($connection->error);
		}
		$connection->close();
	}
	catch(Exception $err){
		echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
		echo '<br/>Informacja deweloperska: '.$err;
		return $err;
	}
	
	$searchedID = implode($searchedID);
	return $searchedID;
}

function getPlayerPokemons($playerID){
	require "connect.php";
	
	//$playerID = implode($playerID);
	$query = "SELECT * from pokedex, pokemons WHERE pokemons.playerid=".$playerID." AND pokemons.pokenumber=pokedex.number";
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			
			if($result=$connection->query($query)){
				for($i=1; $i<7; $i++){
					$pokemon[$i] = $result->fetch_assoc();
				}	
			}
			else throw new Exception($connection->error);
			
		}
		$connection->close();
	}
	catch(Exception $err){
			echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
			echo '<br/>Informacja deweloperska: '.$err;
			return $err;
		}
		
	return $pokemon;	
}

function getAttackdex(){
	require "connect.php";
	
	$query = "SELECT * from attackdex";
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			
			if($result=$connection->query($query)){
				$rowCount = mysqli_num_rows($result);
				for($i=1; $i<$rowCount+1; $i++){
					$attackdex[$i] = $result->fetch_assoc();
				}	
			}
			else throw new Exception($connection->error);
			
		}
		$connection->close();
	}
	catch(Exception $err){
		echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
		echo '<br/>Informacja deweloperska: '.$err;
		return $err;
	}
		
	return $attackdex;	
}

?>