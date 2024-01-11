<?php

if($_SESSION){
    session_destroy();
    header("Location: index.php");
    exit();
}
else{
    //echo "How did u end up here?";
    session_destroy();
    header("Location: index.php");
    exit();
}

?>