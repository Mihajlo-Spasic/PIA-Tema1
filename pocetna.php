

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

        main {
            padding: 20px;
        }
    </style>
    <?php 
        include "register.php";
        include "login.php";
        session_start();

        global $conn;
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
            <p>Welcome <?php echo $_SESSION["firstname"]; ?></p>
                <a href="logout.php">Logout</a>
            </div>
        <a href="pocetna.php">Home</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>

        <?php
        $username = $conn->real_escape_string($_SESSION['username']);
        $query = "SELECT user_id FROM users WHERE username = '$username'";
        $artistIDResult = $conn->query($query);

      
            $row = $artistIDResult->fetch_assoc();
            $artistID = $row['user_id'];
            // BANE POMERI DUGMICE DESNO PLS
            if ($_SESSION['user_type'] == "artist") {
                echo "<a href=create_artwork.php>Create Me ;)</a>";
                echo "<a href=profile.php?id=$artistID>Profile</a>";
            }
        
    
        
        ?>
    </nav>

    <main>
        
            



    </main>
</body>
</html>
