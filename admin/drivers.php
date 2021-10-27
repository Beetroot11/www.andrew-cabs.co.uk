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
					title: 'New Driver',
					html:
						'<input id="fName" class="swal2-input" placeholder="First Name">' +
						'<input id="sName" class="swal2-input" placeholder="Surname">',
					preConfirm: function () {
						return new Promise(function (resolve) {
						resolve([
							$('#fName').val(),
							$('#sName').val()
						])
						})
					},
					onOpen: function () {
						$('#fName').focus()
					}
				}).then(function (result) {
					swal(JSON.stringify(result))
				}).catch(swal.noop)
			}	
		</script>
	</body>
</html>