<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$db = "PIAproject";
$table = "users";
$conn = new mysqli("localhost","root","","piaproject") or exit("affaf");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $user_login = $conn->query("$user");
    global $user_login;
    if ($user_login->num_rows == 1){
        session_start();
        while ($row = $user_login->fetch_assoc()) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['firstname']= $row['firstname'];
            $_SESSION['user_type'] = $row['role'];
            $_SESSION['user_id'] = $row['user_id'];

        }

        header("Location: pocetna.php");
    }
    else{
        //User doesn't exist wtf do I do here
        header("Location: logout.php");
    }



}