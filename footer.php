<?php

/**
 * The footer template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

?>
</main>
<footer>
    <div class="container | footer-all-devices">
        <div class="row">
            <div class="col-12 text-center mb-5 footer__contactmessage">
                <strong>Need a hand?</strong>
                <p class="pl-3 d-none d-md-inline">We're ready to help 9am-9pm on Monday to Friday, 9am to 6pm on Saturday & 10am to 5pm on Sunday.</p>
            </div>
            <div class="col-3 footer__icon">
                <div class="row no-gutters">
                    <div class="col-12 py-3 d-flex justify-content-center align-items-center footer__rightborder">
                        <a href="https://wa.me/447777123456">
                            <i class="fab fa-3x fa-whatsapp pr-3"></i>
                            <span class="d-none d-md-inline">WhatsApp</span>
                        </a>
                    </div>
                    <div class="col-12 d-none d-lg-block">
                        <p class="text-center"><a href="https://wa.me/447777123456">Lets chat by WhatsApp</a></p>
                    </div>
                </div>
            </div>
            <div class="col-3 footer__icon">
                <div class="row no-gutters">
                    <div class="col-12 py-3 d-flex justify-content-center align-items-center footer__rightborder">
                        <a href="sms:+447777123456">
                            <i class="fal fa-3x fa-mobile-android pr-3"></i>
                            <span class="d-none d-md-inline">Text</span>
                        </a>
                    </div>
                    <div class="col-12 d-none d-lg-block">
                        <p class="text-center"><a href="sms:+447777123456">07777 123456</a></p>
                    </div>
                </div>
            </div>
            <div class="col-3 footer__icon">
                <div class="row no-gutters">
                    <div class="col-12 py-3 d-flex justify-content-center align-items-center footer__rightborder">
                        <a href="tel:+443450343343">
                            <i class="fal fa-3x fa-phone-alt pr-3"></i>
                            <span class="d-none d-md-inline">Phone</span>
                        </a>
                    </div>
                    <div class="col-12 d-none d-lg-block">
                        <p class="text-center"><a href="tel:+443450343343">0345 0343343</a></p>
                    </div>
                </div>
            </div>
            <div class="col-3 footer__icon">
                <div class="row no-gutters">
                    <div class="col-12 py-3 d-flex justify-content-center align-items-center">
                        <a href="mailto:enquiries@tradecentreuk.com">
                            <i class="fal fa-3x fa-envelope pr-3"></i>
                            <span class="d-none d-md-inline">Email</span>
                        </a>
                    </div>
                    <div class="col-12 d-none d-lg-block">
                        <p class="text-center"><a href="mailto:enquiries@tradecentreuk.com">enquiries@tradecentreuk.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 | footer__text">
            <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text__block--left">
                <p>The Trade Centre Wales is a trading name of The Trade Centre Group Plc | Registered in England and Wales
                    (#4921555) our VAT Registration number is #821 833 735.</p>
                <p>Registered Address: The Trade Centre Wales, Euro Centre, Neath Abbey Business Park, Neath, SA10
                    7DR</p>
                <p>We can introduce you to a select group of lenders who may be able to help you finance your vehicle
                    of choice. We do not charge fees for our consumer credit services but we will typically receive a
                    commission payment from the lender should you decide to enter into an agreement. The commission
                    payment we will receive has no effect upon the amount of credit available to you or any amounts
                    payable by you.</p>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text__block--right">
                <p>The Trade Centre Group PLC is authorised and regulated by the Financial Conduct Authority (our
                    registration number is 689365) and is permitted to carry on relevant regulated consumer credit
                    activities including acting as a credit broker and not a lender.</p>
                <p>You can check this on the FCA’s register by visiting the FCA’s website www.fca.org.uk/register or by
                    contacting the FCA on 0800 111 6768.</p>
                <p class="reprapr">14.9% APR Representative</p>
            </div>
        </div>

        <div class="row">
            <div class="col col-12 | footer__links">
                <div class="footer__links">
                    <!--<a href="/faq">FAQs</a>-->
                    <a href="https://uk.trustpilot.com/review/thetradecentrewales.co.uk" target="_blank">Reviews</a>
                    <a href="/finance">Free Finance Check</a>
                    <a href="/terms-and-conditions">Terms &amp; Conditions</a>
                    <a href="/privacy-notice">Privacy Notice</a>
                    <a href="/modern-slavery-act">Modern Slavery Act</a>
                    <!--<a href="/gender-pay-gap-report-2018">Gender Pay Gap 2018</a>-->
                    <a href="/gender-pay-gap-report-2019">Gender Pay Gap 2019</a>
                    <!--<a href="#">Sitemap</a>-->
                </div>
                <br/>

                <?php
                global $showAreaLinks;
                if (isset($showAreaLinks) && $showAreaLinks == true) : ?>
                <div class="area-links mb-3">
                    <p>
                        Some of the areas we cover in <a href="/in/reset">Wales</a>:
                        <?php
                        $areas = get_terms(['taxonomy' => 'areas', 'hide_empty' => true]);
                        $areaCount = count($areas) - 1;
                        $i = 0;
                        foreach ($areas as $area) :
                        echo '<a href="/in/' . $area->slug . '">' . $area->name . '</a>';
                        if ($i < $areaCount) {
                            echo ', ';
                        } else {
                            echo '.';
                        }
                        $i++;
                        endforeach;
                        ?>
                    </p>
                </div>
                <?php endif; ?>
                <span class="copyright">Copyright 2020 The Trade Centre Group Plc.</span></div>
        </div>
    </div>
</footer>
<?php
get_template_part('template-parts/footer/mobilefooter', 'footer');
wp_footer(); ?>
</body>
</html>
