<?php
/**
 * The archive template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
    <main class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12">
                <h1><?php single_cat_title(); ?></h1>
                <?php if (have_posts()) : while (have_posts()) :
                    the_post(); ?>

                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>
                <?php endwhile;
                endif; ?>
            </div>
        </div>
    </main>
<?php
get_footer();
