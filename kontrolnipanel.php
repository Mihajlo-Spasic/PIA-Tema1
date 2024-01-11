



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontrolni Panel</title>
    <link rel="stylesheet" href="Style.css">
    <style type="text/css">
        a {
            color: hotpink;
            background-color: white;
            border: 1px solid hotpink;
            border-radius: 8px;
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
    <main>
    	<a href="pocetna.php"> Pocetna strana <br></a>
    	<a href="kreirajumetnika.php"> Kreiraj umetnika <br> </a>
        	<?php
			$queryUsers = "SELECT * FROM users";
			$getusers = $conn->query($queryUsers);

			if($getusers->num_rows > 0) {
                echo "<table>";
				while ($korisnik = $getusers->fetch_assoc()) {
                    
					$userid = $korisnik['user_id'];
					$juzernejm = $korisnik['username'];
                    echo "<tr style='border:1px solid hotpink; border-radius: 8px'>";
                    echo "<td style='border:1px solid hotpink; border-radius: 8px; padding:5px'>";
					echo "Korisnik: $juzernejm ";
					echo "<a href='inspectuser.php?id=$userid'>Link ka korisniku</a>";
                    echo "</td>";
                    echo "</tr>";

				}
                echo "</table>";
				echo "<hr>";
			}
			?>


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

                    echo "<a style='background-color: aquamarine;border: none;' href='inspectkontrol.php?id=$artistID-$artworkID'><img src='$imageUrl' alt='Artwork Image' style='max-width: 300px; max-height: 300px;'></a><br>";
                    echo "Description: $description<hr>";
                    
                }
} else {
    echo "No artworks found.";
}

            ?>
        
        
        
        
        
    </main>
</body>
</html>
        
