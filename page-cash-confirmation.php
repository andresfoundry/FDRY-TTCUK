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
    <main class="checkout__wrapper cashconfirmation__section">
        <?php get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
        <!--<div class="top__ribbon py-3 mb-5">
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
        </div> -->
        <div class="progress__bar">
            <div class="container">
                <div class="row">
                    <div class="col-4 d-flex align-items-start">
                        <a href="/cash-01"><img class="pointer__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                            &nbsp;Personal Details</a>
                    </div>
                    <div class="col-4 d-flex align-items-start justify-content-center">
                        <a href="/cash-02"><img class="pointer__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                            &nbsp;Your Appointment</a>
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
                    <span>The payment was successful and your 2016 BMW 1 Series is now reserved</span>
                </div>
                <div class="col-12 mb-3">
                    <div class="row no-gutters appointment__box">
                        <div class="col-12 col-md-3 person__box">
                            <span class="person__wrapper"><img class="" src="<?php
                                echo get_stylesheet_directory_uri() . '/images/receptionist.png' ?>" width="157"
                                                               height="199.5"/></span>
                        </div>
                        <div class="col-12 col-md-9 px-5 d-flex align-items-center">
                            <p>We'll see you at our <strong>Rotherham</strong> showroom on <strong>Friday 21st
                                    (9am) </strong>&nbsp;go to reception and a car concierge will take care of
                                everything for you. Thankyou for buying from the Trade Centre.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <img class="" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/BMW-1024x576-logo-1.jpeg' ?>" width="512"
                                 height="288"/>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <div class="row no-gutters h-100">
                                <div class="col-12 p-3 white__box pickup__details">
                                    <h4>Your pickup location is at Rotherham</h4>
                                    <p>Forge Way<br/>
                                        Parkgate<br/>
                                        <strong>Rotherham</strong><br/>
                                        S60 1SD<br/>
                                        <br/>
                                        Opening Times<br/>
                                        Mon-Fri <strong>9am - 9pm</strong><br/>
                                        Sat <strong>9am - 6pm</strong><br/>
                                        Sun <strong>9am - 6pm</strong></p>
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
                                            (if paying by cash)
                                        </li>
                                        <li>Your car (if trading in)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="row no-gutters h-100">
                                <div class="col-12 px-3 mediumblue__box car__details d-flex align-items-center">
                                    <div>
                                    <h2>2016 BMW 1 Series</h2>
                                    <span>116d EfficientDynamics Plus 5dr</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <button class="btn btn-default w-100 directions__button">
                                <img src="/images/maps-icon.svg" height="46"/>&nbsp;Directions
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3 text-center">
                    <button class="btn btn-default confirm__button">Print</button>
                </div>
    </main>
<?php
get_footer();
