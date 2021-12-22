<header class="sticky-top tcheader">
    <?php
    global $branchCustom, $mobile_ribbon_text;
    if (isset($branchCustom)) : ?>
        <section class="d-none d-md-block | branches">
            <div class="d-flex justify-content-end | branches-block">
                <span class="branches__place"><?php
                    echo $branchCustom['address_line_1'][0] . ', ' . $branchCustom['address_line_2'][0] . ', ' .
                        $branchCustom['town_city'][0] . ', ' . $branchCustom['postcode'][0]; ?></span>
                <span class="branches__address"><a
                            class="button-red opening-times">Opening Times and Directions</a></span>
            </div>
        </section>
    <?php
    else : ?>
        <section class="d-none d-md-block | locations mr-5 pr-5">
            <div class="d-flex justify-content-end | locations-block pr-3">
                <span class="d-none d-lg-block locations__intro">Our Car Supermarkets:</span>
                <?php
                $args = [
                    'posts_per_page' => -1,
                    'post_type' => 'branch',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ];

                $myProducts = new WP_Query($args);
                while ($myProducts->have_posts()) :
                    $item = $myProducts->next_post();
                    ?>
                    <span class="locations__place icon"><a href="/branches/<?php
                        echo $item->post_name; ?>"><?php
                            echo $item->post_title; ?></a></span>
                <?php
                endwhile; ?>
            </div>
        </section>
    <?php
    endif; ?>
    <section class="d-flex | navigation">
        <div class="container-fluid">
            <div class="row | navigation__wrapper">
                <div class="col col-12 navigation__container">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="col col-2 col-md-1">
                            <a class="navbar-brand | site-logo" href="<?php
                            area_link('/'); ?>">
                                <div class="img logo logo-wales"></div>
                            </a>
                        </div>
                        <div class="col col-6 col-md-6 col-lg-2 order-lg-1 mr-xl-5">
                            <img class="trustpilot d-lg-none d-xl-block" src="/images/trustpilot-review-score45.svg"
                                 alt="Trustpilot Score">
                        </div>

                        <div class="col pt-2 pl-0 d-md-none text-right">
                            <a href="tel:01792814300">
                                <i class="fa fa-phone fa-2 navbar-phone"></i>
                            </a>
                        </div>
                        <button class="order-lg-1 navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="col offset-md-1 offset-xl-0 collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto | ">
                                <?php
                                $linkArray = [
                                    [area_link('/', true), 'Home'],
                                    ['/social-distancing', 'Safety'],
                                    ['/finance', 'Finance'],
                                    ['/part-exchange', 'Part Exchange'],
                                    ['/warranties', 'Warranties'],
                                    ['/price-promise', 'Price Promise'],
                                    ['/no-admin-fees', 'No Admin Fees'],
                                    ['/news', 'News'],
                                    ['/careers', 'Careers'],
                                    ['/contact', 'Contact'],
                                ];
                                //var_dump($linkArray);die;
                                foreach ($linkArray as $linkItem) :
                                    $active = '';
                                    if ('/' . $wp->request == $linkItem[0]) {
                                        $active = 'active ';
                                    }
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $active; ?>" href="<?php echo $linkItem[0]; ?>"><?php echo $linkItem[1]; ?></a>
                                    </li>

                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-12 ribbon-container">
                    <div class="hidden-print mobile-ribbon d-md-none animated slideInDown"><?php
                        echo $mobile_ribbon_text; ?></div>
                </div>
            </div>
        </div>
    </section>
</header>