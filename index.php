<?php

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
 <body >
	<header>
		<nav class="navbar navbar-dark bg navbar-expand-sm">
		
			<a class="navbar-brand" href="index.php"><img src="img/2.png" width="25" height="25" class="d-inline-block mr-1 align-top" alt=""><span style="color: #c34f4f">Personal</span> 
			<span style="color: black">Budget</span></a>
		
		
			<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu" >	
					
					<form class="form-inline ml-auto" action="registration.php" >
					<button class="btn btn-info mr-1" type="submit" >Utwórz Konto</button>
					</form>
					<form class="form-inline " action = "login.php">
					<button class="btn btn-info" type="submit" >Zaloguj</button>
				
					</form>
					
			</div>
		
		
		</nav>
	</header>
	
	<main>
		<article>
			<div class="content" >
				<div class="row">
					<div class=" col-md-12">
						<div class="info">
						<img src="img/2.png" width="32" height="32" alt="">
						<span style="color: #c34f4f">Personal</span>
						<span style="color: black">Budget</span>
						
						<h1 >Prosta aplikacja do prowadzenia budżetu domowego</h1>
						
						<h2>Przejmij kontrolę nad swoimi finansami! Załóż darmowe konto i zacznij oszczędzać już dziś.<h2>
						<form class="text-center" action = "registration.php"> 
							<button class="btn btn-info mr-1" type="submit">Utwórz Konto</button>
						</form>
					
						</div>
					</div>
				</div>
			
			</div>
		</article>
		<section class="bg-secondary text-center ">
			<div class="container">
			    <div class="row m-0">
					<div class="col-md-4 ">
						 <div class="button1">
								<i class="icon-money" ></i>
								<h3>ZA DARMO</h3>
								<p>Kompletnie darmowa aplikacja na Twoje urzadzenie mobilne</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="button1">
							<i class="icon-mobile" ></i>
							<h3>WYGODNIE</h3>
							<p>Spisuj wydatki na telefonie, tablecie, komputerze - gdziekolwiek jesteś, tak jak będzie Ci najwygodniej.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="button1">
							<i class="icon-users" ></i>
							<h3>DLA KAŻDEGO</h3>
							<p>Nigdy nie prowadziłeś budżetu? Ta aplikacja jest własnie dla Ciebie! Pokierujemy Cie krok po kroku jak zacząć oszędzać!</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<footer class="page-footer fixed-bottom">
				<div id="footer">
				&copy Personal Budget| Korzystanie z serwisu oznacza akceptację regulaminu i polityki prywatności.
				</div>
		</footer>
  
 


   
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
 </body>
</html>