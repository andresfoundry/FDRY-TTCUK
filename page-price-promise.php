<?php

/**
 * The price promise page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

get_header();
global $title, $hideCta;
$hideCta = true;
//$title = 'Price Promise at ' . get_bloginfo('name');

get_template_part('template-parts/price-promise', 'front-page');
get_template_part('template-parts/price-promise-banner', 'front-page');

?>
    <section class="container-fluid | tertiarypage pricepromise">
        <h1 class="text-center">OUR PRICE PROMISE. YOU CAN'T BEAT IT!</h1>

        <div class="container">
            <div class="row">
                <div class="col">
                    <p>At <?php echo get_bloginfo('name'); ?>, we pride ourselves in offering a great choice of used cars at the lowest
                        price around.</p>
                    <p>Home to probably some of the UK’s cheapest cars, our showrooms in Neath and Abercynon are
                        well-stocked with a range of cars to suit every taste, style, and budget. Let our dedicated sales
                        professionals help you choose the perfect new car at an unbeatable price.</p>
                    <p>What’s more, we’re so confident in our prices that we’re willing to bet on it; if you can find the
                        same car available in the local area for a lower price then we’ll give you &pound;1,000 plus the
                        difference in price.</p>
                    <p class="promisetext">That’s our <?php echo SITE_NAME; ?> Price Promise.</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-muted | pricepromiseterms">
                    <h2 class="text-center">The terms and conditions of our Price Promise are;</h2>

                    You must have a written quote from a VAT registered motor dealer, trading as a Limited company from
                    permanent premises within a 40 miles radius of <?php echo SITE_NAME; ?>. The quote must be dated within 48 hrs
                    of your purchase and may not pre-date the purchase. The alternative vehicle must be the same month and
                    year of registration and the same specification and colour of vehicle. The alternative vehicle must have
                    the same or lower mileage of 500 miles than the Trade Centre vehicle. The alternative vehicle must be
                    available at the time of Price Promise application check and be unsold. The mileage must be verified and
                    in every way, the alternative vehicle should be similar to our vehicle. All <?php echo SITE_NAME; ?> customers
                    that can fit the above mentioned criteria are reimbursed the cost differences plus &pound;1,000, that’s
                    our Price Promise and that’s how serious we are that we won’t be beaten on price. Customers are limited
                    to one claim within 3 years (Typical car ownership cycle). To submit your Price Promise application please email marketing@thetradecentrewales.co.uk
                </div>
            </div>
        </div>
    </section>
<?php
if (!isset($branch) || $branch->post_name != 'merthyr-tydfil') {
    get_template_part('template-parts/carslisting/carslisting', 'front-page');
}
?>
    </section>
<?php
get_template_part('template-parts/bettercar-video', 'front-page');
get_template_part('template-parts/enterreg-banner', 'front-page');
get_template_part('template-parts/reviews', 'front-page');
get_template_part('template-parts/actionboxes', 'front-page');
get_template_part('template-parts/buyingguide-video', 'front-page');
get_footer();
