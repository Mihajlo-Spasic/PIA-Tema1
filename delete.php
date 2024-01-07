<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "piaproject";

$konekcija = new mysqli($servername, $username, $password, $db,/* $PORT, $socket*/ );

$noviid = $_GET['identifikacija'];

$sql = "DELETE FROM users WHERE user_id = $noviid";
$konekcija->query($sql);
$sql2 = "DELETE FROM artworks WHERE artist_id = $noviid";
$konekcija->query($sql2);

//ostalo mi je samo jos da izbrisem sve slike 

header('Location: kontrolnipanel.php');
exit();

?>