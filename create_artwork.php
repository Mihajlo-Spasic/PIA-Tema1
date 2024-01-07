<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hihi create artwork hehe </title>
</head>
<body>

<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

$db = "PIAproject";
$table = "users";
$conn = new mysqli("localhost","root","","piaproject") or exit("affaf");
// promeni sa svojom databazom

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    global $conn;

    $username = $conn->real_escape_string($_SESSION['username']);
    $uploadDir = 'uploads/';
    $artistIDResult = $conn->query("SELECT user_id FROM users WHERE username='$username'");
    $row = $artistIDResult->fetch_assoc();
    $artistID = $row['user_id'];
    $uploadFile = $uploadDir . $artistID ."_". basename($_FILES['photo']['name']);

 
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
    
        echo '<img src="' . $uploadFile . '" alt="Uploaded Photo" style="max-width: 300px; max-height: 300px;"><br>';

        echo '<strong>Date of Creation:</strong> ' . htmlspecialchars($_POST['creation_date']) . '<br>';
        echo '<strong>Dimensions:</strong> ' . htmlspecialchars($_POST['dimensions']) . '<br>';
        echo '<strong>Technique:</strong> ' . htmlspecialchars($_POST['technique']) . '<br>';
        echo '<strong>Name:</strong> ' . htmlspecialchars($_POST['name']) . '<br>';
        echo '<strong>Cost:</strong> ' . htmlspecialchars($_POST['cost']) . '<br>';
        echo '<strong>On Sale:</strong> ' . (isset($_POST['on_sale']) ? 'Yes' : 'No') . '<br>';
        echo '<strong>Bio:</strong> ' . htmlspecialchars($_POST['bio']) . '<br>';
        
        $date = $conn->real_escape_string($_POST['creation_date']);
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateObject || $dateObject->format('Y-m-d') !== $date) {
            die("Error: Invalid date format. Please use YYYY-MM-DD.");
        }
        
        $cost = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);
        if ($cost === false) {
            die("Error: Invalid cost value. Please enter a valid numeric value.");
        }

        $on_sale = isset($_POST['on_sale']) ? 1 : 0; 
        $title = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['bio']);
        $dimensions = $conn->real_escape_string($_POST['dimensions']);
        $technique = $conn->real_escape_string($_POST['technique']);
        $uploadFile = $uploadDir . $artistID ."_". basename($_FILES['photo']['name']);

        $insertPhoto = "INSERT INTO artworks (artist_id, title, description, image_url, creation_date, technique, cost, on_sale, dimensions) VALUES ('$artistID', '$title', '$description', '$uploadFile', '$date', '$technique', '$cost', '$on_sale', '$dimensions')";

        $conn->query($insertPhoto);

    } else {
        echo 'Error uploading the file.';
    }
    
}
?>

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
