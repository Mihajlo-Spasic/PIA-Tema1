<?php

if($_SESSION){

    session_destroy();
    header("Location: /");
    exit();
}
else{
    echo "How did u end up here?";
    header("Location: /");
}

?>