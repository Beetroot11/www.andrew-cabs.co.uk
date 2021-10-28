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
				<div id="newDriver" class="addItem">
					<div id="icon"><i class="fas fa-user-plus fa-2x"></i></div>
					<div id="desc">Add New Driver</div>
				</div>
			</div>
		</div>
		
		<? include '../footer.php' ?>

		<script>
			$(".cards").sortable({
				connectWith: ".cards",
				stop: function(event, ui) {
					var sortOrder = new Array();     

					$('.cards').each(function() {
						var card = 0;
						$(this).find(".card").each(function(){
							sortOrder.push({"driverId": $(this).attr('id').replace('driver',''), "sort": ++card});
						});
					});
					
					var formData = new FormData();
					formData.append("authKey", "<?=$authKey?>");
					formData.append("sortOrder", JSON.stringify(sortOrder));

					var requestOptions = {
						method: 'POST',
						body: formData,
						redirect: 'follow'
					};

					console.log(JSON.stringify(sortOrder));

					fetch("/api/driver/updateSortOrder", requestOptions)
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								var toastMixin = Swal.mixin({
									toast: true,
									icon: 'success',
									title: 'Sort Order Updated',
									animation: false,
									position: 'top-right',
									showConfirmButton: false,
									timer: 3000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.addEventListener('mouseenter', Swal.stopTimer)
										toast.addEventListener('mouseleave', Swal.resumeTimer)
									}
								});
							
								toastMixin.fire({
									animation: true,
									title: 'Sort Order Updated'
								});
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
				}
			});

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
				$(".cards").prepend("<div id=\"driver" + driverId + "\" class=\"card\"><div class=\"container\">" +
									"<img src=\"../assets/images/driverPlaceholder.png\" class=\"driverPicture\"/><h4><b>" + fName + " " + sName + 
									"</b></h4><p>Driver Since " + addedOn + "</p></div></div>");
			}
		</script>
	</body>
</html>