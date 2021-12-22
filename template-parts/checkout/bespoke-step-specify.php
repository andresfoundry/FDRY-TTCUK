<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

$redirectUrl = '/checkout/' . $type . '/' . $carId;

if ($carId = get_query_var('car_id')) {
    $post = get_post($carId);
    if (!$post) {
        wp_redirect('/');
    }
    $_SESSION['car_id'] = $carId;
}

/*if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
}*/

$_SESSION['checkout']['reserved'] = false;
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
    <div class="container form__section">
        <form method="post" id="bespokestep0" action="/checkout/<?php
        echo $type; ?>/payment">
            <input type="hidden" name="car_id" value="">
        <div class="row mb-3 p-3 form__body lightblue__box">
            <div class="col-12 mb-3 text-center form__header">
                <h1>Bespoke Deal</h1>
                <span>Have a larger cash deposit and/or part-exchange worth more than £1000?</span>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="row no-gutters h-100">
                    <div class="col-12 p-4 text-center white__box bespoke__details">
                        <h4 class="text-center mb-4">Cash deposit</h4>
                        <label for="depositamount">Enter Amount (min &pound;<?php echo TC_DEPOSIT_AMOUNT; ?>)</label><input class="required" type="text" id="depositamount" name="depositamount" />
                        <div class="col-12 p-0 pt-2 text-left error depositamount_error">
                            <p>Please enter deposit</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 mb-3">
                <div class="row no-gutters h-100">
                    <div class="col-12 p-4 white__box bespoke__details">
                        <h4 class="text-center mb-4">Part-exchange (if any)</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 text-center">
                                <label for="carreg">Enter REG</label><input type="text" id="carreg" name="carreg" />
                                <div class="col-12 p-0 pt-2 text-left error carreg_error">
                                    <p>Please enter car registration</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 text-center">
                                <label for="mileage">Enter Mileage</label><input type="text" id="mileage" name="mileage" />
                                <div class="col-12 p-0 pt-2 text-left error mileage_error">
                                    <p>Please enter mileage</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3 isoutstandingfinance" style="display: none;">
                <div class="row no-gutters h-100">
                    <div class="col-12 p-4 white__box bespoke__details">
                        <div class="row">
                            <div class="col-12 mb-3">
                                Any outstanding finance on your Part-Exchange?
                            </div>
                            <div class="col-12">
                                <input type="hidden" class="required" name="outstandingfinance" id="outstandingfinance" value="" />
                                <div class="row">
                                    <div class="col-12 col-md-3 mb-3">
                                        <button class="btn btn-whiteshadow outstandingfinance__button" type="button">Yes</button>
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <button class="btn btn-whiteshadow outstandingfinance__button" type="button">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3 outstandingfinanceamount" style="display: none;">
                <div class="row no-gutters h-100">
                    <div class="col-12 p-4 white__box bespoke__details">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="mileage">Outstanding finance amount</label><input type="text" id="outstandingfinanceamount" name="outstandingfinanceamount" />
                                <div class="col-12 p-0 pt-2 text-left error mileage_error">
                                    <p>Please enter mileage</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3 d-flex justify-content-end">
                <button class="btn btn-default" type="submit">Next step</button>
            </div>

        </div>
    </div>
</main>