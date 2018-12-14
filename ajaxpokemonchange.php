<?php
 	require_once "connect.php";
	
	//$pokemonid = ($_POST['playerid'] - 1) * 6 + $_POST['focused'];
	$query = 'UPDATE pokemons SET pokenumber='.$_POST['wanted'].', attack1=1, attack2=1, attack3=1, attack4=2, attack5=2, attack6=2 WHERE playerid='.$_POST['playerid'].' AND id='.$_POST['focused'];
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			
			if($result=$connection->query($query)){
				$donothing='Wstawienie powinno zadzialac.';
				}	
			else throw new Exception($connection->error);
			
		}
		
		$connection->close();
	}
	catch(Exception $err){
			echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
			echo '<br/>Informacja deweloperska: '.$err;
		}
?>

