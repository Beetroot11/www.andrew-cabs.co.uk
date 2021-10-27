<html>
	<? 
		$pageName = "Home";
		include '../header.php';
	?>
	<body>
		<? include '../logo.php'; ?>

		<div class="content">
			<div id="loginWindow">
				<div id="bookingAmountInput">
					<div class="inputTitle">How many people is the booking for?</div>
					<div class="input">
						<input type="number" 
							id="booking-amount" 
							class="formInput"
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
					<div class="inputTitle">Where do you want to go?</div>
					<div class="input">
						<input type="text" 
							id="booking-where" 
							class="formInput"
							placeholder="Where do you want to be taken" 
							aria-label="Where do you want to be taken" 
							value="" 
							autocomplete="off" />
						<span id="bookingWhereError" class="inputError"></span>
					</div>
				</div>
			</div>
		</div>

		<? include '../footer.php' ?>
	</body>
</html>