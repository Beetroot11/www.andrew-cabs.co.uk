<div class="topnav">
    <div id="home">Home</div>
    <div id="drivers">Drivers</div>
    <div id="vehicles">Vehicles</div>
    <div id="users">Users</div>
    <div id="bookings">Bookings</div>
</div>

<? include 'logout.php'; ?>

<script>
    var path = window.location.pathname;
    var page = path.split("/").pop();
    
    var pageElement = document.getElementById(page);
    if (pageElement) {
        pageElement.classList.add("active");
    }

    document.getElementById("home").addEventListener("click", navigateMenu);
    document.getElementById("drivers").addEventListener("click", navigateMenu);
    document.getElementById("vehicles").addEventListener("click", navigateMenu);
    document.getElementById("users").addEventListener("click", navigateMenu);
    document.getElementById("bookings").addEventListener("click", navigateMenu);

    function navigateMenu(event) {
        window.location.href = event.target.id;
    }
</script>