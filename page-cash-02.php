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
    <main class="checkout__wrapper cash02__section">
        <?php get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
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
                        <a href="/cash-01"><img class="pointer__icon" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Personal Details</a>
                    </div>
                    <div class="col-4 d-flex align-items-start justify-content-center">
                        <img class="pointer__icon pointer__icon--selected" src="<?php
                        echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                        &nbsp;Your Appointment
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
            <div class="row mb-3 p-3 form__body lightblue__box">
                <div class="col-12 mb-3 text-center form__header">
                    <h1>Your Appointment</h1>
                    <span>Your car is secured for <strong>3 days</strong>, please select a date and time to pick up your vehicle</span>
                </div>
                <div class="col-12 mb-3">
                    <div class="button__heading">
                        Date
                    </div>
                </div>
                <div class="col-12">
                    <div class="row no-gutters day__selection">
                        <div class="col-12 col-md mb-3">
                            <button class="btn btn-whiteshadow title__button">Today</button>
                        </div>
                        <div class="col-12 col-md mb-3">
                            <button class="btn btn-whiteshadow title__button">Tomorrow</button>
                        </div>
                        <div class="col-12 col-md mb-3">
                            <button class="btn btn-whiteshadow title__button">May 23rd</button>
                        </div>
                        <div class="col-12 col-md mb-3">
                            <button class="btn btn-whiteshadow title__button">May 24th</button>
                        </div>
                        <div class="col-12 col-md mb-3">
                            <button class="btn btn-whiteshadow title__button">May 25th</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="button__heading">
                        Times
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="row no-gutters time__selection">
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">9am</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">10am</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">11am</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">12pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">1pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">2pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">3pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">4pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">5pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">6pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">7pm</button>
                        </div>
                        <div class="col-4 col-md mb-3">
                            <button class="btn btn-whiteshadow time__button">8pm</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3 text-center">
                    <a class="btn btn-default confirm__button" href="/cash-confirmation"><i class="far fa-credit-card"></i> Confirm and pay £99 deposit</a>
                    <!--<button class="btn btn-default confirm__button"><i class="far fa-credit-card"></i> Confirm and pay £99 deposit</button>-->
                </div>
    </main>
<?php
get_footer();
