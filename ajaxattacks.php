<?php
 	require_once "connect.php";
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			
			for($j=1; $j<7; $j++){
				if($result=$connection->query("SELECT pokemons.id, attackdex.* FROM pokemons, attackdex WHERE pokemons.playerid=".$_POST['playerid']." AND pokemons.attack".$j."=attackdex.id ")){
					for($i=1; $i<7; $i++){
						$attacks[6*($i-1)+$j] = $result->fetch_assoc();
					}	
				}
				else throw new Exception($connection->error);
			}
			
		}
		$connection->close();
	}
	catch(Exception $err){
			echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
			echo '<br/>Informacja deweloperska: '.$err;
		}
		
	echo json_encode($attacks);
?>

