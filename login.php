<?php

	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['password']))){
		header('Location: index.php');
		exit();
	}	
	
	require_once "connect.php";
	
	try{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{	
			
			$login = $_POST['login'];
			$password = $_POST['password'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			
			if($result = $connection->query(sprintf("SELECT * FROM players WHERE nick='%s'", mysqli_real_escape_string($connection, $login)))){
				
				$number_of_users = $result->num_rows;
				
				if($number_of_users>0){
					
					$row = $result->fetch_assoc();
					
					if(password_verify($password,$row['password'])){
						
						$_SESSION['loggedin'] = true;
						
						$_SESSION['playerid'] = $row['id'];
						$_SESSION['user'] = $row['nick'];
						$_SESSION['useremail'] = $row['email'];
						$_SESSION['since'] = $row['since'];
						
						unset($_SESSION['loginerror']);
						$result->free_result();
						header('Location: playerpanel.php');
					}
					else{
						$_SESSION['loginerror'] = '<span style = "color:red">Nieprawidłowy login lub hasło!</span>';
						header('Location: index.php');
					}
					
				}
				else{
					$_SESSION['loginerror'] = '<span style = "color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}
			else{
				throw new Exception($connection->error);
			}
		
			$connection->close();
		}
	}
	catch(Exception $err){
			echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
			echo '<br/>Informacja deweloperska: '.$err;
		}
?>