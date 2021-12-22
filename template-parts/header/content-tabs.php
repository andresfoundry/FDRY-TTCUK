<?php
global $tertiaryPage, $pageUrl;
?><section class="content-tabs <?php echo (($tertiaryPage && $pageUrl !== 'price-promise') ? 'tabShadowPerm' : ''); ?>" role="tablist">
    <div class="list-group list-group-horizontal d-flex justify-content-center" id="content-tabs">
        <a class="list-group-item list-group-item-action text-center d-none d-md-block | tab-cc" href="#clickcollect"
           data-toggle="list" role="tab">CLICK &amp; COLLECT</a>
        <a class="list-group-item list-group-item-action active text-center | tab-ds" href="<?php area_link('/car-search'); ?>">CAR SEARCH</a>
        <?php
        if ($tertiaryPage) :
        ?>
            <a class="list-group-item list-group-item-action active text-center | tab-pp" href="/price-promise">PRICE PROMISE</a>
        <?php else : ?>
            <a class="list-group-item list-group-item-action text-center | tab-pp" href="/price-promise">PRICE PROMISE</a>
        <?php endif; ?>
        <a class="list-group-item list-group-item-action text-center d-none d-md-block | tab-pfc" href="#freefinance" data-toggle="list" role="tab">FREE FINANCE CHECK</a>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade | tab-pane--1" id="clickcollect" role="tabpanel">
            <div class="container" style="position: relative">
                <div class="row">
                    <div class="col-12 text-right close-tab mb-5">Close <i class="fa fa-times-circle"></i></div>
                    <?php
                    echo do_shortcode('[part_exchange_form]');
                    ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade | tab-pane--4" id="freefinance" role="tabpanel">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-right close-tab">Close <i class="fa fa-times-circle"></i></div>
                    <div class="col col-12">
                        <?php
                            echo do_shortcode('[finance_application_form]');
                        ?>
                        <!--<div id="iframe-container"></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>