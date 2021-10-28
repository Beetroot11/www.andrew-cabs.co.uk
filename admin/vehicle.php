<html>
	<? 
		$pageName = "Vehicle";
		include '../header.php';

		include '../config.php';
	?>
	<body>
		<? include '../logo.php'; ?>
        
		<? include '../menu.php' ?>

		<div class="content">
			<div class="cards">
				<div id="newVehicle" class="card">
					<div id="icon"><i class="fas fa-car fa-2x"></i></div>
					<div id="desc">Add New Car</div>
				</div>
			</div>
		</div>
		<? include '../footer.php' ?>

		<script>
			var formData = new FormData();
			formData.append("authKey", "<?=$authKey?>");

			var requestOptions = {
				method: 'POST',
				body: formData,
				redirect: 'follow'
			};

			fetch("/api/vehicle/getAll", requestOptions)
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						data.vehicles.forEach(driver => insertVehicle(vehicles.vehicleId, vehicle.make, vehicle.model));
					} else {
						Swal.fire({
							title: 'Error!',
							text: data.failMessage,
							icon: 'error',
							confirmButtonText: 'Try Again'
						});
					}
				})
				.catch(error => console.log('error', error));

			document.getElementById("newVehicle").addEventListener("click", createNewVehicle);
			
			function createNewVehicle() {
				window.location.href = 'createVehicle';
			}	

			function insertVehicle(vehicleId, make, model){
				$(".cards").prepend("<div class=\"card\"><div class=\"container\"><h4><b>" + make + " " + model + "</b></h4></div></div>");
			}
		</script>
	</body>
</html>