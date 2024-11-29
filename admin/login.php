<?php
session_start();
include 'database.php';

// User login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username)) {
        echo "
                <script> alert('Please Enter Username!');
                    window.location.replace('http://localhost/rvs-inter-college/admin/');
                </script>";
    } elseif(empty($password)) {
        echo "
                <script> alert('Please Enter Password!');
                    window.location.replace('http://localhost/rvs-inter-college/admin/');
                </script>";
    } else {
        // if username and password is exist then login and redirect to dashboard page
        $sql = "SELECT username, password, name FROM users WHERE username='{$username}' and password='{$password}'";
        if($result = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $dbUserName = $row['username'];
                    $fullName = $row['name'];
                    $dbPassword = $row['password'];
                }
                if($username === $dbUserName && $password === $dbPassword) {
                    $_SESSION['username'] = $dbUserName;
                    $_SESSION['fullname'] = $fullName;
                    header("Location: http://localhost/rvs-inter-college/admin/dashboard.php");
                } else {
                    echo "
                    <script> alert('Incorrect username or password.');
                        window.location.replace('http://localhost/rvs-inter-college/admin/');
                    </script>";
                }
            } else {
                echo "
                <script> alert('Incorrect username or password.');
                    window.location.replace('http://localhost/rvs-inter-college/admin/');
                </script>";
            }
        } else {
            echo "
                <script> alert('Incorrect username or password.');
                    window.location.replace('http://localhost/rvs-inter-college/admin/');
                </script>";
        }
    }
    
}

?>
