<?php
include 'database.php';
session_start();
session_unset();
session_destroy();
mysqli_close($conn);
header("Location: http://localhost/rvs-inter-college/admin/")
?>