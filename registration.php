<?php

	session_start();
	if(isset($_SESSION['user_log_in']))
	{
		header ('Location: mainmenu.php');
		exit();
	}

	if (isset($_POST['email']))
	{
		//Udana walidacja
		$all_OK = true;
		
		// Sprawdzamy login
		$login = $_POST['login'];
		
		//sprawdzenie dlugosci loginu
		if((strlen($login)<3)||(strlen($login)>20))
		{
			$all_OK = false;
			$_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków";
			
		}
		if(ctype_alnum($login)==false)
		{
			$all_OK = false;
			$_SESSION['e_login'] = "Login może składać się tylko z liter i cyfr(bez polskich znaków)";
		
		}
		
		//sprawdz adres mail
		
		$email = $_POST['email'];
		$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
		{
			$all_OK = false;
			
			$_SESSION['e_email'] = "Podaj poprawny adres email";
		}
		$password = $_POST['password'];
		
		if((strlen($password)<8)||(strlen($password)>20))
		{
			$all_OK = false;
			$_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
			
		}
		
		$password_hash = password_hash($password,PASSWORD_DEFAULT);
		
		

	
		$_SESSION['fr_login'] = $login;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password'] = $password;
		
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connect = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connect->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$result = $connect->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connect->error);
				
				$how_many_email = $result->num_rows;
				if($how_many_email>0)
				{
					$all_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$result = $connect->query("SELECT id FROM users WHERE username='$login'");
				
				if (!$result) throw new Exception($connect->error);
				
				$how_many_login = $result->num_rows;
				if($how_many_login>0)
				{
					$all_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($all_OK==true)
				{
					if ($connect->query("INSERT INTO users VALUES 
					(NULL, '$login','$password_hash','$email')"))
					{
						if($connect->query("INSERT INTO expenses_category_assigned_to_users(user_id, name) SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN expenses_category_default AS d WHERE u.email='$email'"))
						{
							if($connect->query("INSERT INTO incomes_category_assigned_to_users(user_id, name) SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN incomes_category_default AS d WHERE u.email='$email'"))
							{
								if($connect->query("INSERT INTO payment_methods_assigned_to_users(user_id, name) SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN payment_methods_default AS d WHERE u.email='$email'"))
								{
									
								    header('Location: login.php');
								}
								else
								{
									throw new Exception($connection->error);
								}	
							}
							else
							{
								throw new Exception($connection->error);
							}
							
						}
						else
						{
							throw new Exception($connection->error);
						}	
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				$connect->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
	}
?>
<!doctype html>
<html lang="pl">
 <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Aplikacja do kontroli domowego budżetu" />
	<meta name="keywords" content="finanse, oszczednosci , domowy budzet, kontrola" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="css/dolar.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
<style>
.error
{
	color:red;
	margin-top: 10px;
	margin-bottom: 10px;
	
}
</style>

    <title>Personal Budget</title>
 </head>
 <body class="bg-custom">
	 <header>
			<nav class="navbar navbar-dark bg navbar-expand-sm">
			
				<a class="navbar-brand" href="index.php"><img src="img/2.png" width="25" height="25" class="d-inline-block mr-1 align-top" alt=""><span style="color: #c34f4f">Personal</span> 
				<span style="color: black">Budget</span></a>
			
			
				<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse" id="mainmenu" >	
						
						<form class="form-inline ml-auto" action = "login.php">
							<button class="btn btn-info" type="submit">Zaloguj</button>
				
						</form>
				</div>
			
			
			</nav>
		</header>
		<main>
			<div class="panlog shadow-lg mx-auto">
				<form class="text-center" method="post">
				  <div class="mb-2 mt-3">
					<label for="Login" class="form-label">Login</label>
					<input type="login" class="form-control" id="Login" name = "login" aria-describedby="loginHelp" placeholder="Login" >
					<?php
					
					if(isset($_SESSION['e_login']))
					{
						echo'<div class="error">'.$_SESSION['e_login'].'</div>';
						unset($_SESSION['e_login']);
					}
					?>
				  </div>
				  <div class="mb-2">
					<label for="e-mail" class="form-label">Adres e-mail</label>
					<input type="e-mail" class="form-control" id="e-mail" name = "email" placeholder="Adres e-mail" >
					<?php
					
					if(isset($_SESSION['e_email']))
					{
						echo'<div class="error">'.$_SESSION['e_email'].'</div>';
						unset($_SESSION['e_email']);
					}
					?>
				  </div>
				  <div class="mb-2">
					<label for="Password" class="form-label">Hasło</label>
					<input type="password" class="form-control" id="Password" name = "password" placeholder="Hasło" >
					<?php
					
					if(isset($_SESSION['e_password']))
					{
						echo'<div class="error">'.$_SESSION['e_password'].'</div>';
						unset($_SESSION['e_password']);
					}
					?>
				  </div>
				  
				  <button type="submit" class="btn btn-info">Zarejestruj</button>
				  
				</form>
			</div>
		</main>
		<footer class="page-footer fixed-bottom">
				<div id="footer">
				&copy Personal Budget| Korzystanie z serwisu oznacza akceptację regulaminu i polityki prywatności.
				</div>
		</footer>
 
 
 
 </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
</html>