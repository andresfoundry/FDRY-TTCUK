<?php

/**
 * Functions
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

include_once 'includes/constants.php';
include_once 'includes/customizer.php';
include_once 'includes/shortcodes.php';
include_once 'includes/helpers.php';
include_once 'includes/api.php';
include_once "includes/classes/TcFinance.php";

function show_template()
{
    global $template;
    print_r($template);
}

// add_action('admin_bar_menu', 'show_template');

// Posts support
// 'title',
// 'editor',
// 'revisions',
// 'author',
// 'excerpt',
// 'page-attributes',
// 'thumbnail',
// 'custom-fields',
// 'post-formats'

function cns_define_specials_post_type()
{
    $post_type = 'specials';
    $args = [
        'supports' => [
            'title',
            //'editor',
            'custom-fields',
            'post-formats'
        ],
        'labels' => [
            'name' => 'Specials',
            'singular_name' => 'Special Offer',
            'add_new' => 'Add New Special Offer',
            'add_new_item' => 'Add New Special Offer',
            'edit_item' => 'Edit Special Offer',
            'new_item' => 'New Special Offer',
            'all_items' => 'All Specials',
            'view_item' => 'View Special Offer',
            'search_items' => 'Search Specials',
            'not_found' => 'No special offer found',
            'not_found_in_trash' => 'No Specials found in Bin',
            'menu_name' => 'Specials',
        ],
        'public' => true,
        'hierarchical' => false,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

//add_action('init', 'cns_define_specials_post_type');

function cns_define_finance_post_type()
{
    $post_type = 'financeexample';
    $args = [
        'supports' => [
            'title',
            //'editor',
            'custom-fields',
            'post-formats'
        ],
        'labels' => [
            'name' => 'Finances',
            'singular_name' => 'Finance',
            'add_new' => 'Add New Finance',
            'add_new_item' => 'Add New Finance',
            'edit_item' => 'Edit Finance',
            'new_item' => 'New Finance',
            'all_items' => 'All Finances',
            'view_item' => 'View Finance',
            'search_items' => 'Search Finances',
            'not_found' => 'No finance found',
            'not_found_in_trash' => 'No Finances found in Bin',
            'menu_name' => 'Finances',
        ],
        'public' => true,
        'hierarchical' => false,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

add_action('init', 'cns_define_finance_post_type');

function cns_finance_columns($columns)
{
    return [
        'cb' => $columns['cb'],
        'title' => __('Weekly Price', 'calculation'),
        'cash_price' => __('Cash Price', 'calculation'),
        'deposit' => __('Deposit', 'calculation'),
        'credit_amount' => __('Credit Amount', 'calculation'),
        'final_payment' => __('Final Payment', 'calculation'),
        'monthly_amount' => __('Monthly Amount', 'calculation'),
        'apr' => __('Apr', 'calculation'),
        'total_amount' => __('Total Amount', 'calculation'),
        'term' => __('Term', 'calculation'),
        'date' => $columns['date'],
    ];
}

add_filter('manage_finance_posts_columns', 'cns_finance_columns');

function cns_finance_column($column, $post_id)
{
    $columns = [
        'cash_price',
        'deposit',
        'credit_amount',
        'final_payment',
        'monthly_amount',
        'apr',
        'total_amount',
        'term',
    ];
    if (in_array($column, $columns)) {
        $field = get_post_meta($post_id, $column, true);
    }

    if (isset($field)) {
        echo $field;
    }
}

add_action('manage_finance_posts_custom_column', 'cns_finance_column', 10, 2);

function cns_define_car_make_post_type()
{
    $post_type = 'carmake';
    $args = [
        'supports' => [
            'title',
            'editor',
            'custom-fields',
            'post-formats'
        ],
        'labels' => [
            'name' => 'Car Makes',
            'singular_name' => 'Car Make',
            'add_new' => 'Add New Car Make',
            'add_new_item' => 'Add New Car Make',
            'edit_item' => 'Edit Car Make',
            'new_item' => 'New Car Make',
            'all_items' => 'All Car Makes',
            'view_item' => 'View Car Make',
            'search_items' => 'Search Car Makes',
            'not_found' => 'No car make found',
            'not_found_in_trash' => 'No Car Make found in Bin',
            'menu_name' => 'Car Makes',
        ],
        'rewrite' => ['slug' => 'cars'],
        'public' => true,
        'hierarchical' => true,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

//add_action('init', 'cns_define_car_make_post_type');

function cns_carmake_columns($columns)
{
    return [
        'cb' => $columns['cb'],
        'title' => __('Make', 'calculation'),
        'content' => __('Description', 'calculation'),
        'date' => $columns['date'],
    ];
}

//add_filter('manage_carmake_posts_columns', 'cns_carmake_columns');

function cns_carmake_column($column, $post_id)
{
    $columns = [
        'make',
    ];
    if (in_array($column, $columns)) {
        $field = get_post_meta($post_id, $column, true);
    }

    if ($column === 'content') {
        if ($page = get_post($post_id)) {
            $field = limit_words(apply_filters('the_content', $page->post_content), 25);
        }
    }

    if (isset($field)) {
        echo $field;
    }
}

//add_action('manage_carmake_posts_custom_column', 'cns_carmake_column', 10, 2);

function cns_define_car_model_post_type()
{
    $post_type = 'carmodel';
    $args = [
        'supports' => [
            'title',
            'editor',
            'custom-fields',
            'thumbnail',
            'post-formats'
        ],
        'labels' => [
            'name' => 'Car Models',
            'singular_name' => 'Car Model',
            'add_new' => 'Add New Car Model',
            'add_new_item' => 'Add New Car Model',
            'edit_item' => 'Edit Car Model',
            'new_item' => 'New Car Model',
            'all_items' => 'All Car Models',
            'view_item' => 'View Car Model',
            'search_items' => 'Search Car Models',
            'not_found' => 'No car model found',
            'not_found_in_trash' => 'No Car Model found in Bin',
            'menu_name' => 'Car Models',
        ],
        'public' => true,
        'hierarchical' => false,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

//add_action('init', 'cns_define_car_model_post_type');

function cns_add_meta_boxes()
{
    add_meta_box('carmodel-parent', 'Make', 'cns_carmodel_attributes_meta_box', 'carmodel', 'side', 'high');
}

//add_action('add_meta_boxes', 'cns_add_meta_boxes');

function cns_carmodel_attributes_meta_box($post)
{
    $post_type_object = get_post_type_object($post->post_type);
    $pages = wp_dropdown_pages(
        array(
            'post_type' => 'carmake',
            'selected' => $post->post_parent,
            'name' => 'parent_id',
            'show_option_none' => __('(no parent)'),
            'sort_column' => 'menu_order, post_title',
            'echo' => 0
        )
    );
    if (!empty($pages)) {
        echo $pages;
    }
}

/*function cns_disable_canonical_redirect($redirect)
{
    global $wp;
    if (is_page() && $front_page = get_option('page_on_front')) {
        if (is_page($front_page)) {
            $redirect = false;
        }
    } elseif (stripos($wp->request, '/in/' !== false)) {
        $redirect = false;
    }

    return $redirect;
}

add_filter('redirect_canonical', 'cns_disable_canonical_redirect');*/


function cns_add_rewrite_rules()
{
    // Cars
    add_rewrite_rule('^cars/([^/]+)$', 'index.php?pagename=car-search&make_name_slug=$matches[1]', 'top');
    add_rewrite_rule('^cars/([^/]+)$', 'index.php?pagename=car-search&make_name_slug=$matches[1]', 'top');
    add_rewrite_rule('^cars/([^/]+)/([^/]+)$', 'index.php?pagename=car-search&make_name_slug=$matches[1]&model_name_slug=$matches[2]', 'top');
    add_rewrite_rule('^cars/([^/]+)/in/([^/]+)$', 'index.php?pagename=car-search&make_name_slug=$matches[1]&area=$matches[2]', 'top');
    add_rewrite_rule('^cars/([^/]+)/([^/]+)/in/([^/]+)$', 'index.php?pagename=car-search&make_name_slug=$matches[1]&model_name_slug=$matches[2]&area=$matches[3]', 'top');
    add_rewrite_rule('^cars/([^/]+)/([^/]+)/([^/]+)/([^/]+)$', 'index.php?pagename=car-detail&make_name_slug=$matches[1]&model_name_slug=$matches[2]&derivative=$matches[3]&car_id=$matches[4]', 'top');

    // Other
    add_rewrite_rule('news/page/?([0-9]{1,})/?$', 'index.php?category_name=news&page_id=$matches[1]', 'top');
    add_rewrite_rule('reserve/([^/]+)/([^/]+)$', 'index.php?pagename=reserve&upfront=$matches[1]&car_id=$matches[2]', 'top');
    add_rewrite_rule('checkout/([^/]+)/step/([0-9]{1,})$', 'index.php?pagename=checkout&type=$matches[1]&step_id=$matches[2]', 'top');
    add_rewrite_rule('checkout/([^/]+)/complete$', 'index.php?pagename=checkout&type=$matches[1]&step_id=complete', 'top');

    add_rewrite_rule('checkout/bespoke/([0-9]{1,})$', 'index.php?pagename=checkout&type=bespoke&car_id=$matches[1]&step_id=specify', 'top');
    add_rewrite_rule('checkout/bespoke/payment$', 'index.php?pagename=checkout&type=bespoke&step_id=payment-method', 'top');
    add_rewrite_rule('checkout/bespoke/complete$', 'index.php?pagename=checkout&type=bespoke&step_id=complete', 'top');
    add_rewrite_rule('checkout/bespoke/([^/]+)/step/([0-9]{1,})$', 'index.php?pagename=checkout&type=bespoke&payment_type=$matches[1]&step_id=$matches[2]', 'top');

    flush_rewrite_rules();
}

add_action('init', 'cns_add_rewrite_rules');

add_filter('query_vars', 'cns_query_var');

function cns_query_var($query_vars)
{
    $query_vars[] = 'area';
    $query_vars[] = 'make_name_slug';
    $query_vars[] = 'model_name_slug';
    $query_vars[] = 'derivative';
    $query_vars[] = 'car_id';
    $query_vars[] = 'upfront';
    $query_vars[] = 'type';
    $query_vars[] = 'step_id';
    $query_vars[] = 'payment_type';
    return $query_vars;
}

function cns_permalinks($permalink, $post, $leavename)
{
    $post_id = $post->ID;
    if ($post->post_type != 'carmodel' || empty($permalink) || in_array(
            $post->post_status,
            array('draft', 'pending', 'auto-draft')
        )) {
        return $permalink;
    }

    $parent = $post->post_parent;
    $parent_post = get_post($parent);

    $permalink = str_replace('%carmake%', $parent_post->post_name, $permalink);

    return $permalink;
}

//add_filter('post_type_link', 'cns_permalinks', 10, 3);

function cns_carmodel_columns($columns)
{
    return [
        'cb' => $columns['cb'],
        'make' => __('Make', 'calculation'),
        'title' => __('Model', 'calculation'),
        'core_range' => __('Core Model', 'calculation'),
        'content' => __('Description', 'calculation'),
        'sale_mode_override' => __('Sale Mode Override', 'calculation'),
        'from_price' => __('From Price', 'calculation'),
        'date' => $columns['date'],
    ];
}

//add_filter('manage_carmodel_posts_columns', 'cns_carmodel_columns');

function cns_carmodel_column($column, $post_id)
{
    $columns = [
        'make',
        'core_range',
        'sale_mode_override',
        'from_price',
    ];
    if (in_array($column, $columns)) {
        $field = wp_strip_all_tags(get_post_meta($post_id, $column, true));
    }

    if ($column === 'content') {
        if ($page = get_post($post_id)) {
            $field = limit_words(apply_filters('the_content', $page->post_content), 25);
        }
    }

    if ($column === 'core_range') {
        $field = $field ? 'Yes' : 'No';
    }

    if ($column === 'make') {
        $post = get_post($post_id);
        if ($post->post_parent) {
            $parent = get_post($post->post_parent);
            $field = '<a href="/wp-admin/post.php?post=' . $parent->ID . '&action=edit">' . $parent->post_title . '</a>';
        } else {
            unset($field);
        }
    }

    if (isset($field)) {
        echo $field;
    }
}

//add_action('manage_carmodel_posts_custom_column', 'cns_carmodel_column', 10, 2);

function cns_define_car_model_taxonomy()
{
    $taxonomy = 'cartype';
    $object_type = 'carmodel';
    $args = [
        'labels' => [
            'name' => 'Car Type',
            'singular_name' => 'Car Types',
            'search_items' => 'Car Types',
            'all_items' => 'All Car Types',
            'parent_item' => 'Parent Car Type',
            'parent_item_colon' => 'Parent Car Type:',
            'edit_item' => 'Edit Car Type',
            'update_item' => 'Update Car Type',
            'add_new_item' => 'Add New Car Type',
            'new_item_name' => 'New Car Type Name',
            'menu_name' => 'Car Types',
            'view_item' => 'View Car Types'
        ],
        'hierarchical' => true,
        'has_archive' => false,
        'query_var' => true,
        'rewrite' => true,
    ];
    register_taxonomy($taxonomy, $object_type, $args);
}

//add_action('init', 'cns_define_car_model_taxonomy');

function cns_define_car_post_type()
{
    $post_type = 'car';
    $args = [
        'supports' => [
            'title',
            'editor',
            'custom-fields',
            'post-formats'
        ],
        'labels' => [
            'name' => 'Cars',
            'singular_name' => 'Car',
            'add_new' => 'Add New Car',
            'add_new_item' => 'Add New Car',
            'edit_item' => 'Edit Car',
            'new_item' => 'New Car',
            'all_items' => 'All Car',
            'view_item' => 'View Car',
            'search_items' => 'Search Cars',
            'not_found' => 'No car found',
            'not_found_in_trash' => 'No Car found in Bin',
            'menu_name' => 'Cars',
        ],
        'public' => true,
        'hierarchical' => true,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

add_action('init', 'cns_define_car_post_type');

function cns_car_columns($columns)
{
    return [
        'cb' => $columns['cb'],
        'make_name' => __('Make', 'cns'),
        'model_name' => __('Model', 'cns'),
        'title' => $columns['title'],
        'reg_number_with_space' => __('Reg No.', 'cns'),
        'discounted_price' => __('Discount Price', 'cns'),
        'content' => __('Description', 'cns'),
        'location' => __('Location', 'cns'),
        'date' => $columns['date'],
    ];
}

add_filter('manage_car_posts_columns', 'cns_car_columns');

function cns_car_column($column, $post_id)
{
    $columns = [
        'make_name',
        'model_name',
        'location',
        'reg_number_with_space',
        'discounted_price',
    ];
    if (in_array($column, $columns)) {
        $field = get_post_meta($post_id, $column, true);
    }

    if ($column === 'content') {
        if ($page = get_post($post_id)) {
            $field = limit_words(apply_filters('the_content', $page->post_content), 25);
        }
    }

    /*if ($column === 'make' || $column === 'model' || $column === 'location') {
        $post = get_post($field);
        $field = '<a href="/wp-admin/post.php?post=' . $post->ID . '&action=edit">' . $post->post_title . '</a>';
    }*/

    if (isset($field)) {
        echo $field;
    }
}

add_action('manage_car_posts_custom_column', 'cns_car_column', 10, 2);

function cns_sortable_car_column($columns)
{
    $columns['make_name'] = 'make_name';
    $columns['model_name'] = 'model_name';

    return $columns;
}

//add_filter('manage_edit-car_sortable_columns', 'cns_sortable_car_column');

// Branches
function cns_define_branch_type_taxonomy()
{
    $taxonomy = 'areas';
    $object_type = 'branch';
    $args = [
        'labels' => [
            'name' => 'Areas',
            'singular_name' => 'Area',
            'search_items' => 'Search Areas',
            'all_items' => 'All Areas',
            'parent_item' => 'Parent Areas',
            'parent_item_colon' => 'Parent Areas:',
            'edit_item' => 'Edit Area',
            'update_item' => 'Update Area',
            'add_new_item' => 'Add New Area',
            'new_item_name' => 'New Area',
            'menu_name' => 'Areas',
            'view_item' => 'View Areas'
        ],

        'hierarchical' => true,
        'has_archive' => false,
        'query_var' => true,
        'rewrite' => ['slug' => 'in'],
    ];
    register_taxonomy($taxonomy, $object_type, $args);
}

add_action('init', 'cns_define_branch_type_taxonomy');

function cns_define_branches_post_type()
{
    $post_type = 'branch';
    $args = [
        'supports' => [
            'title',
            'thumbnail',
            'custom-fields',
            'post-formats',
            'page-attributes'
        ],
        'labels' => [
            'name' => 'Branches',
            'singular_name' => 'Branch',
            'add_new' => 'Add New Branch',
            'add_new_item' => 'Add New Branch',
            'edit_item' => 'Edit Branch',
            'new_item' => 'New Branch',
            'all_items' => 'All Branches',
            'view_item' => 'View Branch',
            'search_items' => 'Search Branches',
            'not_found' => 'No branch found',
            'not_found_in_trash' => 'No Branch found in Bin',
            'menu_name' => 'Branches',
        ],
        'rewrite' => ['slug' => 'branches'],
        'public' => true,
        'hierarchical' => true,
        'has_archive' => true,
    ];
    register_post_type($post_type, $args);
}

add_action('init', 'cns_define_branches_post_type');


function start_session()
{
    if (!session_id()) {
        session_start();
    }
}

add_action('init', 'start_session', 1);

function cns_template_redirect()
{
    global $wp_query, $wp, $custom, $tertiaryBanner, $tertiaryBannerMobile, $title, $similarCarTitle, $metaDescription,
           $metaImage, $customerPhotos, $tertiaryPage, $pageUrl, $area, $areaSuffix, $post, $carmake, $carmodel, $branch,
           $branchCustom, $saleMode, $saleModeDiscount;

    $pageUrl = str_replace(site_url() . '/', '', home_url($wp->request));

    $saleMode = get_option('cns_sale_mode');
    if (isset($_GET['mode'])) {
        $saleMode = $_GET['mode'];
    }
    $saleModeDiscount = html_entity_decode(get_option('cns_sale_discount'));

    $title = '';
    $similarCarTitle = '';
    $metaDescription = '';
    $metaImage = '';
    $customerPhotos = [];

    $_SESSION['utm_source'] = (isset($_GET['utm_source'])) ? $_GET['utm_source'] : $_SESSION['utm_source'];
    $_SESSION['utm_medium'] = (isset($_GET['utm_medium'])) ? $_GET['utm_medium'] : $_SESSION['utm_medium'];
    $_SESSION['utm_content'] = (isset($_GET['utm_content'])) ? $_GET['utm_content'] : $_SESSION['utm_content'];
    $_SESSION['utm_campaign'] = (isset($_GET['utm_campaign'])) ? $_GET['utm_campaign'] : $_SESSION['utm_campaign'];
    $_SESSION['utm_term'] = (isset($_GET['utm_term'])) ? $_GET['utm_term'] : $_SESSION['utm_term'];
    $_SESSION['utm_gclid'] = (isset($_GET['gclid'])) ? $_GET['gclid'] : $_SESSION['utm_gclid'];
    $_SESSION['utm_make'] = (isset($_GET['utm_make'])) ? $_GET['utm_make'] : $_SESSION['utm_make'];
    $_SESSION['utm_model'] = (isset($_GET['utm_model'])) ? $_GET['utm_model'] : $_SESSION['utm_model'];
    $_SESSION['utm_category'] = (isset($_GET['utm_category'])) ? $_GET['utm_category'] : $_SESSION['utm_category'];
    $_SESSION['utm_price'] = (isset($_GET['utm_price'])) ? $_GET['utm_price'] : $_SESSION['utm_price'];
    $_SESSION['utm_vid'] = (isset($_GET['utm_vid'])) ? $_GET['utm_vid'] : $_SESSION['utm_vid'];

    // Reset the branch.
    if ($pageUrl === 'in/reset') {
        unset($_SESSION['areaBranch']);
        unset($_SESSION['areaBranchId']);
        unset($_SESSION['areaId']);
        unset($_SESSION['area']);
        unset($_SESSION['areaSuffix']);
        wp_redirect('/');
        exit;
    }

    if ($post) {
        if ($post->post_type === 'carmodel') {
            $carmodel = $post;
            if ($parent = get_post($post->post_parent)) {
                $carmake = $parent;
            }
        }
        if ($post->post_type === 'carmake') {
            $carmake = $post;
        }
    }

    $custom = get_post_custom($post->ID);
    $areaSuffix = '';

    if (get_query_var('make_name_slug') === 'in') {
        $areaSlug = get_query_var('model_name_slug');
    } else {
        $areaSlug = get_query_var('area');
    }

    // Backup method of getting it.
    /*$areaCheck = explode('/in/', $wp->request);
    if (isset($areaCheck[1])) {
        $areaSlug = $areaCheck[1];
    }*/

    if (isset($wp_query->queried_object->taxonomy) && $wp_query->queried_object->taxonomy === 'areas') {
        // We are on the area
        $area = $wp_query->queried_object;
    } elseif (isset($areaSlug)) {
        $area = get_term_by('slug', sanitize_text_field($areaSlug), 'areas');
    }

    if ($area) {
        $args = [
            'fields' => 'ids',
            'post_type' => ['branch'],
            'posts_per_page' => '-1',
            'tax_query' => [
                [
                    'taxonomy' => 'areas',
                    'field' => 'slug',
                    'terms' => $area->slug
                ],
            ]
        ];

        $branches = new WP_Query($args);
        if ($branches->have_posts()) {
            $branchId = $branches->next_post();
            $branch = get_post($branchId);
            $_SESSION['areaBranch'] = $branch->post_title;
            $_SESSION['areaBranchId'] = $branch->ID;
        }

        $_SESSION['areaId'] = $area->term_id;
        $_SESSION['area'] = $area->name;
        $_SESSION['areaSuffix'] = '/in/' . $area->slug;
    }

    if (isset($_SESSION['areaSuffix'])) {
        $areaSuffix = $_SESSION['areaSuffix'];
    }

    if (isset($_SESSION['areaBranchId'])) {
        $branch = get_post($_SESSION['areaBranchId']);
        $branchCustom = get_post_custom($_SESSION['areaBranchId']);
    }

    /*if (isset($_SESSION['areaId'])) {
        var_dump($_SESSION['areaId']);
        var_dump($_SESSION['area']);
        var_dump($_SESSION['areaSuffix']);
    }*/

    $tertiaryPage = false;
    $tertiaryBanner = '';
    $tertiaryBannerMobile = '';
    if (isset($custom['tertiary_page']) && $custom['tertiary_page'][0] === '1') {
        $tertiaryPage = true;
        $tertiaryBanner = $custom['tertiary_banner'][0] ? $custom['tertiary_banner'][0] : '';
        $tertiaryBannerMobile = $custom['tertiary_banner_mobile'][0] ? $custom['tertiary_banner_mobile'][0] : '';
    }
}

add_action('template_redirect', 'cns_template_redirect');

function set_posts_per_page($query)
{
    global $wp_the_query;

    if ((!is_admin()) && ($query === $wp_the_query) && ($query->is_search())) {
        // $query->set('posts_per_page', 3);
    } elseif ((!is_admin()) && ($query === $wp_the_query) && ($query->is_archive())) {
        $query->set('posts_per_page', 9);
    }
    // Etc..

    return $query;
}

add_action('pre_get_posts', 'set_posts_per_page');

function cns_template_include($template)
{
    global $templateName;
    //var_dump(is_page());die;
    //echo $templateName;
    //die;
    $templateName = $template;
    return $template;
}

add_filter('template_include', 'cns_template_include');

function cns_category_single_template($template)
{
    $categorySlugs = [];
    foreach (get_the_category() as $cat) {
        $categorySlugs[] = $cat->slug;
    }
    if (in_array('news', $categorySlugs)) {
        return get_template_directory() . '/single-news.php';
    }
    return $template;
}

add_filter('single_template', 'cns_category_single_template');


function advanced_search_query($query)
{
    if ($query->is_search()) {
        if (isset($_GET['support'])) {
            $childCategories = get_categories(
                ['child_of' => 40]
            );
            $categories = [40];
            foreach ($childCategories as $category) {
                $categories[] = $category->cat_ID;
            }
            $query->set('category__in', $categories);
        }
        // tag search
        //if (isset($_GET['taglist']) && is_array($_GET['taglist'])) {
        //    $query->set('tag_slug__and', $_GET['taglist']);
        //}

        return $query;
    }
}

add_action('pre_get_posts', 'advanced_search_query', 1000);


function cns_setup_options () {
}

add_action('after_switch_theme', 'cns_setup_options');

// + Cron jobs
/*function cns_deactivate()
{
    wp_clear_scheduled_hook('cns_cars_import_event');
}

function cns_activation()
{
    register_deactivation_hook(__FILE__, 'cns_deactivate');

    add_action('cns_cars_import_event', 'cns_cars_import');

    if (!wp_next_scheduled('cns_cars_import_event') && !wp_installing()) {
        $success = wp_schedule_event(time(), 'hourly', 'cns_cars_import_event');
        if ($success == false) {
            mail(get_bloginfo('admin_email'), 'Cron Message', 'Unable to schedule cron job.');
        }
    }
}

add_action('init', 'cns_activation');*/

function cns_cars_purge() {
    // Delete old records.
    $args = [
        'fields' => 'ids',
        'post_type' => ['car'],
        'posts_per_page' => '-1',
        /*'date_query' => [
            'column' => 'post_modified',
            'before' => '-5 minutes'
        ]*/
    ];

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $itemId = $query->next_post();
            $item = get_post($itemId);
            $log .= 'Deleting ' . $item->post_title . ' : ' . $itemId . "\r\n";
            wp_trash_post($item->ID);
        }
    }
    echo '<pre>' . $log . '</pre>';
}

function cns_cars_import()
{
    $apiKey = TC_API_KEY;
    $urlPrefix = TC_API_URL_PREFIX;
    $endPoint = '/api/Vehicles';
    $log = '';

    $JSONData = [];

    $curl = curl_init();

    curl_setopt_array(
        $curl,
        [
            CURLOPT_TIMEOUT => 3.0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $urlPrefix . $endPoint,
            // CURLOPT_HEADER => 1,
            // CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $apiKey
            ]
        ]
    );

    $response = curl_exec($curl);
    if ($response) {
        $arr = json_decode((string)$response);
    }

    curl_close($curl);

    $numCars = 0;

    foreach ($arr as $row) {
        $numCars++;
        if (stripos($row->Make, 'Mercedes') !== false) {
            $row->Make = 'Mercedes';
        }


        //$make = get_page_by_title($row->Make, OBJECT, 'carmake');

        /*if ($make) {
            $log .= 'Found ' . $row->Make . "\r\n";
            $makeId = $make->ID;
        } else {
            $log .= 'API import added new make: ' . $row->Make . "\r\n";

            $makeId = wp_insert_post(
                [
                    'post_type' => 'carmake',
                    'post_title' => wp_strip_all_tags($row->Make),
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_category' => '',
                    'post_author' => 1
                ]
            );
        }*/

        /*$model = get_page_by_title($row->Range, OBJECT, 'carmodel');

        if ($model) {
            $log .= 'Found ' . $row->Range . "\r\n";
            $modelId = $model->ID;
        } else {
            $log .= 'API import added new range: ' . $row->Make . ' ' . $row->Range . "\r\n";
            $modelId = wp_insert_post(
                [
                    'post_type' => 'carmodel',
                    'post_title' => wp_strip_all_tags($row->Range),
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_category' => '',
                    'post_parent' => $makeId,
                    'post_author' => 1
                ]
            );
            update_field('make', $makeId, $modelId);
        }*/

        /*$carApiData = [
            'title' => sprintf('%s %s %s', $row->Make, $row->Model, $row->RegistrationNumberWithSpaces),
            'make_slug' => str_slug($row->Make),
            'range_slug' => str_slug($row->Range),
            'slug' => str_slug(sprintf('%s %s %s', $row->Make, $row->Model, $row->RegistrationNumberWithSpaces))
        ];*/

        $existingBranch = get_posts(
            [
                'numberposts' => -1,
                'post_type' => 'branch',
                'meta_key' => 'api_name',
                'meta_value' => $row->Location
            ]
        );

        $existingCar = get_posts(
            [
                'numberposts' => -1,
                'post_type' => 'car',
                'meta_key' => 'reg_number',
                'meta_value' => $row->RegistrationNumber
            ]
        );

        $inArray = false;

        if (isset($JSONData[$existingBranch[0]->post_title])) {
            foreach ($JSONData[$existingBranch[0]->post_title] as $carData) {
                if ($carData['Model'] === $row->Range) {
                    $inArray = true;
                    break;
                }
            }
        }

        if (!$inArray) {
            $JSONData[$existingBranch[0]->post_title][] = [
                'make' => $row->Make,
                'make_slug' => sanitize_title($row->Make),
                'model' => $row->Range,
                'model_slug' => sanitize_title($row->Range)
            ];
            /*$JSONData[$existingBranch[0]->post_title][] = [
                'make' => ['id' => $modelId, 'label' => $row->Make],
                'model' => ['id' => $makeId, 'label' => $row->Range]
            ];*/
        }

        if (empty($existingCar)) {
            $log .= "Creating " . $row->RegistrationNumber . "\r\n";
            $carId = wp_insert_post(
                [
                    'post_type' => 'car',
                    'post_title' => wp_strip_all_tags($row->Model),
                    'post_content' => $row->Description,
                    'post_status' => 'publish',
                    'post_author' => 1
                ]
            );

            update_field('reg_number', $row->RegistrationNumber, $carId);
            update_field(
                'reg_number_with_space',
                $row->RegistrationNumberWithSpaces ?: $row->RegistrationNumber,
                $carId
            );
            update_field('reg_date', $row->RegistrationDate, $carId);
            //update_field('make', $makeId, $carId);
            update_field('make_name', $row->Make, $carId);
            update_field('make_name_slug', sanitize_title($row->Make), $carId);
            //update_field('model', '', $carId);
            update_field('model_name',$row->Range, $carId);
            update_field('model_name_slug', sanitize_title($row->Range), $carId);
            update_field('derivative', $row->Derivative, $carId);
            update_field('location', $existingBranch[0]->ID ? $existingBranch[0]->ID : '', $carId);
            //update_field('location_changed_date', $row->LocationChangedDate, $carId);
            //update_field('image_url', $row->ModelImageUri, $carId);
            update_field('rrp', $row->RRP, $carId);
            update_field('discount', $row->Discount, $carId);
            update_field('discounted_price', $row->DiscountedPrice, $carId);
            update_field('reserved', $row->Reserved, $carId);
            update_field('held', $row->Held, $carId);

            update_field('capid', $row->CapId, $carId);
            update_field('enginecapacity', $row->EngineCapacity, $carId);
            update_field('bodytype', $row->BodyType, $carId);
            update_field('transmission', $row->Transmission, $carId);
            update_field('fueltype', $row->FuelType, $carId);
            update_field('seats', $row->Seats, $carId);
            update_field('doors', $row->Doors, $carId);
            update_field('colour', $row->Colour, $carId);
            update_field('mileage', $row->Mileage, $carId);
            update_field(
                'title',
                sprintf('%s %s %s', $row->Make, $row->Model, $row->RegistrationNumberWithSpaces),
                $carId
            );
        } else {
            //$carPost = $ex;
            $carId = $existingCar[0]->ID;
            $log .= "Updating " . $row->RegistrationNumber . "\r\n";
            update_field('rrp', $row->RRP, $carId);
            update_field('discount', $row->Discount, $carId);
            update_field('discounted_price', $row->DiscountedPrice, $carId);
            update_field('reserved', $row->Reserved, $carId);
            update_field('held', $row->Held, $carId);

            update_field('derivative', $row->Derivative, $carId);
            update_field('capid', $row->CapId, $carId);
            update_field('enginecapacity', $row->EngineCapacity, $carId);
            update_field('bodytype', $row->BodyType, $carId);
            update_field('transmission', $row->Transmission, $carId);
            update_field('fueltype', $row->FuelType, $carId);
            update_field('seats', $row->Seats, $carId);
            update_field('doors', $row->Doors, $carId);
            update_field('colour', $row->Colour, $carId);
            update_field('mileage', $row->Mileage, $carId);

            wp_update_post(['ID' => $carId]);
        }
    }

    // Delete old records.
    $args = [
        'fields' => 'ids',
        'post_type' => ['car'],
        'posts_per_page' => '-1',
        'date_query' => [
            'column' => 'post_modified',
            'before' => '-5 minutes'
        ]
    ];

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $itemId = $query->next_post();
            $item = get_post($itemId);
            $log .= 'Deleting ' . $item->post_title . ' : ' . $itemId . "\r\n";
            wp_trash_post($item->ID);
        }
    }

    umask('0002');
    foreach ($JSONData as $location => $locationData) {
        $JSONExport = json_encode($locationData);
        file_put_contents(
            ABSPATH . 'JSON/' . strtolower(preg_replace("/[\s_]/", "-", $location)) . '.json',
            $JSONExport
        );
    }

    // FTP
    if (isset($_GET['import'])) {
        echo "<pre>";
        //echo json_encode($JSONData);
        echo $log;
        echo 'Total Cars: ' . $numCars;
        echo "</pre>";
    }
    mail(get_bloginfo('admin_email'), 'Cron Log', $log);
}

if (isset($_GET['purge'])) {
    cns_cars_purge();
    die;
}

if (isset($_GET['import'])) {
    cns_cars_import();
    die;
}
// - Cron jobs

function cns_theme_support()
{
    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    //add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_post_type_support('post', 'page-attributes');
    add_action(
        'rest_api_init',
        function () {
            register_rest_field(
                'post',
                'menu_order',
                [
                    'get_callback' => function ($object) {
                        if (!isset($object['menu_order'])) {
                            return 0;
                        }

                        return (int)$object['menu_order'];
                    },
                    'schema' => [
                        'type' => 'integer',
                    ]
                ]
            );
        }
    );

    register_nav_menus(
        [
            'header-menu' => __('Header Menu', 'theme'),
            'footer-menu' => __('Footer Bottom', 'theme'),
        ]
    );
}

add_action('after_setup_theme', 'cns_theme_support');

function cns_admin_init()
{
    add_editor_style('style-editor.css');

    add_settings_section(
        'cns_settings_section', // Section ID
        'Tradecentre Options', // Section Title
        'cns_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field(
        'cns_closing_hour_weekdays', // Option ID
        'Closing Hour Weekdays', // Label
        'cns_small_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_closing_hour_weekdays' // Should match Option ID
        )
    );

    add_settings_field(
        'cns_closing_hour_weekends', // Option ID
        'Closing Hour Weekends', // Label
        'cns_small_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_closing_hour_weekends' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Discount
        'cns_opening_desktop_override', // Option ID
        'Yellow Opening Message Desktop Override', // Label
        'cns_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_opening_desktop_override' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Discount
        'cns_opening_mobile_override', // Option ID
        'Yellow Opening Message Mobile Override', // Label
        'cns_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_opening_mobile_override' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Switch
        'cns_sale_mode', // Option ID
        'Sale Mode', // Label
        'cns_sale_mode_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_sale_mode' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Discount
        'cns_sale_discount', // Option ID
        'Sale Mode Discount Message', // Label
        'cns_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_sale_discount' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Switch
        'cns_special_offers', // Option ID
        'Show Special Offers', // Label
        'cns_special_offers_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_special_offers' // Should match Option ID
        )
    );

    add_settings_field( // Sale Mode Discount
        'cns_special_offers_header', // Option ID
        'Special Offers Header', // Label
        'cns_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'cns_settings_section', // Name of our section
        array( // The $args
            'cns_special_offers_header' // Should match Option ID
        )
    );

    /*add_settings_field( // Option 2
        'option_2', // Option ID
        'Option 2', // Label
        'cns_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'cns_settings_section', // Name of our section (General Settings)
        array( // The $args
            'option_2' // Should match Option ID
        )
    );*/

    register_setting('general', 'cns_closing_hour_weekends', 'esc_attr');
    register_setting('general', 'cns_closing_hour_weekdays', 'esc_attr');
    register_setting('general', 'cns_opening_desktop_override', 'esc_attr');
    register_setting('general', 'cns_opening_mobile_override', 'esc_attr');
    register_setting('general', 'cns_sale_mode', 'esc_attr');
    register_setting('general', 'cns_sale_discount', 'esc_attr');
    register_setting('general', 'cns_special_offers', 'esc_attr');
    register_setting('general', 'cns_special_offers_header', 'esc_attr');
}

add_action('admin_init', 'cns_admin_init');

function cns_sale_mode_callback($args)
{
    $option = get_option($args[0]);

    $choices = [
        LISTING_NORMAL_MODE => 'Normal',
        LISTING_SALE_MODE => 'Sale',
        LISTING_FROM_MODE => 'From Price'
    ];

    echo '<select id="' . $args[0] . '" name="' . $args[0] . '">';
    foreach ($choices as $k => $v) {
        echo '<option value="' . $k . '" ' . selected($k, $option) . '>' . $v . '</option>';
    }
    echo '</select>';
}

function cns_special_offers_callback($args)
{
    $option = get_option($args[0]);

    $choices = [
        SPECIAL_OFFERS_OFF => 'Off',
        SPECIAL_OFFERS_ON => 'On'
    ];

    echo '<select id="' . $args[0] . '" name="' . $args[0] . '">';
    foreach ($choices as $k => $v) {
        echo '<option value="' . $k . '" ' . selected($k, $option) . '>' . $v . '</option>';
    }
    echo '</select>';
}

function cns_section_options_callback()
{ // Section Callback
    echo '<p>You can put the site into sale mode here.</p>';
}

function cns_checkbox_callback($args)
{  // Checkbox Callback
    $option = get_option($args[0]);
    echo '<input type="checkbox" id="' . $args[0] . '" name="' . $args[0] . '" value="1" ' . checked(
            1,
            $option,
            false
        ) . ' />';
}

function cns_textbox_callback($args)
{  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="' . $args[0] . '" name="' . $args[0] . '" value="' . $option . '" size="100" />';
}

function cns_small_textbox_callback($args)
{  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="' . $args[0] . '" name="' . $args[0] . '" value="' . $option . '" size="10" />';
}

function load_stylesheets()
{
    wp_register_style(
        'bootstrap',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css',
        [],
        '4.0.0',
        'all'
    );
    wp_enqueue_style('bootstrap');
    wp_register_style(
        'owlcarousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        [],
        '4.0.0',
        'all'
    );
    wp_enqueue_style('owlcarousel');
    wp_register_style(
        'fontawesome',
        get_stylesheet_directory_uri() . '/includes/fontawesome-pro-5.15.3/css/all.min.css',
        [],
        '5.15.3',
        'all'
    );
    wp_enqueue_style('fontawesome');
    wp_register_style(
        'main',
        get_template_directory_uri() . '/style.css',
        [],
        false,
        'all'
    );
    wp_enqueue_style('main');
    wp_enqueue_style('tcw');
    wp_register_style(
        'tcw',
        get_template_directory_uri() . '/tradecentrewales.css',
        [],
        '21-07-21',
        'all'
    );
    wp_enqueue_style('tcw');
}

add_action('wp_enqueue_scripts', 'load_stylesheets');

function load_javascript()
{
    wp_deregister_script('jquery');
    wp_register_script(
        'jquery',
        'https://code.jquery.com/jquery-3.4.1.min.js',
        [],
        '3.4.1',
        true
    );
    wp_enqueue_script('jquery');
    wp_deregister_script('jquerywaypoints');
    wp_register_script(
        'jquerywaypoints',
        'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js',
        [],
        '4.0.1',
        true
    );
    wp_enqueue_script('jquerywaypoints');
    wp_deregister_script('popper');
    wp_register_script(
        'popper',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        [],
        '1.12.9',
        true
    );
    wp_enqueue_script('popper');
    wp_deregister_script('bootstrap');
    wp_register_script(
        'bootstrap',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        [],
        '4.0.0',
        true
    );
    wp_enqueue_script('bootstrap');
    wp_deregister_script('trustpilot');
    wp_register_script(
        'trustpilot',
        'https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js',
        [],
        '5.0.0',
        true
    );
    wp_enqueue_script('trustpilot');
    wp_deregister_script('axios');
    wp_register_script(
        'axios',
        'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
        [],
        '0.19.2',
        true
    );
    wp_enqueue_script('axios');
    wp_deregister_script('qs');
    wp_register_script(
        'qs',
        'https://cdnjs.cloudflare.com/ajax/libs/qs/6.9.4/qs.min.js',
        [],
        '6.9.4',
        true
    );
    wp_enqueue_script('qs');
    wp_deregister_script('tabslider');
    wp_register_script(
        'tabslider',
        get_template_directory_uri() . '/js/components/tabslider.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('tabslider');
    wp_deregister_script('contenttabs');
    wp_register_script(
        'contenttabs',
        get_template_directory_uri() . '/js/components/contenttabs.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('contenttabs');
    wp_deregister_script('owlcarousel');
    wp_register_script(
        'owlcarousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        [],
        '2.3.4',
        true
    );
    wp_enqueue_script('owlcarousel');
    wp_deregister_script('imageSlider');
    wp_register_script(
        'imageSlider',
        get_template_directory_uri() . '/js/components/imageSlider.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('imageSlider');
    /*wp_deregister_script('carlisting');
    wp_register_script(
        'carlisting',
        get_template_directory_uri() . '/js/components/carlisting.js',
        [],
        '16-04-21.1',
        true
    );
    wp_enqueue_script('carlisting');*/
    wp_deregister_script('carsearch');
    wp_register_script(
        'carsearch',
        get_template_directory_uri() . '/js/components/carsearch.js',
        [],
        '20-05-21.1',
        true
    );
    wp_enqueue_script('carsearch');
    /*wp_deregister_script('quantcast');
    wp_register_script(
        'quantcast',
        get_template_directory_uri() . '/js/components/quantcastcookies.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('quantcast');*/
    wp_deregister_script('pxval');
    wp_register_script(
        'pxval',
        get_template_directory_uri() . '/js/components/pxval.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('pxval');
    wp_deregister_script('gmaps');
    wp_register_script(
        'gmaps',
        get_template_directory_uri() . '/js/components/gmaps.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('gmaps');
    /*
    wp_deregister_script('videos');
    wp_register_script(
        'videos',
        get_template_directory_uri() . '/js/components/videos.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('videos');
    */
    /*wp_deregister_script('tchooks');
    wp_register_script(
        'tchooks',
        get_template_directory_uri() . '/js/components/tchooks.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('tchooks');*/
    wp_deregister_script('site');
    wp_register_script(
        'site',
        get_template_directory_uri() . '/js/site.js',
        [],
        '1.0',
        true
    );
    wp_enqueue_script('site');
    wp_localize_script(
        'site',
        'wpApiSettings',
        [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
        ]
    );
}

add_action('wp_enqueue_scripts', 'load_javascript');

if (isset($_GET['flush'])) {
    flush_rewrite_rules();
}
