<?php

/**
 * The tertiary page template file
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $title, $noBranch;
$title = $post->post_title . ' | ' . get_bloginfo('name');

get_header();
?>
    <section class="container-fluid | tertiarypage contactus mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <h1 class="text-left"><?php echo $post->post_title; ?></h1>
                    <p><?php echo $post->post_content; ?></p>
                </div>
            </div>
        </div>
    </section>
<?php
if (!isset($noBranch) || $noBranch == false) {
    get_template_part('template-parts/branch-locations', 'front-page');
}
get_footer();
