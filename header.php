<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>RVS Inter College</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="#" type="image/x-icon" />
    <link rel="apple-touch-icon" href="#" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="css/pogo-slider.min.css" />
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css" />
    <!-- <script src="js/slider-index.js"></script> -->
</head>

<!-- LOADER -->

<!-- end loader -->
<!-- END LOADER -->
<!-- Start header -->
<header class="top-header">
    <!-- College Name and Logo -->
    <div class="header-content container-fluid p-3" style="background:#12385b;">
        <div class="row align-items-center">
            <div class="col-8 col-sm-6 d-flex">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="images/rvs_logo.png" alt="Logo" class="logo-img img-fluid" style="max-height: 100px;">
                    <h1 class="college-name ml-2 mb-0 text-white" style="font-size: 16px;">RVS Inter College</h1>
                </a>
            </div>
            <div class="col-4 col-sm-6 text-right" style="color:white !important; font-weight: bold !important;">
                <div class="datetime">
                    <?php
                        date_default_timezone_set('Asia/Kolkata');
                        echo "<span id='current-date' class='d-block' style='font-size: 10px;'>" . date('l, F j, Y') . "</span>";
                        echo "<span id='current-time' style='font-size: 10px;'>" . date('h:i:s A') . "</span>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header-navbar">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
            <!-- <i class="fa-solid fa-bars"></i> -->
             <img src="images/menu.png" alt="Menu" style="height: 30px; width:auto; margin:0; background:transparent">
        </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="about.php" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About Us
                        </a>
                        <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <a class="dropdown-item" href="about.php#principal_message">Principal Message</a>
                            <a class="dropdown-item" href="about.php#mission_vission">Mission & Vision</a>
                            <a class="dropdown-item" href="about.php#grievance_redressal_cell">Grievance Redressal Cell</a>
                            <a class="dropdown-item" href="about.php#about-gallery">Gallery</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="department.php">Department & Faculties</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="academic_program.php" id="downloadsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Downloads
                        </a>
                        <div class="dropdown-menu" aria-labelledby="downloadsDropdown">
                            <a class="dropdown-item" href="syllabus.php">syllabus</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="academic_calender.php" id="academicDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Academic
                        </a>
                        <div class="dropdown-menu" aria-labelledby="academicDropdown">
                            <a class="dropdown-item" href="admission.php">Admission</a>
                            <a class="dropdown-item" href="admission.php#library">Library</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- End header -->
