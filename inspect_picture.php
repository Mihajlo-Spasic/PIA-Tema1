<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="Style.css">
    <style type="text/css">
        a {
            color: hotpink;
            background-color: white;
            text-decoration: none;
            border: 1px solid hotpink;
            border-radius: 8px;
        }

        body a:hover {
            color: purple;

        }

        td {
            font-size: 20px;
            text-align: center;
            align-items: center;
            vertical-align: top;
            background-color: white;
            border: 1px solid hotpink;
            border-radius: 8px;
        }
        button {
            font-size: 20px;
            vertical-align: top;
            text-align: cetner;
            align-items: center;
        } 
    </style>
</head>
<body>
    <?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

$conn = new mysqli("localhost","spale","Spale666","PIAproject") or exit("affaf");

$picture_id = $_GET['id'];

$parts = explode("-", $picture_id);
$artist_id = $parts[0];
$artwork_id = $parts[1];

// echo var_dump($_SESSION);
echo "<a href=pocetna.php>HOME</a><br>";
$queryArtworks = "SELECT * FROM artworks WHERE artwork_id = $artwork_id";
$getAllArtworks = $conn->query($queryArtworks);

$queryComments = "SELECT * FROM comments WHERE artwork_id = $artwork_id";
$getAllComments = $conn->query($queryComments);

if ($getAllArtworks->num_rows > 0) {
    while ($artwork = $getAllArtworks->fetch_assoc()) {
        // echo var_dump($artwork);
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
        $likes = $artwork['likes'];
        $queryArtistUsername = "SELECT username FROM users WHERE user_id = $artistID";
        $getArtistUsername = $conn->query($queryArtistUsername);
        $artistUsername = $getArtistUsername->fetch_assoc()['username'];
        echo "<br>";
        echo "UserID: {$_SESSION['user_id']}<br>";
        echo "ArtworkID $artworkID"; 


        echo "Artist: $artistUsername<br>";
        echo "Title: $title<br>";
        echo "<img src='$imageUrl' alt='Artwork Image' style='max-width: 300px; max-height: 300px;'><br>";
        echo "Description: $description<br>";


        $updateVisits = "UPDATE artworks SET visits = visits + 1 WHERE artwork_id = $artwork_id";
        $conn->query($updateVisits);


        $sql = "SELECT grade
        FROM user_likes
        WHERE artwork_id = $artwork_id AND grade IS NOT NULL";

$result = $conn->query($sql);

// Display the average grade for the picture
    if ($result->num_rows > 0) {
        $sumGrades = 0;
        $numGrades = 0;

        while ($row = $result->fetch_assoc()) {
            $sumGrades += $row["grade"];
            $numGrades++;
        }

        $averageGrade = $numGrades > 0 ? $sumGrades / $numGrades : 0;
        echo "Average grade for the picture (Artwork ID: $artwork_id): " . round($averageGrade, 2) . "<br>";
    } else {
        echo "No grades (Artwork ID): $artwork_id </br>";
    }


        $sql = "SELECT SUM(liked) as likeCount
        FROM user_likes
        WHERE artwork_id = $artwork_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $likeCount = $row["likeCount"];
            echo "likes(Artwork ID: $artwork_id): $likeCount </br>";
        } else {
            echo "No likes found for the picture with Artwork ID: $artwork_id";
        }

        if ($_SESSION['username'] != "Guest") {
            $gradeFormSubmitted = false;

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gradeSubmit'])) {
                $gradeFormSubmitted = true;
        
                $newGrade = (isset($_POST['grade']) && is_numeric($_POST['grade'])) ? intval($_POST['grade']) : null;
        
                if ($newGrade !== null && $newGrade >= 0 && $newGrade <= 10) {
                    $updateQuery = "INSERT INTO user_likes (user_id, artwork_id, grade) VALUES ({$_SESSION['user_id']}, $artwork_id, $newGrade) ON DUPLICATE KEY UPDATE grade = $newGrade";
                    $conn->query($updateQuery);
        
                } else {
                }
            }
        
            $queryIfGradeExists = "SELECT grade FROM user_likes WHERE user_id = {$_SESSION['user_id']} AND artwork_id = $artwork_id";
            $queryResultIfGradeExists = $conn->query($queryIfGradeExists);
        
            if ($queryResultIfGradeExists) {
                $row = $queryResultIfGradeExists->fetch_assoc();
                $currentGrade = isset($row['grade']) ? $row['grade'] : null;
            } else {
                echo "Error: " . $conn->error;
            }
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $artist_id . '-' . $artwork_id; ?>">
                <label for="grade">Ocena(0-10): </label>
                <input type="number" name="grade" id="grade" min="0" max="10" value="<?php echo $currentGrade; ?>" required>
                <button type="submit" name="gradeSubmit">Submit</button>
            </form>
        <?php
        
        $likeFormSubmitted = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['likeSubmit'])) {
            $likeFormSubmitted = true;
    
            $queryIfLikeExists = "SELECT liked FROM user_likes WHERE user_id = {$_SESSION['user_id']} AND artwork_id = $artwork_id";
            $queryResultIfLikeExists = $conn->query($queryIfLikeExists);
    
            if ($queryResultIfLikeExists) {
                $rowLikes = $queryResultIfLikeExists->fetch_assoc();
    
                $newLikeStatus = ($rowLikes['liked'] == 1) ? 0 : 1;
    
                $updateLikeQuery = "INSERT INTO user_likes (user_id, artwork_id, liked) VALUES ({$_SESSION['user_id']}, $artwork_id, $newLikeStatus) ON DUPLICATE KEY UPDATE liked = $newLikeStatus";
                $conn->query($updateLikeQuery);
    
                
            } else {
                echo "Error: " . $conn->error;
            }
        }
    ?>
    <table>
        <tr>
            <td style="height:auto;">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $artist_id . '-' . $artwork_id; ?>">            
                    <button style='border:none;'type="submit" name="likeSubmit">Like</button>
                </form>
            </td>
            <td style="height:auto;">
                <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $artist_id . '-' . $artwork_id; ?>">            
                    <button style='border:none;' strong type="submit" name="favoriteSubmit">Favorite</button>
                 </form>
            </td>
            <td style="padding:2px; height:auto">
              
                    <a style='border:none;' href='#' target='_blank'>Share Inst</a>
               
            </td>
            <td style="padding:2px; height:auto">
                <a style='border:none;' href='https://twitter.com/intent/tweet?text=Check%20out%20this%20artwork:%20$title%20by%20$artistUsername' target='_blank'>Share X</a>
            </td>
        </tr>
    </table>

    <?php
              $queryFavorite = "SELECT favorite FROM user_likes WHERE user_id = {$_SESSION['user_id']} AND artwork_id = $artwork_id";
              $resultFavorite = $conn->query($queryFavorite);
          
              if ($resultFavorite) {
                  $rowFavorite = $resultFavorite->fetch_assoc();
              } else {
                  echo "Error: " . $conn->error;
              }
          
              $favoriteFormSubmitted = false; 
              if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['favoriteSubmit'])) {
                  $favoriteFormSubmitted = true;
          
                  if (isset($rowFavorite['favorite'])) {
                      $newFavoriteStatus = ($rowFavorite['favorite'] == 1) ? 0 : 1;
                      $updateFavoriteQuery = "UPDATE user_likes SET favorite = $newFavoriteStatus WHERE user_id = {$_SESSION['user_id']} AND artwork_id = $artwork_id";
          
                      if ($conn->query($updateFavoriteQuery)) {
                      } else {
                      }
                  } else {
                      $insertFavoriteQuery = "INSERT INTO user_likes (user_id, artwork_id, favorite) VALUES ({$_SESSION['user_id']}, $artwork_id, 1)";

                      if ($conn->query($insertFavoriteQuery)) {
                      } else {    
                      }
                  }
              }
              ?>
          <?php


        }
    






        
        //echo "<a href='#' target='_blank'>Share Inst   </a>";
        //echo "<a href='https://twitter.com/intent/tweet?text=Check%20out%20this%20artwork:%20$title%20by%20$artistUsername' target='_blank'>Share X   </a>";
        
        // x radi ,instagram ne who cares
     


        if ($getAllComments) {
       
            if ($getAllComments->num_rows > 0) {
                echo '<div style="border: 1px solid hotpink; padding: 10px; margin: 10px; border-radius: 5px; background-color: white">';
                
                while ($comment = $getAllComments->fetch_assoc()) {
                 
                    $commentAuthor = $comment['user_id'];
                    $commentDate = $comment['comment_date'];
                    $commentText = $comment['comment'];
                    
                    $queryUsernameFromUser_id = "SELECT username FROM users WHERE user_id = $commentAuthor";
                    $UsernameFromUser_id = $conn->query($queryUsernameFromUser_id);
                    $userRow = $UsernameFromUser_id->fetch_assoc();
                    $commentAuthorUsername = $userRow['username'];
                    echo "Username: $commentAuthorUsername<br>";
                    echo "Comment Date: $commentDate<br>";
                    echo "Comment Text: $commentText<br>";
                    echo "<hr>";
                }
        
                echo '</div>'; 
            } else {
                echo '<div>No comments found.</div>';
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['username'] != "Guest" && $_SESSION['user_type'] == "user") {
    if (isset($_POST['comment'])) { // Check if 'comment' is set in $_POST
        $tableName = 'comments';  

        $commentText = $_POST['comment'];
        $user_id = $_SESSION['user_id'];
        $comment_date = date("Y-m-d H:i:s");

        $insertQuery = "INSERT INTO $tableName (user_id, artwork_id, comment, comment_date) VALUES ('$user_id', '$artwork_id', '$commentText','$comment_date')";
        $result = $conn->query($insertQuery);

        if ($result) {
            echo '<p>Comment submitted successfully!</p>';
        } else {
            echo '<p>Error submitting comment: ' . $conn->error . '</p>';
        }
    } else {
       echo "";
    }
}


if ($_SESSION['username'] != "Guest"){
    if ($_SESSION['user_type'] == "user") {
        echo '
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $artist_id ."-". $artwork_id . '">
        <label for="comment">Comment:</label>
        <textarea name="comment" rows="4" cols="50" required></textarea><br>
            
            <input type="submit" value="Submit Comment">
        </form>';
    }
}
?>
</body>
</html>
