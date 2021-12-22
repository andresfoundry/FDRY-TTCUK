<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

date_default_timezone_set('Europe/London');

$redirectUrl = '/checkout/' . $type . '/step/1';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    wp_redirect($redirectUrl);
}

$postFields = [
    'title',
    'firstname',
    'lastname',
    'mobile',
    'email',
    'flat',
    'house_name',
    'house_number',
    'street',
    'district',
    'towncity',
    'county',
    'postcode',
    'flat',
];

foreach ($postFields as $postField) {
    if (array_key_exists($postField, $_POST)) {
        $_SESSION['checkout'][$postField] = $_POST[$postField];
    } else {
        wp_redirect($redirectUrl);
    }
}

$_SESSION['checkout']['reserved'] = false;
$_SESSION['checkout']['complete'] = false;

if (!$_SESSION['appointmentCalendar'] || ($_SESSION['calendarGenerated'] + (60 * 15)) <= time()) {
    $days = [];
    $numDays = 3;
    $startHour = (int)date('H', strtotime('now'));
    $startMins = date('i', strtotime('now'));

    /*$startHour = 9;
    $startMins = 15;*/

    if ($startMins >= 45) {
        $startHour++;
    }
    if ($startMins < 15) {
        $startMins = '15';
    } elseif ($startMins < 30) {
        $startMins = '30';
    } elseif ($startMins < 45) {
        $startMins = '45';
    } else {
        $startMins = '00';
    }

    $startHour += 2;

    $today = strtotime('today');
    $tomorrow = strtotime('+1 day', strtotime('today'));

    if ($startHour > 20) {
        $days[] = ['timeStamp' => $tomorrow, 'dayName' => 'Tomorrow'];
    } else {
        $days[] = ['timeStamp' => $today, 'dayName' => 'Today'];
    }

    $startDate = $days[0];
    $timeStamp = $startDate['timeStamp'];
    for ($i = 1; $i <= $numDays; $i++) {
        $date = strtotime('+' . $i . ' days', $timeStamp);
        if ($date === $today) {
            $dayName = 'Today';
        } elseif ($date === $tomorrow) {
            $dayName = 'Tomorrow';
        } else {
            $dayName = date('F jS', $date);
        }
        $days[] = ['timeStamp' => $date, 'dayName' => $dayName];
    }

    /*$minutesArray = ['00', '15', '30', '45'];
    $minutes = $minutesArray[mt_rand(0, (count($minutesArray) - 1))];*/

    $openingTime = 9;
    $lastAppointment = 20;
    $allTimes = [];

    if ($startMins > 0) {
        $lastAppointment -= 1;
    }

    for ($time = $openingTime; $time <= $lastAppointment; $time++) {
        $allTimes[] = ['hour' => $time];
    }

    $appointmentCalendar = [];
    foreach ($days as $day) {
        if ($day['timeStamp'] === $today) {
            $times = [];
            if ($startHour < ($openingTime + 2)) {
                $startHour = ($openingTime + 2);
            }
            for ($time = $startHour; $time <= $lastAppointment; $time++) {
                $times[] = ['hour' => $time];
            }
        } else {
            $times = $allTimes;

            if ($startHour > 20 && $day['timeStamp'] === $tomorrow) {
                array_shift($times);
                array_shift($times);
            }

            $numTimes = count($times) - 1;
            $numDisabled = mt_rand(1, 2);
            $disabledTimes = [];
            while (count($disabledTimes) < $numDisabled) {
                $rand = mt_rand(0, $numTimes);
                if (!in_array($rand, $disabledTimes)) {
                    $disabledTimes[] = $rand;
                    $times[$rand]['disabled'] = true;
                }
            }
        }
        $appointmentCalendar[] = array_merge($day, ['times' => $times]);
    }

    $_SESSION['allTimes'] = $allTimes;
    $_SESSION['appointmentMins'] = $startMins;
    $_SESSION['appointmentCalendar'] = $appointmentCalendar;
    $_SESSION['calendarGenerated'] = time();
}

/*echo "<pre>";
echo date('H:i:s', strtotime('now'));
var_dump($_SESSION['disabledTimes']);
var_dump($_SESSION['appointmentCalendar']);
echo "</pre>";*/
//die;
?>
<script type="text/javascript">
    let appointmentMins = '<?php echo $_SESSION['appointmentMins']; ?>';
    let appointmentCalendar = <?php echo json_encode($_SESSION['appointmentCalendar']); ?>;
</script>
<main class="checkout__wrapper cash02__section">
    <?php
    get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
    <div class="progress__bar">
        <div class="container">
            <div class="row">
                <div class="col-4 d-flex align-items-start">
                    <img class="pointer__icon" src="<?php
                    echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                    &nbsp;Personal Details
                </div>
                <div class="col-4 d-flex align-items-start justify-content-center">
                    <img class="pointer__icon pointer__icon--selected" src="<?php
                    echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                    &nbsp;Your Appointment
                </div>
                <div class="col-4 d-flex align-items-start justify-content-end">
                    <img class="pointer__icon" src="<?php
                    echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                    &nbsp;Confirmation
                </div>
                <div class="col-12">
                    <hr/>
                </div>
            </div>
        </div>
    </div>
    <div class="container form__section">
        <form method="post" id="formstep2" action="/checkout/<?php
        echo $type; ?>/complete">
            <div class="row mb-3 p-3 form__body lightblue__box">
                <div class="col-12 mb-3 text-center form__header">
                    <h1>Your Appointment</h1>
                    <span>On payment of your &pound;<?php echo TC_DEPOSIT_AMOUNT; ?> deposit, your car is secured for <strong>3 days</strong>, please select a date and time to pick up your vehicle</span>
                </div>
                <div class="col-12 mb-3">
                    <div class="button__heading">
                        Date
                    </div>
                </div>
                <div class="col-12">
                    <input type="hidden" class="required" name="appointment_date" id="appointment_date" value=""/>
                    <div class="row no-gutters day__selection">
                        <?php
                        foreach ($_SESSION['appointmentCalendar'] as $day) :
                            ?>
                            <div class="col-12 col-md mb-3">
                                <button class="btn btn-whiteshadow day__button" data-date="<?php
                                echo date('Y-m-d', $day['timeStamp']); ?>" data-timestamp="<?php
                                echo $day['timeStamp']; ?>" type="button"><?php
                                    echo $day['dayName']; ?></button>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-12 error appointment_date_error">
                    <p>Please choose appointment day.</p>
                </div>
                <div class="col-12 mb-3">
                    <div class="button__heading">
                        Times
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <input type="hidden" class="required" name="appointment_time" id="appointment_time" value=""/>

                    <div class="row no-gutters time__selection">
                        <?php
                        foreach ($_SESSION['allTimes'] as $i => $time) :
                            $timeNameSuffix = '';
                            if ($_SESSION['appointmentMins']) {
                                $timeNameSuffix = ':' . $_SESSION['appointmentMins'];
                            }
                            if ($time['hour'] > 12) {
                                $timeName = ($time['hour'] - 12) . $timeNameSuffix . 'pm';
                            } else {
                                $timeName = $time['hour'] . $timeNameSuffix . 'am';
                            }

                            $time['hour'] .= ':' . $_SESSION['appointmentMins'];
                            ?>
                            <div class="col-4 col-md mb-3">
                                <button class="btn btn-whiteshadow time__button" data-time="<?php
                                echo $time['hour']; ?>" type="button"><?php
                                    echo $timeName; ?></button>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-12 error appointment_time_error">
                    <p>Please choose appointment time.</p>
                </div>
                <div class="col-12 mb-3 text-center">
                    <button class="btn btn-default confirm__button" type="submit"><i class="far fa-credit-card"></i>
                        Confirm and pay &pound;<?php echo TC_DEPOSIT_AMOUNT; ?> deposit
                    </button>
                    <!--<a class="btn btn-default confirm__button" href="/checkout/complete"><i
                                class="far fa-credit-card"></i>
                        Confirm and pay &pound;<?php echo TC_DEPOSIT_AMOUNT; ?> deposit</a>-->
                </div>
            </div>
        </form>
    </div>
</main>