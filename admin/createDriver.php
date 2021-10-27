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
                <div id="driverLicenceNumber">
                    <div class="inputTitle">Licence Number</div>
                    <div class="input">
                        <input type="text" 
                            id="driver-licence-number" 
                            class="formInput"
                            placeholder="Licence Number" 
                            aria-label="Licence Number" 
                            value="" />
                        <span id="driverLicenceNumberError" class="inputError"></span>
                    </div>
                </div>
                <div id="licencedToDrive">
                    <div class="inputTitle">Driver Licenced to Drive</div>
					<div class="input">
                        <input type="checkbox" id="vehicleType1" name="vehicleType" value="Car">
                        <label for="vehicleType1"> Car</label>
                        <input type="checkbox" id="vehicleType2" name="vehicleType" value="Bus">
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
			document.getElementById("submitBtn").addEventListener("click", submitForm);

            const submitForm = () => {
                var licencedToDrive = [];
                if (document.getElementById("vehicleType1").checked) {
                    licencedToDrive.push("CAR");  
                }
                if (document.getElementById("vehicleType2").checked) {
                    licencedToDrive.push("BUS");  
                }

                var formData = new FormData();
                formData.append("authKey", "<?=$authKey?>");
                formData.append("firstName", document.getElementById("driver-first-name").value);
                formData.append("surname", document.getElementById("driver-surname").value);
                formData.append("dob", document.getElementById("driver-dob").value);
                formData.append("licenceNumber", document.getElementById("driver-licence-number").value);
                formData.append("licenceToDrive", licencedToDrive);

                var shouldRemember = document.getElementById('remember').checked;

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("/api/driver/create", requestOptions)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
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
		</script>
	</body>
</html>