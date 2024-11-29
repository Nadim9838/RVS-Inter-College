<?php
define('hostname', "localhost");
define('username', "root");
define('password', "");
define('dbname', "gctodabhim");

$conn = mysqli_connect(hostname, username, password, dbname) or die("Connection Failed!!");
?>