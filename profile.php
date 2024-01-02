<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include 'register.php';
global $conn;

$artistID = $_GET['id'];

$quryUsername = "SELECT username FROM users WHERE user_id = $artistID";
$artistUsernameFetch = $conn->query($quryUsername);
$artistUsername = $artistUsernameFetch->fetch_assoc();
// echo var_dump($artistUsername);
$artist = $artistUsername['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $artist ?>'s page</title>
</head>
<body>
    <h1>WELCOME TO <?php echo $artist ?>'s profile</h1>
</body>
</html>


<?php


$artworksQuery = "SELECT * FROM artworks WHERE artist_id = $artistID";
$queryResult = $conn->query($artworksQuery);

if ($queryResult->num_rows > 0) {
    while ($artwork = $queryResult->fetch_assoc()) {
        // echo var_dump($artwork);
        $imageUrl = $artwork['image_url'];
        $description = $artwork['description'];

        echo "<a href='inspect_picture.php?id={$artwork['artist_id']}-{$artwork['artwork_id']}'><img src='$imageUrl' alt='$description' style='max-width: 300px; max-height: 300px;'></a>";
       //inspect_picture.php?id=$artistID-$artworkID
        $getVisits = "SELECT visits FROM artworks WHERE artwork_id = {$artwork['artwork_id']}";
        $result = $conn->query($getVisits);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $visits = $row["visits"];
            echo "Number of visits for the artwork (Artwork ID: {$artwork['artwork_id']}): $visits<br>";
        }
       
       $sql = "SELECT users.username
        FROM user_likes
        JOIN users ON user_likes.user_id = users.user_id
        WHERE user_likes.artwork_id = {$artwork['artwork_id']} AND user_likes.liked = 1";

$result = $conn->query($sql);

// Display the usernames of users who liked the picture
if ($result->num_rows > 0) {
    echo "<br>Users who liked the picture (Artwork ID: {$artwork['artwork_id']} ):<br>";
    while ($row = $result->fetch_assoc()) {
        echo $row["username"] . "<br>";
    }
} else {
    echo "No users liked the picture (with Artwork ID: {$artwork['artwork_id']})<br> ";
}
    
    }
   


} else {
    if ($_SESSION['user_type'] =='artist'){
    echo "No artworks found for this artist.";
    }
}

if ($_SESSION['user_type'] =="user"){
    $sql = "SELECT artworks.*
        FROM user_likes
        JOIN artworks ON user_likes.artwork_id = artworks.artwork_id
        WHERE user_likes.user_id = {$_SESSION['user_id']} AND user_likes.favorite = 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
 
        echo "<img src='" . $row["image_url"] . "' alt='" . $row["title"] . "'>";
    }
} else {
    echo "No favorite pictures found for user ID: {$_SESSION['user_id']}";
}
}

?>