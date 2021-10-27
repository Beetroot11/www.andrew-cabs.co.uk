<div id="logoutBtn">
    <i class="fas fa-sign-out-alt"></i> Logout
</div>

<script>
    document.getElementById("logoutBtn").addEventListener("click", logout);

    function logout() {
        window.location.href = '/';
    }
</script>