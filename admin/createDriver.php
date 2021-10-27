<html>
	<? 
		$pageName = "Create New Driver";
		include '../header.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content">
            <div id="loginWindow">
                <div id="driverFirstName">
                    <div class="inputTitle">First Name</div>
                    <div class="input">
                        <input type="text" 
                            id="driver-first-name" 
                            class="formInput"
                            placeholder="First Name" 
                            aria-label="First Name" 
                            value="" />
                        <span id="driverFirstNameError" class="inputError"></span>
                    </div>
                </div>
                <div id="driverSurname">
                    <div class="inputTitle">Surname</div>
                    <div class="input">
                        <input type="text" 
                            id="driver-surname" 
                            class="formInput"
                            placeholder="Surname" 
                            aria-label="Surname" 
                            value="" />
                        <span id="driverSurnameError" class="inputError"></span>
                    </div>
                </div>
				<div id="submitBtn" class="btn">
					<i class="fas ffa-user-plus"></i> Create Driver
				</div>
			</div>
		</div>
		<? include '../footer.php' ?>

		<script>
			document.getElementById("submitBtn").addEventListener("click", createNewDriver);
			function createNewDriver() {
				
			}	
		</script>
	</body>
</html>