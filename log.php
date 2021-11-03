<?php
	session_start();
	
	if((!isset($_POST['login']))||(!isset($_POST['haslo'])))
	{
		header('Location:login.php');
		exit();
	}
	
	require_once"connect.php";
	
	$connect = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($connect ->connect_errno!=0)
	{
		
		echo "Error:.".$connect->connect_errno;
	}
	else
	{
	
	
		$haslo = $_POST['haslo'];
		$login = $_POST['login'];	
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($result = @$connect->query(
		sprintf("SELECT * FROM users WHERE username='%s'",
		mysqli_real_escape_string($connect,$login))))
		{
			$how_many_users = $result->num_rows;
			
			if($how_many_users>0)
			{	
				$row = $result->fetch_assoc();
			
				if (password_verify($haslo, $row['password']))
				{
					$_SESSION['user_log_in'] = true;
					$_SESSION['id'] = $row['id'];
					
					unset($_SESSION['error']);
					
					$result->close();
					
					header('Location: mainmenu.php');
				}
				else 
				{
					$_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: login.php');
				}
				
			}
			else
			{
				$_SESSION['error']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				
				header('Location:login.php');
				
			}
		}
		$connect->close();
	}

?>


