<?php

    include "modeus.php";

    init_modeus();

    global $ini;

    function get_current_calendar_path($time)
    {
        global $ini;

        if (!is_dir($ini["temp_path"])) 
            return null;

        $time = preg_replace("/\s+/", "", str_replace(":", "-", $time));

        $dir = opendir($ini["temp_path"]);

        while ($file = readdir($dir)) 
        {
            $result = preg_replace("/\s+/", "", $file);

            if (strpos($result, $time, 1))
                return $file;
        }
        echo "cant find file";
        return null;
    }

    function get_calendar_content($file_path)
    {
        global $ini;

        if ($file_path == null)
            return null;

        $content = file_get_contents("{$ini["temp_path"]}/{$file_path}");

        unlink("{$ini["temp_path"]}/{$file_path}");

        return $content;
    }

    function get_session_calendar($session_time)
    {
        return get_calendar_content(get_current_calendar_path($session_time));
    }

?>