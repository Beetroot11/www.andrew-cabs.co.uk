<div class="topnav">
    <div id="home" class="active">Home</div>
    <div id="drivers">Drivers</div>
    <div id="vehicle">Vehicle</div>
    <div id="users">Users</div>
    <div id="bookings">Bookings</div>
</div>

<script>
    document.getElementById("home").addEventListener("click", navigateMenu('home'));
    document.getElementById("drivers").addEventListener("click", navigateMenu('drivers'));
    document.getElementById("vehicle").addEventListener("click", navigateMenu('vehicle'));
    document.getElementById("users").addEventListener("click", navigateMenu('users'));
    document.getElementById("booking").addEventListener("click", navigateMenu('booking'));

    function navigateMenu(navigate) {
        window.location.href = navigate;
    }
</script>