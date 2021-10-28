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
							<th>Column 1</th>
							<th>Column 2</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Row 1 Data 1</td>
							<td>Row 1 Data 2</td>
						</tr>
						<tr>
							<td>Row 2 Data 1</td>
							<td>Row 2 Data 2</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<? include '../footer.php' ?>

		<script>
			$(document).ready( function () {
			});

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