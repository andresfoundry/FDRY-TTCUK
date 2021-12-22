<?php

/**
 * The page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $post;
$title = $post->post_title . ' - ' . get_bloginfo('name');

get_header();
?>
    <main class="checkout__wrapper cash01__section">
        <div class="top__ribbon py-3 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-auto px-1">
                        <button class="btn btn-ribbon"><strong>Great news!</strong> Your car is ready to reserve
                        </button>
                    </div>
                    <div class="col-auto px-1">
                        <img src="<?php
                        echo get_stylesheet_directory_uri() . '/images/BMW.jpg' ?>" height="56px"/>
                    </div>
                    <div class="col-auto px-1 ribbon__cardetails">
                        <h2>2016 BMW 1 Series</h2>
                        <span>116d EfficientDynamics Plus 5dr</span>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end text-right">
                        <i class="fal fa-2x fa-window-close"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="progress__bar">
            <div class="container">
                <div class="row">
                    <div class="col-4 d-flex align-items-start">
                        <img class="pointer__icon pointer__icon--selected" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Personal Details
                    </div>
                    <div class="col-4 d-flex align-items-start justify-content-center">
                        <a href="/cash-02"><img class="pointer__icon" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Your Appointment</a>
                    </div>
                    <div class="col-4 d-flex align-items-start justify-content-end">
                        <a href="/cash-confirmation"><img class="pointer__icon" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Confirmation</a>
                    </div>
                    <div class="col-12">
                        <hr/>
                    </div>
                </div>
            </div>
        </div>
        <div class="container form__section">
            <div class="row form__header">
                <div class="col-12 text-center">
                    <h1>That's great!</h1>
                    We just need a few details now to secure your car
                </div>
            </div>
            <div class="row mb-3 form__body lightblue__box">
                <div class="col-12">
                    <div class="row no-gutters pr-md-5 pt-5">
                        <div class="col-12 col-md-4 mb-3 mb-md-0 d-flex align-items-end"><img class="pointer__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/receptionist.png' ?>"/>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button">Mr</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button">Mrs</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button">Ms</button>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <button class="btn btn-whiteshadow title__button">Miss</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="firstname">First Name</label><input type="text" id="firstname" name="firstname" />
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="lastname">Last Name</label><input type="text" id="lastname" name="lastname" />
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="mobile">Mobile</label><input type="text" id="mobile" name="mobile" />
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="email">Email</label><input type="text" id="email" name="email" />
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="houseno">House No</label><input type="text" id="houseno" name="houseno" />
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="postcode">Postcode</label><input type="text" id="postcode" name="postcode" />
                                </div>
                                <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
                                    <button class="btn btn-lightblue lookup__button">Lookup</button>
                                </div>
                                <div class="col-12 col-md-4 mb-3 d-none d-md-block">
                                </div>
                                <div class="col-12 col-md-4 mb-3 d-none d-md-block">
                                </div>
                                <div class="col-12 mb-md-5 col-md-4 mb-3 text-right">
                                    <a class="btn btn-default book__button" href="/cash-02">Book Your Appointment</a>
                                    <!--<button class="btn btn-default book__button">Book Your Appointment</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
<?php
get_footer();
