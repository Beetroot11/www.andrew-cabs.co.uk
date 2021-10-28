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
				<table id="users" class="display">
					<thead>
						<tr>
							<th>Name</th>
						</tr>
					</thead>
					<tbody id=>
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
				$('#users').DataTable();
			});
		</script>
	</body>
</html>