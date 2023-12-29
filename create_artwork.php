<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hihi create artwork hehe</title>
</head>
<body>

<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

$db = "PIAproject";
$table = "users";
$conn = new mysqli("localhost","spale","Spale666","PIAproject") or exit("affaf");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        // Display the uploaded photo
        echo '<img src="' . $uploadFile . '" alt="Uploaded Photo" style="max-width: 300px; max-height: 300px;"><br>';

        // Display additional information
        echo '<strong>Date of Creation:</strong> ' . htmlspecialchars($_POST['creation_date']) . '<br>';
        echo '<strong>Dimensions:</strong> ' . htmlspecialchars($_POST['dimensions']) . '<br>';
        echo '<strong>Technique:</strong> ' . htmlspecialchars($_POST['technique']) . '<br>';
        echo '<strong>Name:</strong> ' . htmlspecialchars($_POST['name']) . '<br>';
        echo '<strong>Cost:</strong> ' . htmlspecialchars($_POST['cost']) . '<br>';
        echo '<strong>On Sale:</strong> ' . (isset($_POST['on_sale']) ? 'Yes' : 'No') . '<br>';
        echo '<strong>Bio:</strong> ' . htmlspecialchars($_POST['bio']) . '<br>';
        
        
        $title = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['bio']);
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        $date = $conn->real_escape_string($_POST['creation_date']);
        $technique = $conn->real_escape_string($_POST['technique']);
        $cost = $conn->real_escape_string($_POST['cost']);
        $on_sale = isset($_POST['on_sale']) ? 1 : 0; 
        $dimensions = $conn->real_escape_string($_POST['dimensions']);
    
        global $conn;
        $username = $conn->real_escape_string($_SESSION['username']);
        echo "username: $username";
        $artistIDResult = $conn->query("SELECT user_id FROM users WHERE username='$username'");
        $row = $artistIDResult->fetch_assoc();
        $artistID = $row['user_id'];
        echo "artist id: $artistID";
    
        $insertPhoto = "INSERT INTO artworks (artist_id, title, description, image_url, creation_date, technique, cost, on_sale, dimensions) VALUES ('$artistID', '$title', '$description', '$uploadFile', '$date', '$technique', '$cost', '$on_sale', '$dimensions')";
    
        $conn->query($insertPhoto);
    } else {
        echo 'Error uploading the file.';
    }
    
}
?>

<!-- Photo Upload Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="photo">Upload Photo:</label>
    <input type="file" name="photo" id="photo" required><br>

    <label for="creation_date">Date of Creation:</label>
    <input type="text" name="creation_date" id="creation_date" required><br>

    <label for="dimensions">Dimensions:</label>
    <input type="text" name="dimensions" id="dimensions" required><br>

    <label for="technique">Technique:</label>
    <input type="text" name="technique" id="technique" required><br>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="cost">Cost:</label>
    <input type="text" name="cost" id="cost" required><br>

    <label for="on_sale">On Sale:</label>
    <input type="checkbox" name="on_sale" id="on_sale"><br>

    <label for="bio">Bio:</label>
    <textarea name="bio" id="bio" rows="4" required></textarea><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
