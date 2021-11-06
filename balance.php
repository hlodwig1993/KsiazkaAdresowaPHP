<?php

	session_start();
	
	if (!($_SESSION['user_log_in'] == true))
	{
		header ('Location: index.php');
		exit();
	}
	
	else
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
				
				if ((!isset($_POST['periodsOptions']) || $_POST['periodsOptions'] == "current_month") && !isset($_POST['customize_period']))
				{
					
					if (!$_SESSION['result_incomes'] = $connection->query("SELECT cat.name, SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND date_of_income >=((EXTRACT(YEAR_MONTH FROM CURDATE())*100)+1) AND inc.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(inc.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if (!$_SESSION['result_expenses'] = $connection->query("SELECT cat.name, SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND date_of_expense >=((EXTRACT(YEAR_MONTH FROM CURDATE())*100)+1) AND exp.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(exp.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_income'] = $connection->query("SELECT SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND date_of_income >=((EXTRACT(YEAR_MONTH FROM CURDATE())*100)+1) AND inc.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_expense'] = $connection->query("SELECT SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND date_of_expense >=((EXTRACT(YEAR_MONTH FROM CURDATE())*100)+1) AND exp.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
				}
				
				if (isset($_POST['periodsOptions']) && $_POST['periodsOptions'] == "previous_month")
				{
				
					if (!$_SESSION['result_incomes'] = $connection->query("SELECT cat.name, SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND YEAR(date_of_income) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(date_of_income) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND inc.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(inc.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if (!$_SESSION['result_expenses'] = $connection->query("SELECT cat.name, SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND YEAR(date_of_expense) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND exp.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(exp.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_income'] = $connection->query("SELECT SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND YEAR(date_of_income) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(date_of_income) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND inc.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_expense'] = $connection->query("SELECT SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND YEAR(date_of_expense) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND exp.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
				}
				
				if (isset($_POST['periodsOptions']) && $_POST['periodsOptions'] == "current_year")
				{
				
					if (!$_SESSION['result_incomes'] = $connection->query("SELECT cat.name, SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND YEAR(date_of_income) = YEAR(CURDATE()) AND inc.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(inc.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if (!$_SESSION['result_expenses'] = $connection->query("SELECT cat.name, SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND YEAR(date_of_expense) = YEAR(CURDATE()) AND exp.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(exp.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_income'] = $connection->query("SELECT SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND YEAR(date_of_income) = YEAR(CURDATE()) AND inc.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_expense'] = $connection->query("SELECT SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND YEAR(date_of_expense) = YEAR(CURDATE()) AND exp.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
				}
				
				if (isset($_POST['custom_start']) && isset($_POST['custom_end']))
				{
					$custom_start = $_POST['custom_start'];
					$custom_end = $_POST['custom_end'];
					
					if (!$_SESSION['result_incomes'] = $connection->query("SELECT cat.name, SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND date_of_income BETWEEN '$custom_start' AND '$custom_end' AND inc.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(inc.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if (!$_SESSION['result_expenses'] = $connection->query("SELECT cat.name, SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND date_of_expense BETWEEN '$custom_start' AND '$custom_end' AND exp.user_id = '$user_id' GROUP BY cat.name ORDER BY SUM(exp.amount) DESC"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_income'] = $connection->query("SELECT SUM(inc.amount) FROM incomes_category_assigned_to_users cat INNER JOIN incomes inc WHERE inc.income_category_assigned_to_user_id = cat.id AND date_of_income BETWEEN '$custom_start' AND '$custom_end' AND inc.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
					
					if(!$_SESSION['total_expense'] = $connection->query("SELECT SUM(exp.amount) FROM expenses_category_assigned_to_users cat INNER JOIN expenses exp WHERE exp.expense_category_assigned_to_user_id = cat.id AND date_of_expense BETWEEN '$custom_start' AND '$custom_end' AND exp.user_id = '$user_id'"))
					{
						throw new Exception($connection->error);
					}
				}
			}
			$connection->close();
		}
		
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later.</span>';
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Balance in Personal Budget</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Anton|Pacifico&amp;subset=latin-ext" rel="stylesheet">

	
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
					</nav>
<main>
		<article class="text-center">
			
		<div class="container bg-gray  mt-lg-2 ">
		
		<fieldset>
		
			<legend > Twoje finanse </legend>
			
			<form method="post">
				<div class="input-group mb-2 w-150 justify-content-around">
					<div class="input-group w-100">
						<span class="input-group-text w-100 justify-content-center">Wybierz przedział czasowy</span>
					</div>
					<div class="input-group w-100 justify-content-around">
					<select id="periodsOptions" name="periodsOptions" class="input-group-text w-50" onchange="if(this.options[this.selectedIndex].value!='custom'){ this.form.submit(); }">
						<option value="current_month" <?php 
										if(!isset($_POST['periodsOptions']) || $_POST['periodsOptions'] == "current_month")
										{
											echo 'selected';
										}
										else
										{
											echo '';
										}
										?>>Obecny miesiąc</option>
						<option value="previous_month" <?php 
										if(isset($_POST['periodsOptions']) && $_POST['periodsOptions'] == "previous_month")
										{
											echo 'selected';
										}
										else
										{
											echo '';
										}
										?>>Poprzedni miesiąc</option>
						<option value="current_year" <?php 
										if(isset($_POST['periodsOptions']) && $_POST['periodsOptions'] == "current_year")
										{
											echo 'selected';
										}
										else
										{
											echo '';
										}
										?>>Obecny rok</option>
						<option value="custom" <?php 
										if(isset($_POST['customize_period']) && $_POST['customize_period'] == "OK")
										{
											echo 'selected';
										}
										else
										{
											echo '';
										}
										?>>Dowolny przedział czasowy</option>
					</select>
					</div>
				</div>
			</form>

			<script>			
			$("#periodsOptions").on("change", function () {        
				$modal = $('#myModal');
				if($(this).val() === 'custom'){
					$modal.modal('show');
				}
			});
			</script>
			<?php
			
				$_SESSION['total_income']->data_seek(0);
				$row_with_total_income = $_SESSION['total_income']->fetch_assoc();
				$_SESSION['sum_of_income'] = $row_with_total_income['SUM(inc.amount)'];
				$_SESSION['total_expense']->data_seek(0);
				$row_with_total_expense = $_SESSION['total_expense']->fetch_assoc();
				$_SESSION['sum_of_expense'] = $row_with_total_expense['SUM(exp.amount)'];
				$balance = $_SESSION['sum_of_income'] - $_SESSION['sum_of_expense'];
				?>

			<div class="modal fade" id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="post">
							<!-- Modal Header -->
							<div class="modal-header">
								<h5 class="modal-title ">Wybierz przedział czasowy </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
						
							<!-- Modal body -->
							<div class="modal-body">
								<div class="input-group mb-2 w-75">
									<div class="input-group-prepend w-25">
										<span class="input-group-text w-100 justify-content-center">Start:</span>
									</div>
									<input type="date" name="custom_start" class="form-control" required>
								</div>
								<div class="input-group mb-2 w-75">
									<div class="input-group-prepend w-25">
										<span class="input-group-text w-100 justify-content-center">End:</span>
									</div>
									<input type="date" name="custom_end" class="form-control" required>
								</div>
							</div>
						
							<!-- Modal footer -->
							<div class="modal-footer">
							<input type="submit" class="btn btn-info" name="customize_period" value="OK">
							<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<fieldset class = "col-12 col-md-12">
			
				<legend > Twoje przychody </legend>
			  
				<div class="d-md-flex justify-content-around">
					<table class="table-striped table-dark  col-12 col-md-6">
						<thead>
							<tr>
								<th >Kategoria</th>
								<th >Kwota</th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								while ($row_with_incomes = $_SESSION['result_incomes']->fetch_assoc())
								{
									echo "<tr><td >" . $row_with_incomes['name'] . "</td><td>" . $row_with_incomes['SUM(inc.amount)'] . "</td></tr>";
									$_SESSION['name']=$row_with_incomes['name'];
									$_SESSION['amount']=$row_with_incomes['SUM(inc.amount)'];
								}
								$_SESSION['result_incomes']->data_seek(0);
							?>
						<thead>
							 <tr>
								<th>Suma</th>
								<?php										
									$sum_of_income = $_SESSION['sum_of_income'];
									echo "<th>" . $sum_of_income . "</th>";
								?>	
							</tr>
						</thead>
						</tbody>
						
					</table>
					
					<?php
						if(!$_SESSION['result_incomes']->num_rows > 0)
						{
							echo '<span style="color:red;"><br />Nie masz przychodów w wybranym okresie czasowym</span>';
						}
						$_SESSION['result_incomes']->data_seek(0);
					?>	
					
					
				</div>	
			</fieldset>
			<br>
		
			<fieldset class=" col-12 col-md-12">
			
				<legend > Twoje wydatki</legend>
			  
				<div class="d-md-flex justify-content-around">
					<table class="table-striped table-dark  col-12 col-md-6">
						<thead>
							<tr>
								<th >Kategoria</th>
								<th >Kwota</th>
							</tr>
						</thead>
						<tbody>
							<?php
								while ($row_with_expenses = $_SESSION['result_expenses']->fetch_assoc())
								{
									echo "<tr><td>" . $row_with_expenses['name'] . "</td><td>" . $row_with_expenses['SUM(exp.amount)'] . "</td></tr>";
									$_SESSION['name']=$row_with_expenses['name'];
									$_SESSION['amount']=$row_with_expenses['SUM(exp.amount)'];
								}
								$_SESSION['result_expenses']->data_seek(0);
							?>
						<thead>
							 <tr>
								<th>Suma</th>
								<?php										
									$sum_of_expense = $_SESSION['sum_of_expense'];
									echo "<th>" . $sum_of_expense . "</th>";
								?>
							</tr>
						</thead>
						</tbody>
					</table>
					<?php
						if(!$_SESSION['result_expenses']->num_rows > 0)
						{
							echo '<span style="color:red;"><br />Nie masz wydatków w wybranym okresie czasowym</span>';
						}
						$_SESSION['result_expenses']->data_seek(0);
					?>	
					
				</div>	
			</fieldset>
		</fieldset>
		<br><br>
		<?php
			
				
				if($balance < 0)
				{
					echo '<div class="bg-danger py-2 px-4" id="summary">';
					echo '<h5 class="font-weight-bold">Twój balans: ' . $balance . ' PLN</h5>';
					echo '</div>';
				}
				
				else
				{
					echo '<div class="bg-success py-2 px-4" id="summary">';
					echo '<h5 class="font-weight-bold">Twój balans: ' . $balance . ' PLN</h5>';
					echo '</div>';
				}
			
		?>		
	</div>
	</article>
<footer class="page-footer fixed-bottom">
	<div id="footer">
		&copy Personal Budget| Korzystanie z serwisu oznacza akceptację regulaminu i polityki prywatności.
	</div>
</footer>
</body>
</html>