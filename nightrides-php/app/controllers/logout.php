<?php
    session_start();     // zahájí session
    session_unset();     // smaže všechny session proměnné
    session_destroy();   // zničí session

    header("Location: ../views/common/index.php");
    exit();