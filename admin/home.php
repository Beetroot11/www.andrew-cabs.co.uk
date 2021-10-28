<html>
	<? 
		$pageName = "Home";
		include '../header.php';

		include '../config.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content">
			<div id="loginWindow">
				<div class="cards">
					<div id="drivers" class="card">
						<div id="icon"><i class="fas fa-car fa-2x"></i></div>
						<div id="desc"></div>
					</div>
				</div>
				<div class="cards">
					<div id="users" class="card">
						<div id="icon"><i class="fas fa-car fa-2x"></i></div>
						<div id="desc"></div>
					</div>
				</div>
				<div class="cards">
					<div id="vehicles" class="card">
						<div id="icon"><i class="fas fa-car fa-2x"></i></div>
						<div id="desc"></div>
					</div>
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

			fetch("/api/getOverview", requestOptions)
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						$('#drivers #desc').text(data.drivers + " drivers");
						$('#users #desc').text(data.users + " users");
						$('#vehicles #desc').text(data.vehicles + " vehicles");
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
		</script>
	</body>
</html>