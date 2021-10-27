<div class="topnav">
    <div id="home">Home</div>
    <div id="drivers">Drivers</div>
    <div id="vehicle">Vehicle</div>
    <div id="users">Users</div>
    <div id="bookings">Bookings</div>
</div>

<script>
    var path = window.location.pathname;
    var page = path.split("/").pop();

    document.getElementById(page).classList.add("active");
    document.getElementById("home").addEventListener("click", navigateMenu);
    document.getElementById("drivers").addEventListener("click", navigateMenu);
    document.getElementById("vehicle").addEventListener("click", navigateMenu);
    document.getElementById("users").addEventListener("click", navigateMenu);
    document.getElementById("bookings").addEventListener("click", navigateMenu);

    function navigateMenu(event) {
        window.location.href = event.target.id;
    }
</script>