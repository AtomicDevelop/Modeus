<?php

    function run_script($path)
    {
        return shell_exec("python3 " . escapeshellcmd($path));
    }

    function run_script_argv($path, ...$params)
    {
        ob_start();
        $command = escapeshellcmd($path);

        foreach ($params as $param)
            $command .= " \"" . $param . "\"";

        passthru("python3 " . $command); 
        $result = ob_get_clean();
        return $result;
    }

?>