<?php

	session_start();
	if(isset($_SESSION['user_log_in'])&&($_SESSION['user_log_in']==true))
	{
		header('Location: mainmenu.php');
		exit();
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
						
						<form class="form-inline ml-auto " action="registration.php">
							
								<button class="btn btn-info" type="submit">Utwórz konto</button>
							
						
						</form>
						
				</div>
			
			
			</nav>
		</header>
		<main>
			<div class="panlog shadow-lg mx-auto">
				<form class="text-center" action="log.php" method="post">
				  <div class="mb-3 mt-5">
					<label for="Login" class="form-label">Login</label>
					<input type="login" class="form-control" id="Login" name="login" aria-describedby="loginHelp" placeholder="Login" >
				  </div>
				  <div class="mb-3">
					<label for="Password" class="form-label">Hasło</label>
					<input type="password" class="form-control" id="Password" name="haslo" placeholder="Hasło" >
				  </div>
				  
				  <button type="submit" class="btn btn-info">Zaloguj</button>
				</form>
				<div style="text-align:center; margin-top:10px;">
				<?php
					if(isset($_SESSION['error']))
					{
					echo $_SESSION['error'];
					}
				?>
				</div>
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