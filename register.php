<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$db = "PIAproject";
$table = "users";
$conn = new mysqli("localhost","root","","piaproject") or exit("affaf");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["name"];
    $lastname = $_POST["lastname"];
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];


    $query = "INSERT INTO users (username, firstname, lastname, password, role) VALUES ('$username', '$firstname','$lastname','$password', '$user_type')";
    $result = $conn->query("$query");

    if ($result) {
        $user_id = mysqli_insert_id($conn); // Get the last inserted user ID
          
        if ($user_type === "artist") {
            $query = "INSERT INTO users (user_id, bio) VALUES ('$user_id', 'Bio information')";
            $conn->query("$query");
            
        }
           

           
    } 
    else {
        echo "Registration failed. Some values are NULL or something else is amiss\n Check error logs \n We don't have those lol ";
    }


        // SESSION START
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["firstname"] = $firstname;
    $_SESSION["user_type"] = $user_type;

    header("Location: pocetna.php");
    exit();
    }
?>
