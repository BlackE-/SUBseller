<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();

	$checkDBLogin = $set->checkDBLogin();
	if(!$checkDBLogin['return']){
		header('Location: init.php');
		exit;
	}
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		echo $set->getErrorMessage();
		header("Location: login"); 
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="ventasTotalContainer">
				<p>Total Ventas</p>
				<h1>
					<?php
						$sales = $set->getTotalSales();
						echo '<p>$'.number_format($sales, 2).'</p>';
					?>
				</h1>
			</div>
			<div class="totalClientesContainer">
				<p>Total Clientes</p>
				<h1>
					<?php
						$countClients = $set->getTotalClients();
						echo '<p>'.$countClients.'</p>';
					?>
				</h1>
			</div>
			<div class="salesByMonthContainer">
				<div class="canvasContainer">	
					<canvas id="myChart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script type="text/javascript" src="script/index.js"></script>
	<script type="text/javascript">

		// var ctx = document.getElementById('myChart');
		// var myChart = new Chart(ctx, {
		//     type: 'bar',
		//     data: {
		//         labels: ['29/03','30/03','31/03','1/04', '2/04', '3/04'],
		//         datasets: [{
		//             label: 'orders',
		//             data: [1, 3, 0, 1, 2, 3],
		//             backgroundColor: [
		//                 'rgba(255, 99, 132, 0.2)',
		//                 'rgba(54, 162, 235, 0.2)',
		//                 'rgba(255, 206, 86, 0.2)',
		//                 'rgba(75, 192, 192, 0.2)',
		//                 'rgba(153, 102, 255, 0.2)',
		//                 'rgba(255, 159, 64, 0.2)'
		//             ],
		//             borderColor: [
		//                 'rgba(255, 99, 132, 1)',
		//                 'rgba(54, 162, 235, 1)',
		//                 'rgba(255, 206, 86, 1)',
		//                 'rgba(75, 192, 192, 1)',
		//                 'rgba(153, 102, 255, 1)',
		//                 'rgba(255, 159, 64, 1)'
		//             ],
		//             borderWidth: 1
		//         }]
		//     },
		//     options: {
		//         scales: {
		//             yAxes: [{
		//                 ticks: {
		//                     beginAtZero: true,
		//                     stepSize: 1
		//                 }
		//             }]
		//         }
		//     }
		// });
	</script>
</body>
</html>