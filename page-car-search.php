<?php
/**
 * The page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $post;

$meta_query = [];

$make_name_slug = get_query_var('make_name_slug');
$model_name_slug = get_query_var('model_name_slug');

if ($make_name_slug === 'in') {
    $area = $model_name_slug;
    $model_name_slug = '';
    $make_name_slug = '';
} else {
    $area = get_query_var('area');
}

/*$make_name_slug = '';
$model_name_slug = '';
$area = '';*/

if (!empty($make_name_slug) && $make_name_slug !== 'any') {
    $meta_query[] =
        [
            'key' => 'make_name_slug',
            'value' => $make_name_slug,
            'compare' => '='
        ];
} else {
    $make_name_slug = 'any';
}

if (!empty($model_name_slug) && $model_name_slug !== 'any') {
    $meta_query[] =
        [
            'key' => 'model_name_slug',
            'value' => $model_name_slug,
            'compare' => '='
        ];
} else {
    $model_name_slug = 'any';
}

$args = [
    'posts_per_page' => -1,
    'post_type' => 'branch',
    'orderby' => 'menu_order',
    'order' => 'ASC'
];

$_SESSION['area_slug'] = $area;
/*var_dump($area);
die;*/
$_SESSION['make_name_slug'] = $make_name_slug;
$_SESSION['model_name_slug'] = $model_name_slug;

$myBranches = new WP_Query($args);
$branchArray = [];
while ($myBranches->have_posts()) {
    $myBranch = $myBranches->next_post();
    $branchArray[$myBranch->post_name] = $myBranch->ID;
}

if (!empty($area)) {
    $myBranchId = '';
    if (isset($branchArray[$area])) {
        $myBranchId = $branchArray[$area];
    } else {
        if ($_SESSION['areaBranchId']) {
            $myBranchId = $_SESSION['areaBranchId'];
        }
    }
    if ($myBranchId) {
        $meta_query[] =
            [
                'key' => 'location',
                'value' => $myBranchId,
                'compare' => '=',
            ];
    }
}

$args = [
    'fields' => 'ids',
    'post_type' => ['car'],
    'posts_per_page' => '-1',
    /*'orderby' => 'title',
    'order' => 'ASC',*/
    'orderby' => [
        'make_name' => 'ASC',
        'model_name' => 'ASC',
    ],
    'meta_query' => [
        'relation' => 'AND',
        $meta_query
    ]
];

/*echo "<pre>";
var_dump($args);
die;*/

$carQuery = new WP_Query($args);

if (!$carQuery->have_posts()) {
    if (!empty($model_name_slug) && $model_name_slug !== 'any') {
        wp_redirect('/cars/' . $make_name_slug . '/in/' . $area);
    } else {
        wp_redirect('/cars/in/' . $area);
    }
}
/*$priceArray = [];
$counter = 0;
while ($carQuery->have_posts()) {
    $counter++;
    $carId = $carQuery->next_post();
    $rrp = get_field('rrp', $carId);
    if (!in_array($rrp, $priceArray)) {
        $priceArray[] = $rrp;
    }
}
sort($priceArray);
foreach ($priceArray as $item) {
    echo $item . '<br/>';
}
echo "Total cars: $counter";
die;*/

$title = $post->post_title . ' - ' . get_bloginfo('name');

get_header();
?>
    <main class="container-fluid mt-2 carsearch__wrapper">
        <div class="row">
            <div class="col-12 col-lg-2 order-1 order-lg-2 mt-3 mt-lg-0 d-lg-none">
                <div class="row">
                    <div class="col-12">
                        <h1>Search Results</h1>
                        <hr/>
                    </div>
                    <div class="col-6 mb-1 text-left d-lg-none">
                        <button class="filter__button collapsed" data-toggle="collapse" href="#collapseFilters"
                                role="button"
                                aria-expanded="false" aria-controls="collapseFilters"><i class="fal fa-car"></i>&nbsp;Filters
                        </button>
                    </div>
                    <div class="col-6 mb-1 text-right d-lg-none">
                        <button class="sort__button" data-group="sort-group"><i class="far fa-sort-alpha-down-alt"></i>&nbsp;Sort
                            by
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 order-2 order-lg-1 mt-3 mt-lg-0 mb-lg-4 collapse d-lg-block" id="collapseFilters">
                <form class="">
                    <div class="row no-gutters search__section pb-3">
                        <div class="col-12">
                            <h2 class="">Search</h2>
                            <hr/>
                        </div>
                        <div class="col-12">
                            <?php
                            $selectedLocation = '';
                            if ($_SESSION['area']) {
                                $selectedLocation = ' : ' . $_SESSION['area'];
                            }
                            ?>
                            <button class="group__button search__button" data-group="location-group">Location<?php
                                echo $selectedLocation; ?></button>
                            <ul class="group__collection" id="location-group">
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
                                    $i = 0;
                                    while ($query->have_posts()) {
                                        $branchItemId = $query->next_post();
                                        $branchItem = get_post($branchItemId);
                                        $checked = '';

                                        if (isset($_SESSION['area']) && $_SESSION['area'] === $branchItem->post_title) {
                                            $checked = 'checked';
                                        }

                                        ?>
                                        <li><label for="location_option<?php
                                            echo $i; ?>"><input type="radio" value="<?php
                                                echo $branchItem->post_name ?>" <?php
                                                echo $checked; ?> id="location_option<?php
                                                echo $i++; ?>"
                                                                name="location"/><?php
                                                echo $branchItem->post_title ?></label></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                            $JSONData = file_get_contents(
                                ABSPATH . 'JSON/' . sanitize_title($_SESSION['area']) . '.json'
                            );
                            $JSONData = json_decode($JSONData);
                            $uniqueMakes = [];
                            $selectedMake = '';
                            $i = 0;
                            foreach ($JSONData as $makeModel) :
                                if (!in_array($makeModel->make, $uniqueMakes)) :
                                    $uniqueMakes[$makeModel->make_slug] = $makeModel->make;
                                    if ($make_name_slug && $make_name_slug === $makeModel->make_slug) {
                                        $selectedMake = ' : ' . $makeModel->make;
                                    }
                                endif;
                            endforeach;

                            asort($uniqueMakes);
                            $uniqueMakes = ['any' => 'Any'] + $uniqueMakes;
                            ?>
                            <button class="group__button search__button" data-group="make-group">Make<?php
                                echo $selectedMake; ?></button>
                            <ul class="group__collection" id="make-group">
                                <?php

                                foreach ($uniqueMakes as $make_slug => $make) :
                                    $checked = '';
                                    if ($make_name_slug && $make_name_slug === $make_slug) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <li><label for="make_option<?php
                                        echo $i; ?>"><input type="radio" value="<?php
                                            echo $make_slug; ?>" id="make_option<?php
                                            echo $i++; ?>"
                                                            name="make" <?php
                                            echo $checked; ?>/><?php
                                            echo $make; ?></label></li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                            <?php
                            $uniqueModels = [];
                            $selectedModel = '';
                            $i = 0;
                            foreach ($JSONData as $makeModel) :
                                if ($make_name_slug && $make_name_slug === $makeModel->make_slug && !in_array(
                                        $makeModel->model,
                                        $uniqueModels
                                    )) :
                                    $uniqueModels[$makeModel->model_slug] = $makeModel->model;
                                    if ($model_name_slug && $model_name_slug === $makeModel->model_slug) {
                                        $selectedModel = ' : ' . $makeModel->model;
                                    }
                                endif;
                            endforeach;

                            asort($uniqueModels);
                            $uniqueModels = ['any' => 'Any'] + $uniqueModels;
                            ?>
                            <button class="group__button search__button" data-group="model-group">Model<?php
                                echo $selectedModel; ?></button>
                            <ul class="group__collection" id="model-group">
                                <?php

                                foreach ($uniqueModels as $model_slug => $model) :
                                    $checked = '';
                                    if ($model_name_slug && $model_name_slug === $model_slug) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <li><label for="model_option<?php
                                        echo $i; ?>"><input type="radio" value="<?php
                                            echo $model_slug; ?>" id="model_option<?php
                                            echo $i++; ?>"
                                                            name="model" <?php
                                            echo $checked; ?>/><?php
                                            echo $model; ?></label></li>
                                <?php
                                endforeach;
                                if ($i === 0) :
                                    ?>
                                    <li>Select Make</li>
                                <?php
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                </form>
                <div class="row no-gutters filter__section p-3">
                    <div class="col-12 d-flex align-items-center">
                        <h2 class="">Filters</h2>
                    </div>
                    <div class="col-12">
                        <hr/>
                        <form id="search-form" action="" method="post">
                            <button class="group__button" data-group="price-group">Price</button>
                            <ul class="group__collection" id="price-group">
                                <li><label for="price_option1"><input type="radio" value="1" id="price_option1"
                                                                      name="price"/>Option 1</label></li>
                                <li><label for="price_option2"><input type="radio" value="2" id="price_option2"
                                                                      name="price"/>Option 2</label></li>
                                <li><label for="price_option3"><input type="radio" value="3" id="price_option3"
                                                                      name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="enginecapacity-group">Engine Size</button>
                            <ul class="group__collection" id="enginecapacity-group">
                                <li><label for="engine_size_option1"><input type="radio" value="1"
                                                                            id="engine_size_option1"
                                                                            name="price"/>Option 1</label></li>
                                <li><label for="engine_size_option2"><input type="radio" value="2"
                                                                            id="engine_size_option2"
                                                                            name="price"/>Option 2</label></li>
                                <li><label for="engine_size_option3"><input type="radio" value="3"
                                                                            id="engine_size_option3"
                                                                            name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="bodytype-group">Body Style</button>
                            <ul class="group__collection" id="bodytype-group">
                                <li><label for="body_style_option1"><input type="radio" value="1"
                                                                           id="body_style_option1"
                                                                           name="price"/>Option 1</label></li>
                                <li><label for="body_style_option2"><input type="radio" value="2"
                                                                           id="body_style_option2"
                                                                           name="price"/>Option 2</label></li>
                                <li><label for="body_style_option3"><input type="radio" value="3"
                                                                           id="body_style_option3"
                                                                           name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="transmission-group">Gearbox</button>
                            <ul class="group__collection" id="transmission-group">
                                <li><label for="gearbox_option1"><input type="radio" value="1" id="gearbox_option1"
                                                                        name="price"/>Option 1</label></li>
                                <li><label for="gearbox_option2"><input type="radio" value="2" id="gearbox_option2"
                                                                        name="price"/>Option 2</label></li>
                                <li><label for="gearbox_option3"><input type="radio" value="3" id="gearbox_option3"
                                                                        name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="fueltype-group">Fuel Type</button>
                            <ul class="group__collection" id="fueltype-group">
                                <li><label for="fuel_type_option1"><input type="radio" value="1" id="fuel_type_option1"
                                                                          name="price"/>Option 1</label></li>
                                <li><label for="fuel_type_option2"><input type="radio" value="2" id="fuel_type_option2"
                                                                          name="price"/>Option 2</label></li>
                                <li><label for="fuel_type_option3"><input type="radio" value="3" id="fuel_type_option3"
                                                                          name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="doors-group">Doors</button>
                            <ul class="group__collection" id="doors-group">
                                <li><label for="doors_option1"><input type="radio" value="1" id="doors_option1"
                                                                      name="price"/>Option 1</label></li>
                                <li><label for="doors_option2"><input type="radio" value="2" id="doors_option2"
                                                                      name="price"/>Option 2</label></li>
                                <li><label for="doors_option3"><input type="radio" value="3" id="doors_option3"
                                                                      name="price"/>Option 3</label></li>
                            </ul>
                            <button class="group__button" data-group="seats-group">Seats</button>
                            <ul class="group__collection" id="seats-group">
                                <li><label for="seats_option1"><input type="radio" value="1" id="seats_option1"
                                                                      name="price"/>Option 1</label></li>
                                <li><label for="seats_option2"><input type="radio" value="2" id="seats_option2"
                                                                      name="price"/>Option 2</label></li>
                                <li><label for="seats_option3"><input type="radio" value="3" id="seats_option3"
                                                                      name="price"/>Option 3</label></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg order-3 order-lg-2" id="searchResults">
                <div class="row d-none d-lg-block">
                    <div class="col-12">
                        <h1>Search Results</h1>
                        <hr/>
                    </div>
                </div>
                <div class="row no-gutters results__section">
                    <div class="col-12 mb-3 text-left">
                        <button id="sort-data" class="sort__button d-none d-lg-block" data-group="sort-group"><i
                                    class="far fa-sort-alpha-down-alt"></i>&nbsp;Sort
                            by : <span class="sortinfo"></span>
                        </button>
                        <ul class="group__collection" id="sort-group">
                            <li>
                                <button id="default-sortoption" class="sortby" data-sortby="rrp"
                                        data-sortnumerical="true"
                                        data-sortascending="true">Price (Low to High)
                                </button>
                            </li>
                            <li>
                                <button class="sortby" data-sortby="rrp" data-sortnumerical="true"
                                        data-sortascending="false">Price (High to Low)
                                </button>
                            </li>
                            <li>
                                <button class="sortby" data-sortby="name" data-sortnumerical="false"
                                        data-sortascending="true">Name
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="row results__block px-2">
                        <!--<div class="sort__overlay">YARP!!</div>-->
                        <?php
                        if ($carQuery->have_posts()) :
                            while ($carQuery->have_posts()) :
                                $carId = $carQuery->next_post();
                                $car = get_post($carId);
                                $make_name = get_field('make_name', $carId);
                                $model_name = get_field('model_name', $carId);
                                $make_name_slug = get_field('make_name_slug', $carId);
                                $model_name_slug = get_field('model_name_slug', $carId);
                                $location = get_post(get_field('location', $carId));
                                $reg_date = explode('/', get_field('reg_date', $carId));
                                if (count($reg_date) === 3) {
                                    $reg_date = $reg_date[2];
                                } else {
                                    $reg_date = '';
                                }

                                $rrp = get_field('rrp', $carId) ?: 'POA';
                                $weeklyPrice = TcFinance::getWeeklyPrice($rrp) ?: 'POA';
                                if (!empty($weeklyPrice['pence'])) {
                                    $weeklyPriceDisplay = $weeklyPrice['pounds'] . '<span class="pence">.' . $weeklyPrice['pence'] . '</span>';
                                } else {
                                    $weeklyPriceDisplay = $weeklyPrice['pounds'];
                                }
                                $tradeInWeeklyPrice = TcFinance::getTradeInWeeklyPrice($rrp) ?: 'POA';
                                if (!empty($tradeInWeeklyPrice['pence'])) {
                                    $tradeInWeeklyPriceDisplay = $tradeInWeeklyPrice['pounds'] . '<span class="pence">.' . $tradeInWeeklyPrice['pence'] . '</span>';
                                } else {
                                    $tradeInWeeklyPriceDisplay = $tradeInWeeklyPrice['pounds'];
                                }
                                $carImage = get_stylesheet_directory_uri() . '/images/BMW.jpg';
                                $carImage = 'https://cdn.spincar.com/swipetospin-viewers/tradecentreneath/wr18oww/20210605140114.OATPUZKO/thumb-lg.jpg';
                                $carImage = 'https://cdn.tradecentregroup.io/image/upload/q_auto/f_auto/w_600/web/Group/cars/' . $make_name_slug . '/' . $model_name_slug . '.png';
                                $data = [];
                                ?>
                                <div class="col-12 px-1 col-md-6 result__item not-shown" style="display: none;"
                                     data-rrp="<?php
                                     echo $rrp; ?>" data-weeklyprice="<?php
                                echo $weeklyPrice['price']; ?>"
                                     data-name="<?php
                                     echo $make_name . ' ' . $model_name . ' ' . get_field('derivative', $carId); ?>"
                                     data-enginecapacity="<?php
                                     echo (ceil(get_field('enginecapacity', $carId) / 100) * 100); ?>"
                                     data-bodytype="<?php
                                     echo get_field('bodytype', $carId); ?>"
                                     data-transmission="<?php
                                     echo get_field('transmission', $carId); ?>"
                                     data-fueltype="<?php
                                     echo get_field('fueltype', $carId); ?>"
                                     data-seats="<?php
                                     echo get_field('seats', $carId); ?>"
                                     data-doors="<?php
                                     echo get_field('doors', $carId); ?>"
                                >
                                    <div class="row no-gutters p-3 result__card">
                                        <!--<div class="col-12 text-right">
                                            <img src="/images/tcw-logo.svg" width="48px"/>
                                        </div>-->
                                        <div class="col-12">
                                            <a href="/cars/<?php
                                            echo $make_name_slug . '/' . $model_name_slug . '/' . sanitize_title(
                                                    get_field('derivative', $carId)
                                                ) . '/' . $carId; ?>"><img
                                                        src="<?php echo $carImage; ?>"/></a>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <h4><?php
                                                echo strtoupper($make_name . ' ' . $model_name); ?></h4>
                                            <span><?php
                                                echo get_field('derivative', $carId); ?></span>
                                            <span><?php
                                                echo get_field('reg_number', $carId); ?></span>
                                            <p>LOCATION: <strong><?php
                                                echo strtoupper($location->post_title); ?></strong></p>
                                            <ul class="bullet-line">
                                                <li><?php echo get_field('bodytype', $carId); ?></li>
                                                <li><?php echo get_field('colour', $carId); ?></li>
                                                <li><?php echo cns_format_engine_capacity(get_field('enginecapacity', $carId)); ?></li>
                                                <li><?php echo get_field('fueltype', $carId); ?></li>
                                                <li><?php echo number_format(get_field('mileage', $carId)); ?> Miles</li>
                                                <li><?php echo get_field('transmission', $carId); ?></li>
                                                <?php
                                                if ($reg_date) :
                                                ?>
                                                <li><?php echo $reg_date; ?></li>
                                                    <?php
                                                endif;
                                                    ?>
                                                <li><?php echo get_field('doors', $carId); ?> Door</li>
                                                <li><?php echo get_field('seats', $carId); ?> Seats</li>
                                            </ul>
                                            <button class="d-flex justify-content-center align-items-center cashprice__button">
                                                Cash Price&nbsp;<strong>&pound;<?php
                                                    echo number_format($rrp); ?></strong>
                                            </button>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="row no-gutters">
                                                <div class="col-6 pr-1">
                                                    <div class="row no-gutters p-2 cash__breakdown">
                                                        <div class="col-6 rightborder d-flex text-center align-items-center deposit__text pr-1">
                                                            &pound;99 Cash Deposit
                                                        </div>
                                                        <div class="col-6 d-flex text-center align-items-center justify-content-center weekly__text">
                                                            <div class="w-100">
                                                                <strong>&pound;<?php
                                                                    echo $weeklyPriceDisplay; ?></strong>
                                                                <br/>PER WEEK
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <div class="row no-gutters p-2 cash__breakdown">
                                                        <div class="col-6 rightborder d-flex text-center align-items-center justify-content-center deposit__text pr-1">
                                                            &pound;1000 for your old car as deposit
                                                        </div>
                                                        <div class="col-6 d-flex text-center align-items-center weekly__text">
                                                            <div class="w-100">
                                                                <strong>&pound;<?php echo $tradeInWeeklyPriceDisplay; ?></strong>
                                                                <br/>PER WEEK
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="row no-gutters">
                                                <div class="col-6 pr-1">
                                                    <div class="row no-gutters p-1 p-lg-2 finance__example">
                                                        <div class="col-12 d-flex align-items-center justify-content-center">
                                                            <a href="#"><i class="far fa-external-link"></i> FINANCE
                                                                EXAMPLE</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <div class="row no-gutters p-1 p-lg-2 finance__example">
                                                        <div class="col-12 d-flex align-items-center justify-content-center">
                                                            <a href="#"><i class="far fa-external-link"></i> FINANCE
                                                                EXAMPLE</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="d-flex justify-content-center align-items-center bespoke__button">
                                                <i class="fal fa-user-tag"></i>&nbsp;Bespoke deals available
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        ?>

                    </div>
                </div>
                <div class="row no-gutters d-none no-results">
                    <div class="col-12 text-center mb-5">
                        <h2>Sorry! There are no cars matching your search.</h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-12 text-center mb-5">
                        <button class="btn btn-default showmore__button" style="display: none;">Load More</button>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col-12 col-lg-10">
        </div>-->
    </main>
<?php
get_footer();
