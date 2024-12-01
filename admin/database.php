<?php
define('hostname', "localhost");
define('username', "root");
define('password', "");
define('dbname', "rvs_inter_college");

$conn = mysqli_connect(hostname, username, password, dbname) or die("Connection Failed!!");
?>