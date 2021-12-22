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

if ($carId = get_query_var('car_id')) {
    $post = get_post($carId);
    $derivativeUrl = get_query_var('derivative');
    $derivative = sanitize_title(get_field('derivative', $carId));

    $make_name = get_field('make_name', $carId);
    $model_name = get_field('model_name', $carId);
    $make_name_slug = get_field('make_name_slug', $carId);
    $model_name_slug = get_field('model_name_slug', $carId);
    $location = get_post(get_field('location', $carId));

    $rrp = get_field('rrp', $carId) ?: 'POA';
    $weeklyPrice = TcFinance::getWeeklyPrice($rrp) ?: 'POA';
    if (!empty($weeklyPrice['pence'])) {
        $weeklyPriceDisplay = $weeklyPrice['pounds'] . '<span class="pence">.' . $weeklyPrice['pence'] . '</span>';
    } else {
        $weeklyPriceDisplay = $weeklyPrice['pounds'];
    }
    $tradeInWeeklyPrice = TcFinance::getTradeInWeeklyPrice($rrp) ?: 'POA';
    if (!empty($tradeInWeeklyPrice['pence'])) {
        $tradeInWeeklyPriceDisplay = $tradeInWeeklyPrice['pounds'] . '<span class="pence">.' . $tradeInWeeklyPrice['pence'] . '</span>';
    } else {
        $tradeInWeeklyPriceDisplay = $tradeInWeeklyPrice['pounds'];
    }
    $carImage = get_stylesheet_directory_uri() . '/images/BMW.jpg';
    $carImage = 'https://cdn.spincar.com/swipetospin-viewers/tradecentreneath/wr18oww/20210605140114.OATPUZKO/thumb-lg.jpg';
    $carImage = 'https://cdn.tradecentregroup.io/image/upload/q_auto/f_auto/w_600/web/Group/cars/' . $make_name_slug . '/' . $model_name_slug . '.png';

    $engineCapacity = cns_format_engine_capacity(get_field('enginecapacity', $carId));

    if ($derivative !== $derivativeUrl) {
        wp_redirect('/cars/' . $make_name_slug . '/' . $model_name_slug . '/' . $derivative . '/' . $carId);
        die;
    }
}

$techData = cns_car_technical_data($carId);
$standardEquipment = cns_car_standard_equiptment($carId);

$title = $post->post_title . ' - ' . get_bloginfo('name');

$backLink = '/cars';
if (!empty($_SESSION['make_name_slug']) && $_SESSION['make_name_slug'] != 'any') {
    $backLink .= '/' . $_SESSION['make_name_slug'];
}
if (!empty($_SESSION['model_name_slug']) && $_SESSION['model_name_slug'] != 'any') {
    $backLink .= '/' . $_SESSION['model_name_slug'];
}
if (!empty($_SESSION['area_slug'])) {
    $backLink .= '/in/' . $_SESSION['area_slug'];
}
if ($backLink === '/cars') {
    $backLink = '/';
}

get_header();
?>
    <!-- Modal -->
    <div class="modal right fade car-info-modal" id="carSpecModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Car Specs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="fal fa-times"></i></span></button>
                </div>

                <div class="modal-body">
                    <?php
                    $i = mt_rand(0, 999999);
                    foreach ($techData as $categoryName => $data) :
                        ?>
                        <div class="wp-block-pb-accordion-item c-accordion__item js-accordion-item is-read"
                             data-initially-open="false" data-click-to-close="true" data-auto-close="true"
                             data-scroll="false" data-scroll-offset="0"><h2 id="at-<?php
                            echo $i; ?>"
                                                                            class="c-accordion__title js-accordion-controller"
                                                                            role="button" tabindex="0"
                                                                            aria-controls="ac-<?php
                                                                            echo $i; ?>" aria-expanded="false">
                                <?php
                                echo $categoryName; ?></h2>
                            <div id="ac-<?php
                            echo $i++; ?>" class="c-accordion__content" style="display: none;" hidden="hidden">
                                <ul>
                                <?php
                                foreach ($data as $featureTitle => $featureValue) :
                                    ?>
                                    <li>
                                        <?php
                                        echo $featureTitle; ?>
                                        <span>
                                        <?php
                                        echo $featureValue; ?>
                                        </span>
                                    </li>
                                <?php
                                endforeach;
                                ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    <div class="modal right fade car-info-modal" id="carFeaturesModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Car Features</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="fal fa-times"></i></span></button>
                </div>

                <div class="modal-body">
                    <?php
                    $i = mt_rand(0, 999999);
                    foreach ($standardEquipment as $name => $data) :
                        ?>
                        <div class="wp-block-pb-accordion-item c-accordion__item js-accordion-item is-read"
                             data-initially-open="false" data-click-to-close="true" data-auto-close="true"
                             data-scroll="false" data-scroll-offset="0"><h2 id="at-<?php
                            echo $i; ?>"
                                                                            class="c-accordion__title js-accordion-controller"
                                                                            role="button" tabindex="0"
                                                                            aria-controls="ac-<?php
                                                                            echo $i; ?>" aria-expanded="false">
                                <?php
                                echo $name; ?></h2>
                            <div id="ac-<?php
                            echo $i++; ?>" class="c-accordion__content" style="display: none;" hidden="hidden">
                                <ul>
                                <?php
                                foreach ($data as $featureValue) :
                                    ?>
                                    <li>
                                        <?php
                                        echo $featureValue; ?>
                                    </li>
                                <?php
                                endforeach;
                                ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    <main class="cardetail__wrapper">
        <div class="container mt-4">
            <div class="row">
                <div class="col-6 text-left"><a href="<?php
                    echo $backLink; ?>">< Results</a></div>
                <div class="col-6 text-right"><a href="#">Share</a></div>
            </div>
        </div>
        <div class="container-fluid p-0 mb-5">
            <div class="row no-gutters">
                <div class="col-12 car__images">
                    <div class="row no-gutters">
                        <div class="col-12 col-md-4 col-lg-3">
                            <img src="<?php
                            echo $carImage; ?>"/>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 d-none d-md-block">
                            <img src="<?php
                            echo $carImage; ?>"/>
                        </div>
                        <div class="col-3 col-md-4 col-lg-3 d-none d-md-block">
                            <img src="<?php
                            echo $carImage; ?>"/>
                        </div>
                        <div class="col-3 col-lg-3 d-none d-lg-block">
                            <img src="<?php
                            echo $carImage; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row no-gutters d-flex justify-content-center top__buttons">
                        <div class="col-12 text-center">
                            <button><i class="fal fa-plus-circle"></i>Zoom</button>
                            <button><i class="fal fa-arrows-alt"></i>Internal 360°</button>
                            <button><i class="fal fa-arrows-alt"></i>External 360°</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-5">
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="row no-gutters">
                        <div class="col-12 col-md-3 p-3 vehicle__details">
                            <h4><?php
                                echo $make_name . ' ' . $post->post_title; ?></h4>
                            <span><?php
                                echo get_field('derivative', $carId); ?></span><br/>
                            <p><strong>**This car is at our <?php
                                    echo $location->post_title; ?> branch**</strong><br/>
                                Unfortunately vehicles cannot be moved between branches at this time, please ensure you
                                are
                                happy to travel to our <?php
                                echo $location->post_title; ?> branch.</p>
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="row no-gutters p-4 payment__section lightblue__box">
                                <div class="col-12 col-md-3 mb-2 mr-md-1 py-5 payment__price">
                                    <p>Cash Price<br/><strong>&pound;<?php
                                            echo number_format($rrp); ?></strong></p>
                                </div>
                                <div class="col-12 col-md-4 mx-1 mb-2 payment__deposit">
                                    <div class="row no-gutters m-2">
                                        <div class="col-6 p-1 text-center flex-both-center blue__box">
                                            <p><strong>&pound;99</strong><br/>
                                                Cash Deposit
                                            </p>
                                        </div>
                                        <div class="col-6 p-1 text-center white__box">
                                            <p><strong>&pound;<?php
                                                    echo $weeklyPriceDisplay; ?></strong><br/>
                                                <span class="perweek">PER WEEK</span><br/>
                                                or <span>&pound;<?php echo number_format($rrp - 99,'0'); ?></span> Balance to Pay on Collection
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row no-gutters m-1">
                                        <div class="col-12 mb-1"><a class="btn btn-default w-100"
                                                                    href="/reserve/99/<?php echo $carId; ?>">Reserve</a></div>
                                        <div class="col-12">
                                            <a class="btn btn-finance-example" href="#"><i
                                                        class="far fa-external-link"></i>
                                                FINANCE EXAMPLE</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 ml-1 mb-2 payment__partex">
                                    <div class="row no-gutters m-2">
                                        <div class="col-6 p-1 text-center flex-both-center blue__box">
                                            <p><strong>&pound;1000</strong><br/>
                                                Minimum Part-Exchange
                                            </p>
                                        </div>
                                        <div class="col-6 p-1 text-center white__box">
                                            <p><strong>&pound;<?php echo $tradeInWeeklyPriceDisplay; ?></strong><br/>
                                                <span class="perweek">PER WEEK</span><br/>
                                                or <span>&pound;<?php echo number_format($rrp - 999,'0'); ?></span> Balance to Pay on Collection
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row no-gutters m-1">
                                        <div class="col-12 mb-1"><a class="btn btn-default w-100"
                                                                    href="/reserve/999/<?php echo $carId; ?>">Reserve</a></div>
                                        <div class="col-12">
                                            <a class="btn btn-finance-example" href="#"><i
                                                        class="far fa-external-link"></i>
                                                FINANCE EXAMPLE</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="weekly__payment">
                                        Weekly payments are based on 260 Weeks (60 months)<!-- - <a href="#">Change term
                                            here</a>-->
                                    </p>
                                </div>
                                <div class="col-12 mb-3 text-center payment__bespoke">
                                    <div class="row flex-both-center p-3">
                                        <div class="col-12 col-md-8">
                                            <p>Have a Larger Cash Deposit and/or your Part-Exchange worth more than
                                                &pound;1000?</p>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <a class="btn btn-default w-100" href="/checkout/bespoke/<?php echo $carId; ?>">Bespoke check-out</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-1 benefits__list">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <p class="d-flex align-items-center"><i class="fal fa-mouse"></i>&nbsp;Click
                                                and Collect this car as soon as today</p>
                                            <p class="d-flex align-items-center"><i class="fal fa-car"></i>&nbsp;Free 12
                                                Month RAC Warranty & Breakdown Cover</p>
                                            <p class="d-flex align-items-center"><i class="fal fa-file-certificate"></i>&nbsp;Extended
                                                Warranty and Breakdown cover available on this car</p>
                                            <p class="d-flex align-items-center"><i class="fal fa-clock"></i>&nbsp;Easy
                                                30-Second Finance Check</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="row cardata__table">
                <div class="col-12">
                    <h2>All about your car</h2>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row no-gutters">
                        <div class="col-12 red__border">
                            Mechanical
                        </div>
                        <div class="col-6 grey__border">
                            Transmission
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('transmission', $carId); ?></span>
                        </div>
                        <!--<div class="col-6 grey__border">
                            Milage
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span>33,000</span>
                        </div>-->
                        <div class="col-6 grey__border">
                            Engine
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo $engineCapacity; ?></span>
                        </div>
                        <div class="col-6 grey__border">
                            Fuel
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('fueltype', $carId); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row no-gutters">
                        <div class="col-12 red__border">
                            Trim
                        </div>
                        <div class="col-6 grey__border">
                            Body
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('bodytype', $carId); ?></span>
                        </div>
                        <!--<div class="col-6 grey__border">
                            Colour
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span>Brown</span>
                        </div>-->
                        <div class="col-6 grey__border">
                            Doors
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('doors', $carId); ?></span>
                        </div>
                        <div class="col-6 grey__border">
                            Seats
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('seats', $carId); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row no-gutters">
                        <div class="col-12 red__border">
                            Useful Information
                        </div>
                        <!--<div class="col-6 grey__border">
                            Previous Owners
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span>3</span>
                        </div>
                        <div class="col-6 grey__border">
                            Insurance Group
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span>Normal</span>
                        </div>-->
                        <div class="col-6 grey__border">
                            Vehicle Registration
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span><?php
                                echo get_field('reg_number', $carId); ?></span>
                        </div>
                        <!--<div class="col-6 grey__border">
                            ULEZ Compliment
                        </div>
                        <div class="col-6 text-right grey__border">
                            <span>Yes</span>
                        </div>-->
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12 text-center">
                    <button class="btn btn-green" data-toggle="modal" data-target="#carFeaturesModal">Car Features
                    </button>
                    <button class="btn btn-green" data-toggle="modal" data-target="#carSpecModal">Car Specs</button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row my-5">
                <div class="col-12 text-center">
                    <img src="<?php
                    echo get_stylesheet_directory_uri() ?>/images/1000-Offer-1400x200-1.jpg" alt="Image"
                         loading="lazy"/>
                </div>
            </div>
        </div>
        <div class="tc__promise__wrapper py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5 promise__header">
                        <div class="mr-2">
                            <img src="/images/tcw-logo.svg?09e287fb86c606917c1e32eac94a500c" width="110px"/>
                        </div>
                        <div>
                            <h4>The Trade Centre Promise</h4>
                            <p>You can be reassured when buying from the Trade Centre</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <h4>Free 12 Month RAC & Breakdown Cover</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                        <h4>Rated 4.7/5 on TrustPliot</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                        <h4>Same day drive away</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h4>250-point car inspection</h4>
                        <p>We put every car we sell online through a 250 point inspection so you can be confident you're
                            buying a quality car that's safe to drive as that.</p>
                        <ul>
                            <li>Engine</li>
                            <li>Interior</li>
                            <li>Brakes</li>
                            <li>Safety</li>
                            <li>Electrical</li>
                            <li>History</li>
                            <li>Exterior</li>
                            <li>Road test</li>
                        </ul>
                        <h4>Over 1,000 customers approved for car finance every week</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h4>Our Price Promise</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                        <h4>Open until 9pm</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices feugiat
                            ullamcorper. Duis tristique condimentum molestie. Sed tincidunt arcu vel tortor congue, non
                            venenatis dolor dignissim.</p>
                    </div>
                </div>
            </div>
    </main>
<?php
get_footer();
