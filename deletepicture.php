<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "piaproject";

$konekcija = new mysqli($servername, $username, $password, $db,/* $PORT, $socket*/ );

$noviid = $_GET['identifikacija'];

$sql = "DELETE FROM artworks WHERE artwork_id = $noviid";
$konekcija->query($sql);

//ostalo mi je samo jos da izbrisem sve slike 

header('Location: kontrolnipanel.php');
exit();

?>