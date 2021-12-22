<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

$redirectUrl = '/checkout/' . $type . '/step/1';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    wp_redirect($redirectUrl);
}

$postFields = [
    'licence',
];

foreach ($postFields as $postField) {
    if (array_key_exists($postField, $_POST)) {
        $_SESSION['checkout'][$postField] = $_POST[$postField];
    } else {
        wp_redirect($redirectUrl);
    }
}

$_SESSION['checkout']['reserved'] = true;
$_SESSION['checkout']['complete'] = false;

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
    <?php
    get_template_part('template-parts/checkout/progress-bar', 'front-page'); ?>
    <div class="container form__section">
        <div class="row mb-3 p-3 form__body lightblue__box">
            <div class="col-12 mb-3 text-center form__header">
                <h1>Congratulations</h1>
                <span>Our checks indicate that you are eligible for car finance</span>
            </div>
            <div class="col-12 mb-3">
                <div class="row no-gutters appointment__box">
                    <div class="col-12 col-md-3 person__box">
                            <span class="person__wrapper"><img class="" src="<?php
                                echo get_stylesheet_directory_uri() . '/images/receptionist.png' ?>" width="157"
                                                               height="199.5"/></span>
                    </div>
                    <div class="col-12 col-md-9 px-5 d-flex align-items-center">
                        <p>You can now reserve the car by paying a &pound;<?php
                            echo TC_DEPOSIT_AMOUNT; ?> deposit. Once you
                            have done this, your car concierge will call within 2 hours to arrange your appointment at
                            our <strong><?php
                                echo $location->post_title; ?></strong> store, finalise your car finance application
                            and explain what documents that you need to bring along.</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3 text-center">
                <form method="post" id="financestep2" action="/checkout/<?php
                echo $type; ?>/complete">
                    <button class="btn btn-default confirm__button" type="submit"><i class="far fa-credit-card"></i>
                        Confirm and pay &pound;<?php
                        echo TC_DEPOSIT_AMOUNT; ?> deposit
                    </button>
                </form>
                <!--<a class="btn btn-default confirm__button" href="/checkout/complete"><i
                                class="far fa-credit-card"></i>
                        Confirm and pay &pound;<?php
                echo TC_DEPOSIT_AMOUNT; ?> deposit</a>-->
            </div>
        </div>
    </div>
</main>