



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="Style.css">
    <?php 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        


        include "register.php";
        include "login.php";
        session_start();
        
        global $conn;

        // echo var_dump($_SESSION);


    ?>
    <style type="text/css">
        table {
            left: 10%;
            position: relative;
            max-width: 80%;
            width: 80%;
        }
        td {
            width: 50%;
            max-width: 50%;
            text-align: left;
        }
    </style>
</head>
<body>

    <header>
        <?php
     
        ?>
    </header>

    <nav>

    <div >
            <div style="vertical-align: top; top:20px" class="user-info">
                <?php if($_SESSION['username'] =="Guest"){
                    $_SESSION['firstname'] = "Guest";
                }
                ?>
                <p>Welcome <?php echo $_SESSION["firstname"]; ?></p>
                <a style="border: none" href="logout.php">Logout</a>

            </div>
        <a href="pocetna.php">Home</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>

        <div class="desno">
        <?php
        if ($_SESSION['username'] != "Guest"){
        $username = $conn->real_escape_string($_SESSION['username']);
        $query = "SELECT user_id FROM users WHERE username = '$username'";
        $artistIDResult = $conn->query($query);

      
            $row = $artistIDResult->fetch_assoc();
            $artistID = $row['user_id'];
            if ($_SESSION['user_type'] == "artist") {
                echo "<a href=create_artwork.php>Create Artwork</a>";
                echo "<a href=profile.php?id=$artistID>Profile</a>";
            //ovde sam dodao za administrator dugmad, konkretno za kontrolni panel i profil  
            } else if ($_SESSION['user_type'] == "admin") {
                echo "<a href='profile.php?id={$_SESSION['user_id']}'>Profile</a>";
                echo "<a href=kontrolnipanel.php alt='Mrzim sebe'>Kontrolni Panel</a>";
            }
            else{
                echo "<a href='profile.php?id={$_SESSION['user_id']}'>Profile</a>";

            }
        }
    
        
        ?>
        </div>
    </div>
    </nav>

    <main style="width: auto;">
        
            <?php
            $queryArtworks = "SELECT * FROM artworks";
            $getAllArtworks = $conn->query($queryArtworks);

            
            if ($getAllArtworks->num_rows > 0) {
                while ($artwork = $getAllArtworks->fetch_assoc()) {
                    $artworkID = $artwork['artwork_id'];
                    $artistID = $artwork['artist_id'];
                    $title = $artwork['title'];
                    $description = $artwork['description'];
                    $imageUrl = $artwork['image_url'];
                    $creationDate = $artwork['creation_date'];
                    $technique = $artwork['technique'];
                    $cost = $artwork['cost'];
                    $onSale = $artwork['on_sale'];
                    $dimensions = $artwork['dimensions'];
                    
                    $queryArtistUsername = "SELECT username FROM users WHERE user_id = $artistID";
                    $getArtistUsername = $conn->query($queryArtistUsername);
                    $artistUsername = $getArtistUsername->fetch_assoc()['username'];
                    echo "<table> <tr> <td>";
                    echo "Artist: $artistUsername</td></tr>";
                    echo "<tr><td>Title: $title</td></tr>";
                    echo "<tr><td>";
                    echo "<a  href='inspect_picture.php?id=$artistID-$artworkID'><img src='$imageUrl' alt='Artwork Image' style='max-width: 500px; max-height: 500px;'></a></td>";
                    echo "<td style='vertical-align:top'>Description: $description </td></tr></table>";
                    
                    echo "</div>";
                    
                }
} else {
    echo "No artworks found.";
}

            ?>
        
        
        
        
        
    </main>
</body>
</html>
        
