<?php

/**
 * The checkout controller
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $wp_query, $make_name, $model_name, $carImage, $type, $payment_type, $step_id, $carId;

get_header();

$type = get_query_var('type');
$step_id = get_query_var('step_id');

if ($carId = $_SESSION['car_id']) {
    $post = get_post($carId);
} else {
    wp_redirect('/');
}

if ($post->post_name === 'checkout') {
    wp_redirect('/');
    die;
}

if (!isset($_SESSION['checkout'])) {
    $_SESSION['checkout'] = [];
}

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

$template = false;
if ($type == 'bespoke') {
    $payment_type = get_query_var('payment_type');
    $template = get_template_part('template-parts/checkout/' . $type . '-step-' . $step_id, 'front-page');
} elseif (in_array($type,['cash', 'finance'])) {
    $template = get_template_part('template-parts/checkout/' . $type . '-step-' . $step_id, 'front-page');
}

if ($template === false) {
    $wp_query->set_404();
    status_header(404);
    wp_redirect('/', 302);
    die;
}

get_footer();
