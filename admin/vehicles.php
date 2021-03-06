<html>
	<? 
		$pageName = "Vehicles";
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
					<div id="desc">Add New Vehicle</div>
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
						data.vehicles.forEach(vehicle => insertVehicle(vehicle.vehicleId, 
							vehicle.make, vehicle.model, vehicle.colour, vehicle.registration, 
							vehicle.vehicleTypeId));
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

			function insertVehicle(vehicleId, make, model, colour, registration, vehicleTypeId){
				var vehcileIcon = "fas fa-car-side";
				if (vehicleTypeId == "1") {
					vehcileIcon = "fas fa-truck-moving";
				}
				$(".cards").prepend("<div class=\"card\"><div class=\"container\">" + 
				"<div id=\"icon\"><i class=\"" + vehcileIcon + " fa-2x\" style=\"color:" + colour + "\"></i></div><h4><b>" + make + " " + model + 
				"</b></h4><p>" + registration + "</p></div></div>");
			}
		</script>
	</body>
</html>