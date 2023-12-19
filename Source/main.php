<?php
    include "parser/ICal.php";

    use ICal\ICal;

    session_start();

    if (!isset($_SESSION["calendar"]))
    {
        print("no session calendar");
        $_SESSION["auth"] = null;
        header("Location: index.php");
        exit;
    }

    $data = [];
    $data[] = $_SESSION["calendar"];

    try {
        $ical = new ICal($data, array(
            'defaultSpan'                 => 2,     // Default value
            'defaultTimeZone'             => 'UTC',
            'defaultWeekStart'            => 'MO',  // Default value
            'disableCharacterReplacement' => false, // Default value
            'filterDaysAfter'             => null,  // Default value
            'filterDaysBefore'            => null,  // Default value
            'httpUserAgent'               => null,  // Default value
            'skipRecurrence'              => false, // Default value
        ));
    } 
    catch (\Exception $e) {
        die($e);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Расписание</title>
    <style>body { background-color: #eee }</style>
</head>
<body>
<div class="container-fluid">
    <?php
        $showConfig = array(
            'interval' => true,
            'range'    => false,
            'all'      => false,
        );

        if ($showConfig['interval']) {
            $events = $ical->eventsFromInterval('1 week');

        if ($events)
            echo '<h4 class="mt-3 mb-2">Текущая неделя:</h4>';

        $count = 1;
        $day = 0;
        $old_day = 0;
    ?>
    <div class="row">
        <?php
        foreach ($events as $event): ?>
            <?php
                $dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
                $day = $dtstart->format('d');
                if ($old_day == 0)
                    $old_day = $day;

                if ($day != $old_day)
                {
                    $old_day = $day;
                    echo '</div><hr><div class="row">';
                }
            ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mt-3 mb-2">
                            <?php
                                echo strstr($event->summary, "/", true) . ' (' . $dtstart->format('d-m-Y H:i') . ')';
                            ?>
                        </h3>
                        <?php echo $event->printData() ?>
                    </div>
                </div>
            </div>
        <?php
        endforeach ?>
    </div>
    <?php } ?>
</div>
</body>
</html>