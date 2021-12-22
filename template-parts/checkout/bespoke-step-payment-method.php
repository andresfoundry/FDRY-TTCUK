<?php

/**
 * The reserve controller.
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $post, $wp;

if ($carId = $_SESSION['car_id']) {
    $post = get_post($carId);
    if (!$post) {
        wp_redirect('/');
    }
    $rrp = get_field('rrp', $carId) ?: 'POA';
    $upfront = (int)get_query_var('depositamount');
    if ($upfront < 99) {
        $upfront = 99;
    }
    /*if ($deposit !== '999') {
        $deposit = '99';
        $weeklyPrice = TcFinance::getWeeklyPrice($rrp) ?: 'POA';
        if (!empty($weeklyPrice['pence'])) {
            $weeklyPriceDisplay = $weeklyPrice['pounds'] . '<span class="pence">.' . $weeklyPrice['pence'] . '</span>';
        } else {
            $weeklyPriceDisplay = $weeklyPrice['pounds'];
        }

    } else {
        $weeklyPrice = TcFinance::getTradeInWeeklyPrice($rrp) ?: 'POA';
        if (!empty($weeklyPrice['pence'])) {
            $weeklyPriceDisplay = $weeklyPrice['pounds'] . '<span class="pence">.' . $weeklyPrice['pence'] . '</span>';
        } else {
            $weeklyPriceDisplay = $weeklyPrice['pounds'];
        }
    }*/

    /*$canonicalUrl = 'reserve/' . $deposit . '/' . $carId;
    var_dump($canonicalUrl);die;
    if ($wp->request !== $canonicalUrl) {
        wp_redirect('/' . $canonicalUrl);
        die;
    }

    $balance = $rrp - $deposit;*/

    $make_name = get_field('make_name', $carId);
    $model_name = get_field('model_name', $carId);
    $make_name_slug = get_field('make_name_slug', $carId);
    $model_name_slug = get_field('model_name_slug', $carId);
    $location = get_post(get_field('location', $carId));

    $carImage = get_stylesheet_directory_uri() . '/images/BMW.jpg';
    $carImage = 'https://cdn.spincar.com/swipetospin-viewers/tradecentreneath/wr18oww/20210605140114.OATPUZKO/thumb-lg.jpg';
    $carImage = 'https://cdn.tradecentregroup.io/image/upload/q_auto/f_auto/w_600/web/Group/cars/' . $make_name_slug . '/' . $model_name_slug . '.png';

    $_SESSION['upfront'] = $upfront;
} else {
    wp_redirect('/');
}

$_SESSION['checkout']['reserved'] = false;
$_SESSION['checkout']['complete'] = false;

$title = $post->post_title . ' - ' . get_bloginfo('name');

get_header();
?>
    <main class="checkout__wrapper paymentmethod__section">
        <?php
        get_template_part('template-parts/checkout/top-ribbon', 'front-page'); ?>
        <div class="container">
            <div class="row mb-1">
                <div class="col-12 text-center">
                    <h1>No deposit is required to reserve your car</h1>
                    <span>We are happy to temporarily reserve this car for you for 3 hours (or until 10am next day if
                        reserved after 6pm) with no deposit required from you. During that time, your car concierge
                        will call you and discuss a bespoke deal and give you the option to fully reserve the car with
                        a &pound;<?php echo TC_DEPOSIT_AMOUNT; ?> deposit. Please indicate below whether you intend to
                        pay cash or take advantage of our car finance if you proceed with purchasing the car.</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="row mr-1 p-4 whiteblueborder__box">
                        <a href="/checkout/bespoke/cash/step/1" class="choice__button">
                            <div class="col-12 mb-2 p-4 text-center navyblue__box">
                                <i class="far fa-2x fa-money-check-edit"></i><br/>
                                <h2>Cash Purchase</h2>
                            </div>
                        </a>
                        <div class="col-12 text-center">
                            <img class="payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/maestro.svg' ?>"/>
                            <img class="payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/mastercard-1.svg' ?>"/>
                            <img class="payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/visa-1.svg' ?>"/>
                            <img class="payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/amex-1.svg' ?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row h-100 ml-1 p-4 whiteblueborder__box">
                        <a href="/checkout/bespoke/finance/step/1" class="choice__button">
                            <div class="col-12 mb-2 p-4 text-center navyblue__box">
                                <i class="far fa-2x fa-car"></i><br/>
                                <h2>Finance in 30 Seconds</h2>
                            </div>
                        </a>
                        <div class="col-12 text-center">
                            <img class="invisible payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/maestro.svg' ?>"/>
                            <img class="invisible payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/mastercard-1.svg' ?>"/>
                            <img class="invisible payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/visa-1.svg' ?>"/>
                            <img class="invisible payment__icon" src="<?php
                            echo get_stylesheet_directory_uri() . '/images/amex-1.svg' ?>"/>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <!--<small>* Deposit is fully refundable subject to terms and conditions</small><br/>
                    <small>** Based on approval at <?php
                    echo get_option('cns_representative_apr'); ?>% Representative APR</small>-->
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();
