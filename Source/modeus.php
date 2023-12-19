<?php

    include "script_runner.php";

    $ini;

    function init_modeus()
    {
        global $ini;

        $ini = parse_ini_file("modeus_setup.ini");

        function auth_modeus_user($email, $password)
        {
            global $ini;

            $result = run_script_argv("scripts/get_calendar.py", $ini["temp_path"], $ini["modeus_domain_name"], $email, $password);

            if ($result === "time_out" || $result === "login_error" || $result === "invalid_params")
                return false;

            return $result;
        }
    }

?>