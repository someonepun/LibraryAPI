<?php
$dbhostname = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbdatabase = "ishelf";
$mysqli = new mysqli($dbhostname, $dbusername, $dbpassword, $dbdatabase);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>