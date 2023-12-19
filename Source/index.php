<?php

    include "temp_parser.php";

    session_start();

    if (isset($_SESSION["auth"]))
    {
        $_SESSION["calendar"] = get_session_calendar($_SESSION["auth"]);
        header("Location: main.php");
        exit;
    }
    else
    {
        header("Location: auth.php");
        exit;
    }

?>