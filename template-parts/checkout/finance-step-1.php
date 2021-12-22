<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

$licenceTypes = [
        'Full', 'Non UK', 'Provisional', 'None'
];

$_SESSION['checkout']['reserved'] = false;
$_SESSION['checkout']['complete'] = false;
?>
<main class="checkout__wrapper finance01__section">
    <?php
    get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
    <?php
    get_template_part('template-parts/checkout/progress-bar', 'front-page'); ?>
    <div class="container form__section">
        <form method="post" id="financestep1" action="/checkout/<?php
        echo $type; ?>/step/2">
            <div class="row mb-3 p-3 form__body lightblue__box">
                <div class="col-12 mb-3">
                    <div class="button__heading">
                        Complete our 30-Second Finance Eligibility Check and then reserve the car with &pound;<?php echo TC_DEPOSIT_AMOUNT; ?> Deposit
                    </div>
                </div>
                <div class="col-12 mb-3 text-center form__header">
                    <h1>Driving Licence</h1>
                    <span>What type do you have?</span>
                </div>

                <div class="col-12">
                    <input type="hidden" class="required" name="licence" id="licence" value=""/>
                    <div class="row no-gutters day__selection">
                        <?php
                        foreach ($licenceTypes as $licenceType) :
                            ?>
                            <div class="col-12 col-md mb-3">
                                <button class="btn btn-whiteshadow licence__button" type="button"><?php
                                    echo $licenceType; ?></button>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-12 error licence_error">
                    <p>Please choose licence type.</p>
                </div>
                <div class="col-12 mb-3 d-flex justify-content-end">
                    <button class="btn btn-default" type="submit">Next step</button>
                </div>
            </div>
        </form>
    </div>
</main>
