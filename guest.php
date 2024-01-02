<?php

session_start();
$_SESSION['username'] ="Guest";
$_SESSION['name'] ="Guest";
header("LOCATION: pocetna.php" );
exit();
?>