<?php

/**
 * The header template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $wp, $title, $metaDescription, $metaImage, $mobile_ribbon_text;

if (empty($title)) {
    if (isset($_SESSION['area'])) {
        $title = sprintf(
            'Cheap Used Cars near %s',
            str_replace(
                '-',
                ' ',
                $_SESSION['area']
            )
        );
    } else {
        $title = sprintf(
            'The UKs Cheapest Cars'
        );
    }
}

if (empty($metaDescription) && ($wp->request == '' || substr($wp->request, 0, 3) === 'in/')) {
    if (isset($_SESSION['area'])) {
        $metaDescription = "Our " . $_SESSION['areaBranch'] . " showroom near " . $_SESSION['area'] . " is one of Wales' " .
            "Largest Used Car Supermarkets. Our showrooms and floodlit forecourts are brimming with thousands of cars" .
            ", from superminis to SUV's or sporty convertibles and are open until 9pm weekdays and 6pm at weekends.";
    } else {
        $metaDescription = "Wales' Largest Used Car Supermarket with sites in Abercynon & Neath. Our " .
            "showrooms and floodlit forecourts are brimming with thousands of cars, from superminis to SUV's or " .
            "sporty convertibles and are open until 9pm weekdays and 6pm at weekends.";
    }
}

$metaDescription = wp_strip_all_tags($metaDescription);

$genTitle = wp_strip_all_tags($title ? $title : '');
if (!str_contains($title, get_bloginfo('name'))) {
    $genTitle .= ' | ' . get_bloginfo('name');
}

$today = date('l');
$closing_time_weekends = get_option('cns_closing_hour_weekends') ? get_option('cns_closing_hour_weekends') : '18';
$closing_time_weekdays = get_option('cns_closing_hour_weekdays') ? get_option('cns_closing_hour_weekdays') : '21';
$closing_time = ($today == 'Saturday' || $today == 'Sunday') ? $closing_time_weekends : $closing_time_weekdays;

$currentdate = new DateTime("now", new DateTimeZone('Europe/London'));
$current_hour = $currentdate->format('H');
//echo $current_hour;
//$current_hour = date('H');

if($current_hour >= $closing_time || $current_hour < 9) {
    $ribbon_text = 'OPEN<br />AGAIN<br />AT 9AM';
    $mobile_ribbon_text = 'OPEN AGAIN AT <strong>9AM</strong>';
}
else {
    if ($closing_time > 12) {
        $closing_time -=12;
    }
    $ribbon_text = 'OPEN<br /> UNTIL '.$closing_time.'PM<br />TONIGHT';
    $mobile_ribbon_text = 'OPEN UNTIL <strong>'.$closing_time.'PM</strong> TONIGHT';
}
if (get_option('cns_opening_desktop_override')) {
    $ribbon_text = html_entity_decode(get_option('cns_opening_desktop_override'));
}
if (get_option('cns_opening_mobile_override')) {
    $mobile_ribbon_text = html_entity_decode(get_option('cns_opening_mobile_override'));
}

?><!doctype html>
<html lang="en">
<head>
    <title><?php echo $genTitle; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <?php
    wp_head(); ?>
    <!--<link href="/css/site.css?id=41988eb581989b4f2814" rel="stylesheet" type="text/css">
    <script src="/js/site.js?id=56ccd145df4498595aea" defer></script>
    <script src="/financeexamples" type="text/javascript" defer></script>-->
  <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="apple-touch-icon" href="/icon.png">
    <meta property="og:title" content="<?php echo $genTitle; ?>"/>
    <meta name="twitter:title" content="<?php echo $genTitle; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>

    <?php if (!empty($metaDescription)) : ?>
    <meta name="description"
          content="<?php
          echo $metaDescription; ?>"/>
    <?php endif; ?>
    <meta property="og:description"
          content="<?php
          echo $metaDescription; ?>"/>
    <meta name="twitter:description"
          content="<?php
          echo $metaDescription; ?>"/>
    <?php
    if ($metaImage) :
        ?>
        <meta property="og:image" content="<?php
        echo $metaImage; ?>"/>
        <meta property="twitter:image" content="<?php
        echo $metaImage; ?>"/>
    <?php
    else : ?>
        <meta property="og:image" content="/images/standard-sharing-image-tcw.jpg"/>
        <meta property="twitter:image" content="/images/standard-sharing-image-tcw.jpg"/>
    <?php
    endif;
    ?>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <script type="text/javascript">
        <?php echo getJsFinanceExamples(); ?>
    </script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-21171026-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-21171026-1');
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P46QVGQ');</script>
<!-- End Google Tag Manager -->
<meta name="facebook-domain-verification" content="tcol8jwubyqbc78czzbkyhzr3ymnar" />
</head>
<body <?php
body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P46QVGQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="hidden-print corner-ribbon top-right sticky blue d-none d-md-block"><?php echo $ribbon_text; ?></div>
<?php
global $tertiaryPage;

get_template_part('template-parts/header/top-nav', 'header'); ?>
<main class="">
    <?php
    get_template_part('template-parts/header/finance-modal', 'header');
    get_template_part('template-parts/header/maps-modal', 'header');
    //get_template_part('template-parts/header/hubspot-modal', 'header');
    get_template_part('template-parts/header/header-banner', 'header');
    get_template_part('template-parts/header/content-tabs', 'header');
    get_template_part('template-parts/header/locations-overlay', 'header');