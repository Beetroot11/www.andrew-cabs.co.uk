<html>
	<? 
		$pageName = "Book";
		include '../header.php';
	?>
	<body>
		<? include '../logo.php'; ?>
		<? include '../logout.php'; ?>
		<div class="content booking">
			<div id="loginWindow">
				<div id="bookingAmountInput">
					<div class="inputTitle">How many people is the booking for?</div>
					<div class="input">
						<input type="number" 
							id="booking-amount" 
							class="formInput"
							min="1"
							placeholder="Number of People" 
							aria-label="Number of People" 
							value="" 
							autocomplete="off" />
						<span id="bookingAmountError" class="inputError"></span>
					</div>
				</div>
				<div id="bookingWhenInput">
					<div class="inputTitle">When do you want to be picked up?</div>
					<div class="input">
						<input type="datetime-local" 
							id="booking-when" 
							class="formInput"
							placeholder="Time and Date to be picked up" 
							aria-label="Time and Date to be picked up" 
							value="" 
							autocomplete="off" />
						<span id="bookingWhenError" class="inputError"></span>
					</div>
				</div>
				<div id="bookingWhereInput">
					<div class="inputTitle">Where do you want to go from?</div>
					<div class="input">
						<input type="text" 
							id="booking-where-from" 
							class="formInput"
							placeholder="Where we going from?" 
							aria-label="Where do you want to be taken from" 
							value="" 
							autocomplete="off" />
						<span id="bookingWhereFromError" class="inputError"></span>
					</div>
				</div>
				<div id="bookingToInput">
					<div class="inputTitle">Where do you want to go to?</div>
					<div class="input">
						<input type="text" 
							id="booking-where-to" 
							class="formInput"
							placeholder="Where we going to?" 
							aria-label="Where do you want to be taken to" 
							value="" 
							autocomplete="off" />
						<span id="bookingWhereToError" class="inputError"></span>
					</div>
				</div>

				<div id="bookBtn" class="btn">
					<i class="fas fa-sign-in-alt"></i> Book
				</div>
			</div>
		</div>

		<? include '../footer.php' ?>

		<script>
			document.getElementById("bookBtn").addEventListener("click", book);

			function book() {
				var amountOfPeople = document.getElementById("booking-amount").value;
				var when = document.getElementById("booking-when").value;
				var where = document.getElementById("booking-where").value;
				var to = document.getElementById("booking-to").value;

				alert('booked!');
			}

			function userLoggedIn() {
				var toastMixin = Swal.mixin({
					toast: true,
					icon: 'success',
					title: 'General Title',
					animation: false,
					position: 'top-right',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				});
			}	

			toastMixin.fire({
				animation: true,
				title: 'Signed in Successfully'
			});
		
		</script>
	</body>
</html>