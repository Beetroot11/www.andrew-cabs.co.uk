<html>
	<? 
		$pageName = "Vehicle";
		include '../header.php';
	?>
	<body>
		<? include '../logo.php'; ?>
        
		<? include '../menu.php' ?>

		<div class="content">
			<div class="cards">
				<div class="card">
					Img
					<div class="container">
						<h4><b>Vehicle Make and Model</b></h4> 
						<p>Some information about the car</p> 
					</div>
				</div>

				<div id="newVehicle" class="card">
					<div id="icon"><i class="fas fa-car fa-2x"></i></div>
					<div id="desc">Add New Car</div>
				</div>
			</div>
		</div>
		<? include '../footer.php' ?>
	</body>
</html>