<html>
	<? 
		$pageName = "Users";
		include '../header.php';

		include '../config.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content">
			<div id="loginWindow">
				<table id="table_id" class="display">
					<thead>
						<tr>
							<th>Name</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
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

			fetch("/api/user/getAll", requestOptions)
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						data.users.forEach(user => insertUser(user.userId, user.fName, user.sName));
						$('#table_id').DataTable();
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
			
			function insertUser(userId, fName, sName){
				$("tbody").append("<tr><td>" + fName + " " + sName + "</td></tr>");
			}
		</script>
	</body>
</html>