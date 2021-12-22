<?php

/**
 * The contact page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $title, $custom;
$title = 'Contact Us at ' . get_bloginfo('name');

get_header();
?>
    <section class="container-fluid | tertiarypage contactus">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-8">
                    <h1 class="text-left">Contact Us</h1>
                    <!--
                    <div class="pandemic-message mb-3">Whilst our showrooms are closed due to circuit-breaker lockdown,
                        we are fully supporting all of our customers during this period. Please provide us some details
                        on the form below and one of the team will be in touch shortly.</div>
                    -->
                    <p>Thank you for visiting <?php echo get_bloginfo('name'); ?>, a part of The Trade Centre Group. We hope you have
                        had a great experience on our website. If you would like to get in touch with a member of the
                        team,
                        you will find our contact details below or alternatively you can pop in to your local showroom (no
                        appointment required) and speak to a member or our team.</p>

                    <p><strong>Prefer to call?</strong><br />
                        If you would prefer to speak to us on the phone, please see below<br />
                        Reception / Main Line: <a href="tel:01792814300">(01792) 814 300</a><br />
                        Customer Care: <a href="tel:03333053400">0333 305 3400</a>
                    </p>

<!--
                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>

                    <script>
                        hbspt.forms.create({
                            portalId: "6645024",
                            formId: "cbaf73f5-90d2-42e8-892a-7203dc343182"
                        });
                    </script>
-->
                </div>
                
                
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="row px-3 py-4 pb-lg-0 justify-content-center">
                        <div class="col p-4 pb-5 pt-5 | openingtimes">
                            <h4 class="text-left">Opening Times</h4>
                            <p>
                                <?php the_field('opening_hours'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_template_part('template-parts/branch-locations', 'front-page');
get_footer();
