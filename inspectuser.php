<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Provera korisnika</title>
	<link rel="stylesheet" href="Style.css">
	<style type="text/css">
		button:hover {
			color: purple;
			background-color: lavenderblush;
		}
		a {
            color: hotpink;
            background-color: white;
            border: 1px solid hotpink;
            border-radius: 8px;
        }
 	</style>
</head>
<body>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();


$db = "PIAproject";
$table = "users";
$conn = new mysqli("localhost","spale","Spale666","PIAproject") or exit("affaf");



$user_id = $_GET['id'];
$parts = explode("-", $user_id);
$user_id1 = $parts[0];


echo "<a href=kontrolnipanel.php>Kontrolni panel</a><br>";
$queryInfo = "SELECT * FROM users WHERE user_id = $user_id1";
$getInfo = $conn->query($queryInfo);

if ($getInfo->num_rows > 0) {
	while ($user = $getInfo->fetch_assoc()) {
		$korisnikid = $user['user_id'];
		$username = $user['username'];
		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$role = $user['role'];

		echo "<p id='iden'>$korisnikid</p>";
		echo "Username je $username<br>";
		echo "Ime je $firstname<br>";
		echo "Prezime je $lastname<br>";
		echo "Tip korisnika je $role<br>";
	}
}
?>
<button onclick="posaljidelete(this)">Banuj korisnika</button>
<script type="text/javascript">
	function posaljidelete(button) {
			var red = iden;
			var prvielement = red.textContent;

			var form = document.createElement("form");
			form.method = "get";
			form.action = "delete.php";
			
			var input = document.createElement("input");
			input.type = "hidden";
			input.name = "identifikacija";
			input.value = prvielement;
			
			form.appendChild(input);

			document.body.appendChild(form);
			form.submit();
		}
</script>
</body>
</html>
