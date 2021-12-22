<?php

/**
 * The front page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

$page = 1;
$more = 1;
$preview = '';
$pages[] = $post->post_content;

global $wp, $showAreaLinks, $listingType, $title, $metaDescription, $saleMode, $branch, $driveAwayBanner;

if ($wp->request == '') {
    $showAreaLinks = true;
}

get_header();
get_template_part('template-parts/carsearch', 'front-page');

/*$listingType = 'maincarlisting';
get_template_part('template-parts/carslisting/carslisting', 'front-page');

if ($driveAwayBanner == true) {
    get_template_part('template-parts/driveawaybanner', 'front-page');
}
get_template_part('template-parts/imageslider', 'front-page');

if ($wp->request !== '' && !isset($branch)) {
    if ($saleMode === LISTING_FROM_MODE) {
        get_template_part('template-parts/carslisting/similar-from-mode', 'front-page');
    } else {
        if ($saleMode === LISTING_SALE_MODE) {
            get_template_part('template-parts/carslisting/similar-sale-mode', 'front-page');
        } else {
            get_template_part('template-parts/carslisting/similar-normal', 'front-page');
        }
    }
}*/

if (isset($branch)) {
    echo '<section class="d-none d-md-block d-lg-block py-2 | desktop-branch-info greybackground">';
    include 'template-parts/branch-info.php';
    echo '</section>';
}

get_template_part('template-parts/bettercar-video', 'front-page');
//get_template_part('template-parts/finance-form', 'front-page');
get_template_part('template-parts/price-promise', 'front-page');
get_template_part('template-parts/price-promise-banner', 'front-page');
get_template_part('template-parts/branch-locations', 'front-page');
//get_template_part('template-parts/enterreg-banner', 'front-page');
//get_template_part('template-parts/reviews', 'front-page');
get_template_part('template-parts/actionboxes', 'front-page');
//get_template_part('template-parts/buyingguide-video', 'front-page');

get_footer();