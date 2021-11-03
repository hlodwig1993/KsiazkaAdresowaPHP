<?php
	session_start();
	
	if(!isset($_SESSION['user_log_in']))
	{
		header('Location: login.php');
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
	
		<nav class="navbar navbar-gray bg navbar-expand-lg">
		
			<a class="navbar-brand" href="mainmenu.php"><img src="img/2.png" width="25" height="25" class="d-inline-block mr-1 align-top" alt=""><span style="color: #c34f4f">Personal</span> 
			<span style="color: black">Budget</span></a>
		
			<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav mr-auto ml-4">
				
					<li class="nav-item">
						<a class="nav-link" href="addIncome.php"> Dodaj Przychód</a>
					</li>
					
						
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="addExpense.php">Dodaj Wydatek </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="balance.php"> Przeglądaj Bilans</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"> Ustawienia </a>
					</li>
				
				</ul>
			
				<form class="form-inline" action="logout.php" >
					<button class="btn btn-light" type="submit">Wyloguj</button>
				
				</form>
			
			</div>
		
		</nav>
	
	</header>
	
	<main>
		<article class="text-center">
			<p><h1>Wprowadzenie</h1></p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vulputate laoreet dictum. Morbi et odio molestie, dignissim ipsum eu, sodales elit. Proin odio felis, dapibus ut rhoncus eget, tristique ultricies augue. Mauris laoreet tellus vel odio mattis gravida. Sed volutpat volutpat lacus at venenatis. Maecenas eu nulla ac lorem accumsan rutrum vitae quis tellus. Nulla sed eros quis ligula feugiat lobortis. Sed sit amet faucibus lacus, eu cursus nunc. Nam at urna dignissim eros pellentesque accumsan. Nullam maximus, felis nec auctor interdum, velit nunc suscipit elit, in maximus lacus arcu vehicula ex. Curabitur posuere libero vitae quam mattis dictum.</p>

				<p>Nam vel dui sollicitudin, interdum ipsum ac, ullamcorper velit. Nulla facilisi. Nam sodales pretium magna efficitur dictum. Pellentesque tempus sem quis leo maximus, ac commodo nulla porta. Aliquam erat volutpat. Sed quam dui, tristique non nunc et, fermentum sollicitudin lacus. Donec egestas placerat laoreet. Pellentesque eu ligula eu elit interdum malesuada. Suspendisse in ligula et leo venenatis ullamcorper. Vivamus a leo leo. Nulla vestibulum imperdiet tincidunt. Nulla eu lacus porta urna interdum tincidunt quis tincidunt urna.</p>

		</article>
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