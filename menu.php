<div class="topnav">
    <div id="home" class="active">Home</div>
    <div id="drivers">Drivers</div>
    <div id="vehicle">Vehicle</div>
    <div id="users">Users</div>
    <div id="bookings">Bookings</div>
</div>

<script>
    document.getElementById("home").addEventListener("click", navigateMenu);
    document.getElementById("drivers").addEventListener("click", navigateMenu);
    document.getElementById("vehicle").addEventListener("click", navigateMenu);
    document.getElementById("users").addEventListener("click", navigateMenu);
    document.getElementById("booking").addEventListener("click", navigateMenu);

    function navigateMenu(event) {
        window.location.href = event.target.id;
    }
</script>