<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = "PIAproject";
$table = "users";
$konekcija = new mysqli("localhost","spale","Spale666","PIAproject") or exit("affaf");



$noviid = $_GET['identifikacija'];

$sql = "DELETE FROM users WHERE user_id = $noviid";
$konekcija->query($sql);
$sql2 = "DELETE FROM artworks WHERE artist_id = $noviid";
$konekcija->query($sql2);

//ostalo mi je samo jos da izbrisem sve slike 

header("Location: kontrolnipanel.php");
exit();

?>