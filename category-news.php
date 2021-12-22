<?php

/**
 * News Category Page
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $tertiaryPage, $tertiaryBanner, $tertiaryBannerMobile, $title;
$tertiaryBanner = '/images/news.jpg';
$tertiaryBannerMobile = '/images/news-mob.jpg';
$tertiaryPage = true;

$title = 'News from ' . get_bloginfo('name');

get_header(); ?>
    <section class="container-fluid | tertiarypage news">
        <div class="container pb-3">
            <h1 class="text-left">News &amp; Events</h1>
            <div class="row pb-5">
                <?php while (have_posts()) : the_post(); ?>
                <div class="col-12 col-md-6 col-lg-4 pb-3">
                    <div class="col p-0 border mb-2 | newsitem">
                        <a class="imagecontainer" href="<?php the_permalink(); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" />
                        </a>
                        <div class="px-3">
                            <h4><a href="<?php the_permalink(); ?>"><?php echo limit_words($post->post_title, 15) ?></a></h4>
                            <span><i class="fa fa-calendar-alt"></i> <?php echo date('jS F Y', strtotime($post->post_date)); ?></span><br/>
                            <hr/>
                            <p><?php echo limit_words($post->post_excerpt, 20); ?></p>
                            <a class="c-button--blue" href="<?php the_permalink(); ?>">READ MORE <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
               <?php endwhile; ?>
            </div>
            <div class="row">
                <div class="col-12"><?php cns_pagination(); ?></div>
            </div>
        </div>
    </section>
<?php
get_footer();
