<?php

/**
 * The part exchange page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $title;
$title = 'Part Exchange Valuation from ' . get_bloginfo('name');

get_header();
?>
    <section class="container-fluid | tertiarypage finance">
        <div class="container">
            <h1 class="text-center">Part Exchange Valuation</h1>
            <h3 class="text-center">Enter your car registration to get your valuation.</h3>
            <div class="row pb-0">
                <div class="col-12 col-md-4 mb-1">
                    <div class="col text-center">
                        <img src="/images/apply-step4.png">
                        <h4>Step 1</h4>
                        <span>Enter Your Reg</span>
                        <p>Simply enter your car registration below and then click GO.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-1">
                    <div class="col text-center">
                        <img src="/images/apply-step3.png">
                        <h4>Step 2</h4>
                        <span>Instant Valuation</span>
                        <p>Confirm the details and we'll text or email your valuation.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-1">
                    <div class="col text-center">
                        <img src="/images/apply-step2.png">
                        <h4>Step 3</h4>
                        <span>Choose your car</span>
                        <p>Visit one of our dealerships, trade your old car in and and drive away your new car!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_template_part('template-parts/enterreg-banner', 'front-page');
get_footer();
