<html>
	<? 
		$pageName = "Drivers";
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
						<h4><b>John Doe</b></h4> 
						<p>Architect & Engineer</p> 
					</div>
				</div>

				<div id="newDriver" class="card">
					<div id="icon"><i class="fas fa-user-plus fa-2x"></i></div>
					<div id="desc">Add New Driver</div>
				</div>
			</div>
		</div>
		<? include '../footer.php' ?>

		<script>
			document.getElementById("newDriver").addEventListener("click", createNewDriver);
			function createNewDriver() {
				swal({
					position: "top-end",
					type: "success",
					title: "Your work has been saved",
					showConfirmButton: false,
					timer: 1500
				});
			}	

		</script>
	</body>
</html>