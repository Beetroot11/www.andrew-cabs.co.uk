<html>
	<? 
		$pageName = "Login";
		include 'header.php';
	?>
	<body>
		<? include 'logo.php'; ?>
		<div class="content loginWindow">
			<div class="smallerWindow">
				<div id="emailInput">
					<div class="inputTitle">Your Email:</div>
					<div class="input">
						<input type="email" 
							id="user-email" 
							class="formInput"
							placeholder="Email" 
							aria-label="Email" 
							value="" 
							autocomplete="off" />
						<span id="emailError" class="inputError"></span>
					</div>
				</div>
				<div id="passwordInput">
					<div class="inputTitle">Your Password:</div>
					<div class="input">
						<input type="password" 
							id="user-pass" 
							class="formInput"
							placeholder="Password" 
							aria-label="Password" 
							value="" 
							autocomplete="off" />
						<span id="passError" class="inputError"></span>
					</div>
				</div>
				
				<div id="loginBtn" class="btn">
					<i class="fas fa-sign-in-alt"></i> Login
				</div>

				<div id="createBtn" class="btn">
					<i class="fas fa-user-plus"></i> Create Account
				</div>
			</div>
		</div>
		<? include 'footer.php'; ?>
		<script>
			document.getElementById("loginBtn").addEventListener("click", login);
			document.getElementById("createBtn").addEventListener("click", create);

			function login() {
				var email = validateField("Email", "user-email", "emailError", "emailInput");
				var pass = validateField("Password", "user-pass", "passError", "passwordInput");

				if (email == "admin" && pass) {
					window.location.href = 'admin/home';
				} else if (email && pass) {
					window.location.href = 'user/book';
				}
			}

			function create() {
				
			}

			function validateField(type, field, required, input) {
				var fieldValue = document.getElementById(field).value;

				if (fieldValue == "") {
					document.getElementById(required).innerHTML = type + " Required";
					document.getElementById(input).querySelector("div.input").classList.add("error");
				} else {
					document.getElementById(required).innerHTML = "";
					document.getElementById(input).querySelector("div.input").classList.remove("error");
				}
				return fieldValue;
			}

		</script>
	</body>
</html>