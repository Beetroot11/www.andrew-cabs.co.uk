<html>
	<? 
		$pageName = "Create New Vehicle";
		include '../header.php';

        include '../config.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<? include '../menu.php' ?>

		<div class="content loginWindow">
            <div id="loginWindow">
                <div id="vehicleMake">
                    <div class="inputTitle">Make</div>
                    <div class="input">
                        <input type="text" 
                            id="vehicle-make" 
                            class="formInput"
                            placeholder="Make" 
                            aria-label="Make" 
                            value="" />
                        <span id="vehicleMakeNameError" class="inputError"></span>
                    </div>
                </div>
                <div id="vehicleModel">
                    <div class="inputTitle">Model</div>
                    <div class="input">
                        <input type="text" 
                            id="vehicle-model" 
                            class="formInput"
                            placeholder="Model" 
                            aria-label="Model" 
                            value="" />
                        <span id="vehicleModelNameError" class="inputError"></span>
                    </div>
                </div>
                <div id="vehicleColour">
                    <div class="inputTitle">Colour (You can input a colour name or a colour value here)</div>
                    <div class="input">
                        <input type="text" 
                            id="vehicle-colour" 
                            class="formInput"
                            placeholder="Colour" 
                            aria-label="Colour" 
                            value="" />
                        <span id="vehicleColourNameError" class="inputError"></span>
                    </div>
                </div>
                <div id="vehicleCapacity">
					<div class="inputTitle">Capacity</div>
					<div class="input">
						<input type="number" 
							id="vehicle-capacity" 
							class="formInput"
							min="1"
							placeholder="Capacity" 
							aria-label="Capacity" 
							value="" 
							autocomplete="off" />
						<span id="vehicleCapacityError" class="inputError"></span>
					</div>
				</div>
                <div id="vehicleRegistration">
					<div class="inputTitle">Registration</div>
					<div class="input">
						<input type="text" 
							id="vehicle-registration" 
							class="formInput"
							placeholder="Registration" 
							aria-label="Registration" 
							value="" />
						<span id="vehicleRegistrationError" class="inputError"></span>
					</div>
				</div>
                <div id="vehicleType">
					<div class="inputTitle">Type</div>
					<div class="input">
                        <select name="type" id="vehicle-type">
                            <option value="2">Car</option>
                            <option value="1">Bus</option>
                        </select>
					</div>
				</div>

				<div id="submitBtn" class="btn">
                    <i class="fas fa-car"></i> Create Vehicle
				</div>

                <div id="cancelBtn" class="btn">
                    <i class="fas fa-times"></i> Cancel
				</div>
			</div>
		</div>
		<? include '../footer.php' ?>

		<script>
            document.getElementById("submitBtn").addEventListener('click', (event) => {
                submitForm();
            });

            document.getElementById("cancelBtn").addEventListener('click', (event) => {
                navigateToPage("vehicles");
            });

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
                formData.append("make", document.getElementById("vehicle-make").value);
                formData.append("model", document.getElementById("vehicle-model").value);
                formData.append("colour", document.getElementById("vehicle-colour").value);
                formData.append("capacity", document.getElementById("vehicle-capacity").value);
                formData.append("registration", document.getElementById("vehicle-registration").value);
                formData.append("type", document.getElementById("vehicle-type").value);

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("/api/vehicle/create", requestOptions)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/admin/vehicles';
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