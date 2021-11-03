<?php

	session_start();
	
	if(!isset($_SESSION['user_log_in']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if (isset($_POST['income_amount']))
	{
		// walidacja udana sprawdzenie
		$all_OK=true;
		
		$income_amount = $_POST['income_amount'];
		$income_date = $_POST['income_date'];
		$income_category = $_POST['income_category'];
		$income_comment = $_POST['income_comment'];
		
		
		if (!is_numeric($income_amount) || $income_amount < 0) 
		{
			$all_OK = false;
			$_SESSION['e_income_amount'] = "Kwota musi być liczbą dodatnia.";
		}
		if($income_amount >= 1000000000)
		{
			$all_OK = false;
			$_SESSION['e_income_amount'] =="Kwota musi być liczbą mniejszą od 1 000 000 000.";
		}
		
		// sprawdzenie daty 
		$current_date = date("Y-m-d");
		if($income_date == NULL)
		{
			$allGod = false;
			$_SESSION['e_income_date'] = "Wybierz datę dla przychodu.";
		}
		
		if ($income_date < 1970-01-01 || $income_date > $current_date) 
		{
			$all_OK = false;
			$_SESSION['e_income_date'] = "Wprowadz poprawna date";
		}
		
		// sprawdzenie dlugosci komentarza
		if ((strlen($income_comment) > 100)) 
		{
			$all_OK = false;
			$_SESSION['e_income_comment'] = "Komentarz moze miec maksymalnie 100 znaków";
		}

		// Zapamiętanie wprowadzonych danych
		$_SESSION['fr_income_amount'] = $income_amount;
		$_SESSION['fr_income_date'] = $income_date;
		$_SESSION['fr_income_category'] = $income_category;
		$_SESSION['fr_income_comment'] = $income_comment;
		
		if ($all_OK == true)
		{
			require_once "connect.php";
			mysqli_report(MYSQLI_REPORT_STRICT);
		
			try 
			{
				$connection = new mysqli ($host, $db_user, $db_password, $db_name);
				
				if ($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				
				else
				{
					$user_id = $_SESSION['id'];
					$getting_income_category_id = $connection->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id = '$user_id' AND name = '$income_category'");
					$row = $getting_income_category_id->fetch_assoc();
					$income_category_id = $row['id'];
					
					if ($connection->query("INSERT INTO incomes VALUES (NULL, '$user_id', '$income_category_id', '$income_amount', '$income_date', '$income_comment')"))
					{
						$_SESSION['income_successfully_added']=true;
						header('location:mainmenu.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				$connection->close();
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Server error! Please try again later.</span>';
			}
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
	<h4>Dodaj Przychód</h4>
	<form method="post">
		<div class="wymiar mx-auto">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Podaj kwote </span>
				</div>
				<input type="number" step="0.01" min="0" class="form-control2" placeholder="PLN" "
					<?php 
						if(isset($_SESSION['fr_income_amount']))
						{
							echo $_SESSION['fr_income_amount'];
							unset($_SESSION['fr_income_amount']);
						}
					?>" name="income_amount" />	
			</div>
				<?php
					if(isset($_SESSION['e_income_amount']))
					{
						echo '<span style="color:red;">'.$_SESSION['e_income_amount'].'</span>';
						unset($_SESSION['e_income_amount']);
					}
				?>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Data  </span>
				</div>
			<input type="date" class="form-control2" aria-label="Date"value="
				<?php 
					if(isset($_SESSION['fr_income_date']))
					{
						echo $_SESSION['fr_income_date'];
						unset($_SESSION['fr_income_date']);
					}
				?>" name="income_date" />		
			</div>
				<?php
					if(isset($_SESSION['e_income_date']))
					{
						echo '<span style="color:red;">'.$_SESSION['e_income_date'].'</span>';
						unset($_SESSION['e_income_date']);
					}
				?>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="inputGroupSelect01">Rodzaj przychodu</label>
				</div>
				<select class="custom-select" id="inputGroupSelect01"  name="income_category">
					<?php 
					
						require_once "connect.php";
						mysqli_report(MYSQLI_REPORT_STRICT);
			
						try
						{
							$connection = new mysqli ($host, $db_user, $db_password, $db_name);
							
							if ($connection->connect_errno!=0)
							{
								throw new Exception(mysqli_connect_errno());
							}
							else
							{
								$user_id = $_SESSION['id'];

								if (!$result = $connection->query(sprintf("SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '%s'", 
								mysqli_real_escape_string($connection, $user_id)))) 
								{
									throw new Exception($connection->error);
								}
								
								while ($row = $result->fetch_assoc())
								{
									echo "<option>" . $row['name'] . "</option>";
								}
								
								$result->close();
								$connection->close();
							}
						}
						catch (Exception $e)
						{
							echo '<span style="color=red;">Server error. Please try again later.</span>';
							//echo '<br />Detailed information: '.$e;
						}
					?>
				</select>
			</div>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text ">Komentarz</span>
			  </div>
			  <textarea class="form-control2 " name="income_comment" />
				<?php 
					if(isset($_SESSION['fr_income_comment']))
					{
						echo $_SESSION['fr_income_comment'];
						unset($_SESSION['fr_income_comment']);
					}
				?>
			</textarea>
			</div>
			<?php
				if(isset($_SESSION['e_income_comment']))
				{
					echo '<span style="color:red;">'.$_SESSION['e_income_comment'].'</span>';
					unset($_SESSION['e_income_comment']);
				}
			?>
			<div class="btn-group mt-4">
			   <button type="submit" class="btn btn-danger mr-5 " formaction="addIncome.php">Anuluj</button>
			   <button type="submit" class="btn btn-success ml-5">Dodaj</button>
			</div>
			</form>
		</div>
	</article>
</main>
<footer class="page-footer fixed-bottom">
	<div id="footer">
	&copy Personal Budget| Korzystanie z serwisu oznacza akceptację regulaminu i polityki prywatności.
	</div>
</footer>
  
 


   
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
 </body>
</html>