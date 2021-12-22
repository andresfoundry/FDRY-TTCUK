<section class="carsearch pt-5">
    <div class="container mb-3">
        <div class="row">
            <div class="col-12">
                <h1>Find your perfect car today</h1>
                <span class="">You could be driving your new car today</span>
            </div>
        </div>
    </div>
    <div class="container mb-3">
        <div class="row">
            <div class="col-12 d-none d-md-block">
            </div>
            <div class="col-12 pl-md-5 carsearch__imagewrapper">
                <img class="d-none d-md-block carsearch__image" src="<?php
                echo get_stylesheet_directory_uri() . '/images/car-stand-full.jpg' ?>"/>
                <img class="d-md-none carsearch__image" src="<?php
                echo get_stylesheet_directory_uri() . '/images/car-stand.png' ?>"/>
                <div class="row d-flex justify-content-center px-3 mb-3 carsearch__formwrapper">
                    <div class="col-12 p-4 carsearch__form">
                        <form class="" method="get" id="car-search" action="/car-search">
                            <h4>Let's get started...</h4>
                            <div class="select__wrapper">
                                <select name="location" id="location">
                                    <option disabled selected>Location</option>
                                    <!--<option value="any">Any</option>-->
                                    <?php
                                    $args = [
                                        'fields' => 'ids',
                                        'post_type' => ['branch'],
                                        'posts_per_page' => '-1',
                                        'orderby' => 'title',
                                        'order' => 'ASC'
                                    ];

                                    $carMakes = [];
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $branchItemId = $query->next_post();
                                            $branchItem = get_post($branchItemId);
                                            $selected = '';

                                            if (isset($_SESSION['area']) && $_SESSION['area'] === $branchItem->post_title) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?php
                                            echo $branchItem->post_name ?>" <?php echo $selected; ?>><?php
                                                echo $branchItem->post_title ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select__wrapper">
                                <select disabled name="make" id="make">
                                    <option disabled selected>Select Location</option>
                                    <?php
                                    /*$args = [
                                        'fields' => 'ids',
                                        'post_type' => ['carmake'],
                                        'posts_per_page' => '-1',
                                        'orderby' => 'title',
                                        'order' => 'ASC'
                                    ];

                                    $carMakes = [];
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $carMakeId = $query->next_post();
                                            $carMake = get_post($carMakeId);
                                            $args = [
                                                'fields' => 'ids',
                                                'post_type' => ['car'],
                                                'posts_per_page' => '1',
                                                'orderby' => 'title',
                                                'order' => 'ASC',
                                                'meta_query' => [
                                                    'relation' => 'AND',
                                                    [
                                                        'key' => 'make',
                                                        'value' => $carMake->ID,
                                                        'compare' => '=',
                                                    ]
                                                ]
                                            ];
                                            $carsQuery = new WP_Query($args);
                                            if ($carsQuery->have_posts()) {
                                                ?>
                                                <option value="<?php
                                                echo $carMake->ID ?>"><?php
                                                    echo $carMake->post_title ?></option>
                                                <?php
                                            }
                                        }
                                    }*/
                                    ?>
                                </select>
                            </div>
                            <div class="select__wrapper">
                                <select disabled name="model" id="model">
                                    <option disabled selected>Select Location</option>
                                </select>
                            </div>
                            <button class="button__search">Search</button>
                            <button class="button__budgetsearch">Budget Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>