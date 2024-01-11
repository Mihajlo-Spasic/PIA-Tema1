<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);



$db = "PIAproject";
$table = "users";
$konekcija = new mysqli("localhost","root","","piaproject") or exit("affaf");



$noviid = $_GET['identifikacija'];

$sql = "DELETE FROM artworks WHERE artwork_id = $noviid";
$konekcija->query($sql);

//ostalo mi je samo jos da izbrisem sve slike 

header('Location: kontrolnipanel.php');
exit();

?>