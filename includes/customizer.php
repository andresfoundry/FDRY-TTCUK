<?php

// Telephone numbers.
add_action('customize_register', 'cns_customize_register');
function cns_customize_register($wp_customize)
{
    $wp_customize->add_section(
        'cns_sliders',
        array(
            'title' => __('Sliders', 'cns'),
            'priority' => 20
        )
    );

    $wp_customize->add_setting('mobile_slider');
    $wp_customize->add_control(
        'mobile_slider',
        array(
            'id' => 'mobile_slider',
            'label' => __('Mobile:', 'cns'),
            'section' => 'cns_sliders'
        )
    );

    $wp_customize->add_setting('desktop_slider');
    $wp_customize->add_control(
        'desktop_slider',
        array(
            'id' => 'desktop_slider',
            'label' => __('Desktop:', 'cns'),
            'section' => 'cns_sliders'
        )
    );

    $wp_customize->add_panel(
        'cns_banners',
        array(
            'title' => __('Banners', 'cns'),
            'priority' => 50,
        )
    );

    $wp_customize->add_section(
        'cns_banners_front_page',
        array(
            'title' => __('Front Page', 'cns'),
            'priority' => 20,
            'panel' => 'cns_banners'
        )
    );

    $wp_customize->add_setting('top_banner_mobile_front_page');
    $wp_customize->add_control(
        'top_banner_mobile_front_page',
        array(
            'id' => 'top_banner_mobile_front_page',
            'label' => __('Front Page Top Mobile:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('top_banner_desktop_front_page');
    $wp_customize->add_control(
        'top_banner_desktop_front_page',
        array(
            'id' => 'top_banner_desktop_front_page',
            'label' => __('Front Page Top Desktop:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_mobile_front_page');
    $wp_customize->add_control(
        'banner_mobile_front_page',
        array(
            'id' => 'banner_mobile_front_page',
            'label' => __('Front Page Header Mobile:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_desktop_front_page');
    $wp_customize->add_control(
        'banner_desktop_front_page',
        array(
            'id' => 'banner_desktop_front_page',
            'label' => __('Front Page Header Desktop:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_sdm_mobile_front_page');
    $wp_customize->add_control(
        'banner_sdm_mobile_front_page',
        array(
            'id' => 'banner_sdm_mobile_front_page',
            'label' => __('Front Page SDM Mobile:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_sdm_desktop_front_page');
    $wp_customize->add_control(
        'banner_sdm_desktop_front_page',
        array(
            'id' => 'banner_sdm_desktop_front_page',
            'label' => __('Front Page SDM Desktop:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_break_mobile_front_page');
    $wp_customize->add_control(
        'banner_break_mobile_front_page',
        array(
            'id' => 'banner_break_mobile_front_page',
            'label' => __('Front Page Break Mobile:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_setting('banner_break_desktop_front_page');
    $wp_customize->add_control(
        'banner_break_desktop_front_page',
        array(
            'id' => 'banner_break_desktop_front_page',
            'label' => __('Front Page Break Desktop:', 'cns'),
            'section' => 'cns_banners_front_page'
        )
    );

    $wp_customize->add_section(
        'cns_banners_warranties_page',
        array(
            'title' => __('Warranties', 'cns'),
            'priority' => 20,
            'panel' => 'cns_banners'
        )
    );

    $wp_customize->add_setting('banner_mobile_warranties_page');
    $wp_customize->add_control(
        'banner_mobile_warranties_page',
        array(
            'id' => 'banner_mobile_warranties_page',
            'label' => __('Warranties Mobile:', 'cns'),
            'section' => 'cns_banners_warranties_page'
        )
    );

    $wp_customize->add_setting('banner_desktop_warranties_page');
    $wp_customize->add_control(
        'banner_desktop_warranties_page',
        array(
            'id' => 'banner_desktop_warranties_page',
            'label' => __('Warranties Desktop:', 'cns'),
            'section' => 'cns_banners_warranties_page'
        )
    );

    $wp_customize->add_section(
        'cns_banners_finance_page',
        array(
            'title' => __('Finance', 'cns'),
            'priority' => 20,
            'panel' => 'cns_banners'
        )
    );

    $wp_customize->add_setting('banner_mobile_finance_page');
    $wp_customize->add_control(
        'banner_mobile_finance_page',
        array(
            'id' => 'banner_mobile_finance_page',
            'label' => __('Finance Mobile:', 'cns'),
            'section' => 'cns_banners_finance_page'
        )
    );

    $wp_customize->add_setting('banner_desktop_finance_page');
    $wp_customize->add_control(
        'banner_desktop_finance_page',
        array(
            'id' => 'banner_desktop_finance_page',
            'label' => __('Finance Desktop:', 'cns'),
            'section' => 'cns_banners_finance_page'
        )
    );
}