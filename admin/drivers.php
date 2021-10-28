<html>
	<? 
		$pageName = "Drivers";
		include '../header.php';

		include '../config.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content">
			<div class="cards">
				<div id="newDriver" class="card">
					<div id="icon"><i class="fas fa-user-plus fa-2x"></i></div>
					<div id="desc">Add New Driver</div>
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

			fetch("/api/driver/getAll", requestOptions)
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						data.drivers.forEach(driver => insertDriver(driver.driverId, driver.fName, driver.sName, driver.addedOn));
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

			document.getElementById("newDriver").addEventListener("click", createNewDriver);
			
			function createNewDriver() {
				window.location.href = 'createDriver';
			}	


			function insertDriver(driverId, fName, sName, addedOn){
				$(".cards").prepend("<div class=\"card\"><div class=\"container\"><h4><b>" + fName + " " + sName + 
									"</b></h4><p>Driver Since " + addedOn + "</p></div></div>");
			}
		</script>
	</body>
</html>