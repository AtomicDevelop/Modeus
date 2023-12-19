<?php 

    session_start();

    include "modeus.php";
    include "auth-form.html";

    init_modeus();

    if (!isset($_POST['login']))
        exit;

    if (isset($_POST["username"]) && isset($_POST["password"]))
    {
        if ($_POST["username"] == "" || $_POST["password"] == "")
            exit;

        $result = auth_modeus_user($_POST["username"], $_POST["password"]);

        if ($result)
        {
            $_SESSION["auth"] = $result;
            header("Location: index.php");
            exit;
        }
    }
?>