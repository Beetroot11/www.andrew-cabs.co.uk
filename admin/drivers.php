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
				const { value: formValues } = await Swal.fire({
					title: 'Multiple inputs',
					html:
						'<input id="swal-input1" class="swal2-input">' +
						'<input id="swal-input2" class="swal2-input">',
					focusConfirm: false,
					preConfirm: () => {
						return [
							document.getElementById('swal-input1').value,
							document.getElementById('swal-input2').value
						]
					}
				})

				if (formValues) {
					Swal.fire(JSON.stringify(formValues))
				}
			}	
		</script>
	</body>
</html>