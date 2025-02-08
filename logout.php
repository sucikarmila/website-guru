<?php
session_start();
session_destroy();
?>
<script type="text/javascript">
    alert('Anda Sudah Logout');
    location.href = "login.php";
</script>

