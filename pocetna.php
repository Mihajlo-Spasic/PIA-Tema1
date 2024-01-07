



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;


            background-color: #533; 
            /* Samo trenutna boja bole me oci na belo promeni po volji */
        }

        header {
            background-color: #24292e;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        .user-info {
            float: right;
            padding: 15px;
            background-color: #333
            
        }
        .user-info p{
            float: left;
            margin: 0px;
            margin-top:5px;
            margin-right: 20px;
        }
        .user-info a{
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #fff;
            border-radius: 5px;
        }

        .user-info a:hover {
            background-color: #fff;
            color: #24292e;
        }

        .id1{
            float:right;
        }

        .desno{
            float:right;
        }

        main {
            padding: 20px;
        }
    </style>
    <?php 
        include "register.php";
        include "login.php";
        session_start();
        
        global $conn;

        // echo var_dump($_SESSION);


    ?>
</head>
<body>

    <header>
        <?php
     
        ?>
    </header>

    <nav>

    <div class="top-bar">
            <div class="user-info">
                <?php if($_SESSION['username'] =="Guest"){
                    $_SESSION['firstname'] = "Guest";
                }
                ?>
            <p>Welcome <?php echo $_SESSION["firstname"]; ?></p>
                <a href="logout.php">Logout</a>
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

    <main>
        
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

                    echo "Artist: $artistUsername<br>";
                    echo "Title: $title<br>";

                    echo "<a href='inspect_picture.php?id=$artistID-$artworkID'><img src='$imageUrl' alt='Artwork Image' style='max-width: 300px; max-height: 300px;'></a><br>";
                    echo "Description: $description<br>";
                    echo "<br>";
                    
                }
} else {
    echo "No artworks found.";
}

            ?>
        
        
        
        
        
    </main>
</body>
</html>
        
