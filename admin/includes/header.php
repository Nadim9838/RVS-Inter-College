<?php
session_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/rvs-inter-college/admin/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RVS Inter College Admin Panel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="top-header header-container">
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="courses.php">Course Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery.php">Gallery Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">Department Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news.php">News Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="events.php">Events Management</a>
                </li>
                <li class="nav-item ml-auto">
                    <div class="text-center">
                        <span style="color: white; font-weight: bold; font-size: 24px; line-height: 25px;">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        <br />
                        <a href="logout.php">
                            <button id="logout_button">Logout</button>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
