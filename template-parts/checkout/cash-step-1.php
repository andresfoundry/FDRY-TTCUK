<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

$_SESSION['checkout']['reserved'] = false;
$_SESSION['checkout']['complete'] = false;
?>
<main class="checkout__wrapper cash01__section" id="addressLookup">
        <?php get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
        <?php get_template_part('template-parts/checkout/progress-bar', 'front-page'); ?>
        <!--<div class="progress__bar">
            <div class="container">
                <div class="row">
                    <div class="col-4 d-flex align-items-start">
                        <img class="pointer__icon pointer__icon--selected" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Personal Details
                    </div>
                    <div class="col-4 d-flex align-items-start justify-content-center">
                        <img class="pointer__icon" src="<?php
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
        </div>-->
        <div class="container form__section">
            <div class="row form__header mb-3">
                <div class="col-12 text-center">
                    <h1>That's great!</h1>
                    <span>We just need a few details now to secure your car</span>
                </div>
            </div>
            <div class="row mb-3 form__body lightblue__box">
                <div class="col-12">
                    <form method="post" id="formstep1" action="/checkout/<?php echo $type; ?>/step/2">
                    <div class="row no-gutters pr-md-5 pt-5">
                        <div class="col-12 col-md-4 mb-3 mb-md-0 d-none d-md-flex align-items-end"><img class="pointer__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/receptionist.png' ?>"/>
                        </div>
                        <div class="col-12 col-md-8">
                            <input type="hidden" class="required" name="title" id="title" value="" />
                            <div class="row">
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button" type="button">Mr</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button" type="button">Mrs</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button" type="button">Ms</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button" type="button">Miss</button>
                                </div>
                                <div class="col-12 error title_error">
                                    <p>Please provide your title</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="firstname">First Name</label><input class="required" type="text" id="firstname" name="firstname" />
                                    <div class="col-12 error firstname_error">
                                        <p>Please provide your first name</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="lastname">Last Name</label><input class="required" type="text" id="lastname" name="lastname" />
                                    <div class="col-12 error lastname_error">
                                        <p>Please provide your last name</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="mobile">Mobile</label><input class="required" type="text" id="mobile" name="mobile" />
                                    <div class="col-12 error mobile_error">
                                        <p>Please provide your first name</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3 d-none d-md-block">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="email">Email</label><input class="required" type="text" id="email" name="email" />
                                    <div class="col-12 error email_error">
                                        <p>Please provide your email address</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="email">Confirm Email</label><input class="required" type="text" id="confirm_email" name="confirm_email" />
                                    <div class="col-12 error email_error">
                                        <p>Please confirm your email address</p>
                                    </div>
                                </div>
                                <!--<div class="col-12 col-md-4 mb-3">
                                    <label for="houseno">House No</label><input type="text" id="houseno" name="houseno" />
                                    <div class="col-12 error houseno_error">
                                        <p>Please provide your house number</p>
                                    </div>
                                </div>-->
                                <div class="col-12 mb-3 postcodesearchresults">
                                    <!-- This is where the address options select is injected -->
                                </div>
                                <div class="address-inputs col-12" style="display:none;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 mb-3">
                                            <input type="text" class="form-control" name="flat" placeholder="Flat">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 mb-3">
                                            <input type="text" class="form-control" name="house_name" placeholder="House name">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 mb-3">
                                            <input type="text" class="form-control" name="house_number" placeholder="House number">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 mb-3">
                                            <input type="text" class="form-control required" name="street" placeholder="Street">
                                        </div>
                                        <div class="col-xs-12 col-sm-8 mb-3">
                                            <input type="text" class="form-control" name="district" placeholder="District / Town">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control required mb-3" name="towncity" placeholder="City">
                                    <input type="text" class="form-control required mb-3" name="county" placeholder="County">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="postcode">Postcode</label><input class="required" type="text" id="postcode" name="postcode" />
                                    <div class="col-12 error postcode_error">
                                        <p>Please provide your postcode</p>
                                    </div>
                                    <div class="col-12 mb-3 error lookup_error">
                                        Please lookup your address
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
                                    <button class="btn btn-lightblue lookup__button">Lookup</button>
                                </div>
                                <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
                                    <!--<a class="btn btn-default book__button" href="/cash-02">Book Your Appointment</a>-->
                                    <button class="btn btn-default book__button" type="submit">Book Your Collection</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
    </main>
