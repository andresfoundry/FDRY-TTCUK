<?php

/**
 * Careers Category Page
 *
 * @package CNS
 * @subpackage TradeCentreWales Click & Collect
 * @since 1.0
 * @version 1.0
 */

global $tertiaryPage, $tertiaryBanner, $greyBackground, $title;
$tertiaryBanner = '/images/news.jpg';
$tertiaryPage = true;
$greyBackground = true;

$title = 'News from ' . get_bloginfo('name');

$url = 'https://isw.changeworknow.co.uk/the_trade_centre/vms/e/careers/search.rss';
$log = '';

$curl = curl_init();

curl_setopt_array(
    $curl,
    [
        CURLOPT_TIMEOUT => 3.0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
    ]
);

$response = curl_exec($curl);

$xml = new SimpleXMLElement($response);
$jobLocations = ['Mountain Ash', 'Neath', 'Merthyr'];
$jobs = [];
foreach ($xml->channel->item as $item) {
    foreach ($jobLocations as $location) {
        if (stripos($item->description, $location)) {
            $jobs[] = [
                'title' => (string)$item->title,
                'description' => (string)$item->description . '...',
                'pub_date' => strtotime((string)$item->pub_date),
                'link' => (string)$item->link,
            ];
            break;
        }
    }
}

get_header(); ?>
    <section class="container-fluid | tertiarypage careers">
        <div class="container pb-3">
            <h1 class="text-left">Careers</h1>
            <div class="row pb-5">
                <?php
                if (count($jobs) > 0) :
                    foreach ($jobs as $job) :
                        ?>
                        <div class="col-12 col-md-6 col-xl-4 mb-4 px-3">
                            <div class="col py-3 px-4 border | careersitem">
                                <div>
                                    <h4><a href="<?php echo $job['link']; ?>"><?php echo limit_words($job['title'], 10) ?></a></h4>
                                    <span><i class="fa fa-calendar-alt"></i> <?php echo date('jS F Y', $job['pub_date']); ?></span><br/>
                                    <hr/>
                                    <div class="careersdescription"><?php echo $job['description']; ?></div>
                                </div>
                                <a class="c-button--blue" href="<?php echo $job['link']; ?>">READ MORE <i
                                            class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <div class="col">
                        <h4>Sorry, no jobs available right now.</h4>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </section>
<?php
get_footer();
