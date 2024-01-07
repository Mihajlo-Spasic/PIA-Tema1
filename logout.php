<?php

if($_SESSION){
    session_destroy();
    header("Location: http://localhost/PIA-Tema1-master/");
    exit();
}
else{
    //echo "How did u end up here?";
    session_destroy();
    header("Location: http://localhost/PIA-Tema1-master/");
    exit();
}

?>