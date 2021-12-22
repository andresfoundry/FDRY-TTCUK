<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

$redirectUrl = '/checkout/' . $type . '/step/1';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    wp_redirect($redirectUrl);
}

$postFields = [
    'appointment_date',
    'appointment_time',
];

foreach ($postFields as $postField) {
    if (array_key_exists($postField, $_POST)) {
        $_SESSION['checkout'][$postField] = $_POST[$postField];
    } else {
        wp_redirect($redirectUrl);
    }
}
$_SESSION['checkout']['reserved'] = true;
$_SESSION['checkout']['complete'] = true;

/*echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
die;*/

$date = strtotime($_SESSION['checkout']['appointment_date'] . ' ' . $_SESSION['checkout']['appointment_time']);
$location = get_post(get_field('location', $carId));

?>
<main class="checkout__wrapper cashconfirmation__section">
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
                    <img class="pointer__icon" src="<?php
                    echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                    &nbsp;Your Appointment
                </div>
                <div class="col-4 d-flex align-items-start justify-content-end">
                    <img class="pointer__icon pointer__icon--selected" src="<?php
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
        <div class="row mb-3 p-3 form__body lightblue__box">
            <div class="col-12 mb-3 text-center form__header">
                <h1>Congratulations</h1>
                <span>The payment was successful and your <?php
                    echo $make_name . ' ' . $model_name; ?> is now reserved.  Your unique reference no. is <strong>XYZABC123</strong>.</span>
            </div>
            <div class="col-12 mb-3">
                <div class="row no-gutters appointment__box">
                    <div class="col-12 col-md-3 d-none d-md-flex person__box">
                            <span class="person__wrapper"><img class="" src="<?php
                                echo get_stylesheet_directory_uri() . '/images/receptionist.png' ?>" width="157"
                                                               height="199.5"/></span>
                    </div>
                    <div class="col-12 col-md-9 px-5 d-flex align-items-center">
                        <p>We have emailed you a copy of your reservation. We look forward to seeing you at our
                            <strong><?php
                                $dateFormat = 'l jS (ga)';
                                if ($_SESSION['appointmentMins'] > 0) {
                                    $dateFormat = 'l jS (g:ia)';
                                }
                                echo $location->post_title; ?></strong> showroom on <strong><?php
                                echo date($dateFormat, $date); ?></strong>. One of our car concierge team will call you
                            shortly to confirm your appointment and answer any queries you may have. Thank you for
                            buying from Trade Centre.</p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <img class="" src="<?php
                        echo $carImage; ?>" />
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="row no-gutters h-100">
                            <div class="col-12 p-3 white__box pickup__details">
                                <h4>Your pickup location is at <?php
                                    echo $location->post_title; ?></h4>
                                <p><?php
                                    the_field('address_line_1', $location->ID); ?><br/>
                                    <?php
                                    the_field('address_line_2', $location->ID); ?><br>
                                    <strong><?php
                                        the_field('town_city', $location->ID); ?></strong><br>
                                    <?php
                                    the_field('postcode', $location->ID); ?><br>
                                    <br/>
                                    Opening Times<br/>
                                    Mon-Fri <strong><?php
                                        the_field('opening_times_weekdays', $location->ID); ?></strong><br/>
                                    Sat-Sun <strong><?php
                                        the_field('opening_times_weekends', $location->ID); ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="row no-gutters h-100">
                            <div class="col-12 p-3 white__box pickup__details">
                                <h4>What do I need to bring with me?</h4>
                                <ul>
                                    <li>Driving Licence</li>
                                    <li>Two other forms of ID
                                    <li>Means of payment
                                        <!--(if paying by cash)-->
                                    </li>
                                    <?php
                                    if ($_SESSION['upfront'] == 999) :
                                    ?>
                                    <li>Your part-exchange</li>
                                    <li>Part-exchange documents V5C, MOT and any service history</li>
                                    <li>Spare keys for your part-exchange</li>
                                    <?php
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="row no-gutters h-100">
                            <div class="col-12 px-3 mediumblue__box car__details d-flex align-items-center">
                                <div>
                                    <h2><?php
                                        echo $make_name . ' ' . $model_name; ?></h2>
                                    <span><?php
                                        echo get_field('derivative', $carId); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <a class="btn btn-default w-100 map-button"
                           href="https://maps.google.com/maps?q=tradecentre%20<?php
                           the_field('api_name', $location->ID); ?>"
                           target="_blank"
                           data-gmap="<?php
                           the_field('map_link', $location->ID); ?>"
                           data-modaltitle="<?php
                           echo $location->post_title . ' - ' . get_field('postcode', $location->ID); ?>">
                            <img src="/images/maps-icon.svg" height="46"/>&nbsp;Directions
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3 text-center">
                <button class="btn btn-default print__button" type="button">Print</button>
            </div>
</main>