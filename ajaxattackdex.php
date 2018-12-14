<?php
 	require_once "connect.php";
	
	$query = 'SELECT id, attackname, type, category FROM attackdex WHERE type="normal" OR type="fire" OR type="flying"';
	
	if($_POST['typesec']==NULL)
		$query = 'SELECT id, attackname, type, category FROM attackdex WHERE type="'.$_POST['typeprim'].'" OR type="normal" OR signature="'.$_POST['name'].'"';
	else
		$query = 'SELECT id, attackname, type, category FROM attackdex WHERE type="'.$_POST['typeprim'].'" OR type="'.$_POST['typesec'].'" OR type="normal" OR signature="'.$_POST['name'].'"';
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			if($result=$connection->query($query)){
				$rowcount=mysqli_num_rows($result);
				for($i=1; $i<$rowcount+1; $i++){
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
		}
		
	echo json_encode($attackdex);
?>

