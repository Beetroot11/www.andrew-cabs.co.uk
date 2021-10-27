<html>
	<? 
		$pageName = "Create New Driver";
		include '../header.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content loginWindow">
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
                <div id="driverDob">
					<div class="inputTitle">Driver Date of Birth</div>
					<div class="input">
						<input type="date" 
							id="driver-dob" 
							class="formInput"
							placeholder="Date of Birth" 
							aria-label="Date of Birth" 
							value="" />
						<span id="driverDobError" class="inputError"></span>
					</div>
				</div>
                <div id="licencedToDrive">
                    <div class="inputTitle">Driver Licenced to Drive</div>
					<div class="input">
                        <input type="checkbox" id="vehicleType1" name="vehicleType1" value="Car">
                        <label for="vehicleType1"> Car</label>
                        <input type="checkbox" id="vehicleType2" name="vehicleType2" value="Bus">
                        <label for="vehicleType2"> Bus</label>
						<span id="driverLicenceError" class="inputError"></span>
					</div>
                </div>

				<div id="submitBtn" class="btn">
					<i class="fas fa-user-plus"></i> Create Driver
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