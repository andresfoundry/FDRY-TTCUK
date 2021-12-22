<?php

/**
 * The single branch template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $branchCustom, $branch, $custom;
$branch = $post;
$branchCustom = $custom;

$title = 'Car Supermarket ' . $branch->post_title . ' - ' . get_bloginfo('name');
$metaDescription = "Our "  . $branch->post_title . " showroom is one of Wales' Largest Used Car " .
"Supermarkets. Our showroom and floodlit forecourt is brimming with cars, from superminis to " .
"SUVs or sporty convertibles and is open until 9pm weekdays and 6pm at weekends.";

include 'front-page.php';