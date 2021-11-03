<?php

	session_start();
	
	if(!isset($_SESSION['user_log_in']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_POST['expense_amount']))
	{
		//Udana walidacja
		$all_OK = true;
		
		$expense_amount = $_POST['expense_amount'];
		$expense_date = $_POST['expense_date'];
		$payment_category = $_POST['payment_category'];
		$expense_category = $_POST['expense_category'];
		$expense_comment = $_POST['expense_comment'];
		
		//Walidacja kwoty wydatku
		$expense_amount = $_POST['expense_amount'];
		$expense_amount = htmlentities($expense_amount,ENT_QUOTES, "UTF-8");
		
		//Czy kwota jest liczba
		if(!is_numeric($expense_amount) || $expense_amount < 0)
		{
			$all_OK = false;
			$_SESSION['e_expense_amount']="Kwota musi być liczbą dodatnia.";
		}
		
		//Zakres kwoty 
		if($expense_amount >= 1000000000)
		{
			$all_OK = false;
			$_SESSION['e_expense_amount']="Kwota musi być liczbą mniejszą od 1 000 000 000.";
		}
		
		//Walidacja daty
		$expense_date = $_POST['expense_date'];
		$expense_date = htmlentities($expense_date,ENT_QUOTES, "UTF-8");
		
		if($expense_date == NULL)
		{
			$allGod = false;
			$_SESSION['e_expense_date'] = "Wybierz datę dla wydatku.";
		}
		
		$currentDate = date('Y-m-d');
		
		if($expense_date > $currentDate)
		{
			$all_OK = false;
			$_SESSION['e_expense_date'] = "Data musi być aktualna lub wcześniejsza.";	
		}
		
		
		//Spawdzenie komentarza
		$expense_comment = $_POST['expense_comment'];
		$expense_comment = htmlentities($expense_comment,ENT_QUOTES, "UTF-8");
		
		if((strlen($expense_comment) > 100))
		{
			$all_OK = false;
			$_SESSION['e_expense_comment'] = "Komentarz może mieć maksymalnie 100 znaków.";
		}
		
		//Zapamiętanie wprowadzonych danych
		$_SESSION['fr_expense_amount'] = $expense_amount;
		$_SESSION['fr_expense_date'] = $expense_date;
		$_SESSION['fr_payment_category'] = $payment_category;
		$_SESSION['fr_expense_category'] = $expense_category;
		$_SESSION['fr_expense_comment'] = $expense_comment;
		
		
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
					$getting_expense_category_id = $connection->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id = '$user_id' AND name = '$expense_category'");
					$row = $getting_expense_category_id->fetch_assoc();
					$expense_category_id = $row['id'];
					$getting_payment_category_id = $connection->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id = '$user_id' AND name = '$payment_category'");
					$row = $getting_payment_category_id->fetch_assoc();
					$payment_category_id = $row['id'];
					
					if ($connection->query("INSERT INTO expenses VALUES (NULL, '$user_id', '$expense_category_id', '$payment_category_id', '$expense_amount', '$expense_date', '$expense_comment')"))
					{
						$_SESSION['expense_successfully_added']=true;
						header('location: mainmenu.php');
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

					<li class="nav-item">
						<a class="nav-link" href="addExpense">Dodaj Wydatek </a>
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
			<div class="wymiar mx-auto">
				
						
							<article>
								<form method = "post">
								
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">Podaj kwote</span>
										</div>
										<input type="number" step="0.01" min="0" class="form-control2" placeholder="PLN"  value="
											<?php 
												if (isset($_SESSION['fr_expense_amount']))
												{
													echo $_SESSION['fr_expense_amount'];
													unset($_SESSION['fr_expense_amount']);
												}
											?> "name="expense_amount">
												
											<?php
												if (isset($_SESSION['e_expense_amount']))
												{
													echo '<div class="error">'.$_SESSION['e_expense_amount'].'</div>';
													unset($_SESSION['e_expense_amount']);
												}
											?> 
													
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">Data  </span>
										</div>
										<input type="date" class="form-control2 " name = "expense_date" value="
											<?php 
												if (isset($_SESSION['fr_expense_date']))
												{
													echo $_SESSION['fr_expense_date'];
													unset($_SESSION['fr_expense_date']);
												}
												else
												{
													echo date('Y-m-d'); 
												}
											?>" class="form-control">
											<?php
												if (isset($_SESSION['e_expense_date']))
												{
													echo '<div class="error">'.$_SESSION['e_expense_date'].'</div>';
													unset($_SESSION['e_expense_date']);
												}
											?>
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<label class="input-group-text" for="inputGroupSelect01">Rodzaj płatnosci</label>
										</div>
										<select class="custom-select"  name="payment_category">
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

													if (!$result = $connection->query(sprintf("SELECT name FROM payment_methods_assigned_to_users WHERE user_id = '%s'", 
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
			
										
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<label class="input-group-text" for="inputGroupSelect02">Kategoria</label>
										</div>
										<select class="custom-select" id="inputGroupSelect02" name="expense_category">
										<?php 
							
											require_once "connect.php";
											mysqli_report(MYSQLI_REPORT_STRICT);
								
											try
											{
												$connect = new mysqli ($host, $db_user, $db_password, $db_name);
												
												if ($connect->connect_errno!=0)
													{
														throw new Exception(mysqli_connect_errno());
													}
												else
												{
													$user_id = $_SESSION['id'];

													if (!$result = $connect->query(sprintf("SELECT name FROM expenses_category_assigned_to_users WHERE user_id = '%s'", 
													mysqli_real_escape_string($connect, $user_id)))) 
														{
															throw new Exception($connect->error);
														}
													
													while ($row = $result->fetch_assoc())
														{
															echo "<option>" . $row['name'] . "</option>";
														}
													
													$result->close();
													$connect->close();
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
			
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text ">Komentarz</span>
										</div>
										<textarea class="form-control2 "name = "expense_comment" >
										<?php 
											if (isset($_SESSION['fr_expense_comment']))
											{
												echo $_SESSION['fr_expense_comment'];
												unset($_SESSION['fr_expense_comment']);
											}
										?></textarea>
										<?php
											if (isset($_SESSION['e_expense_comment']))
											{
												echo '<div class="error">'.$_SESSION['e_expense_comment'].'</div>';
												unset($_SESSION['e_expense_comment']);
											}
										?>	
										
										
										
										<div class="row justify-content-center mt-5">
										   <button type="submit" class="btn btn-danger mr-5  ">Anuluj</button>
										   <button type="submit" class="btn btn-success ml-5">Dodaj</button>
										</div>
									</div>
								</form>					
							</article>
			</div>							
	</main>
	<footer class="page-footer fixed-bottom">
		<div id="footer">
		&copy; Personal Budget| Korzystanie z serwisu oznacza akceptację regulaminu i polityki prywatności.
		</div>
	</footer>
  
 


   
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
 </body>
</html>