<?php
	//session_start();
	$query = "SELECT * from pokedex, pokemons WHERE pokemons.playerid=".$_POST['playerid']." AND pokemons.pokenumber=pokedex.number";
	
 	require_once "connect.php";
	
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
		}
		
	echo json_encode($pokemon);
?>

