<?php

global $make_name, $model_name, $carImage, $carId;

$showCarDetails = true;
$col = 'col-12 col-md-auto';
if (!isset($_SESSION['checkout']['reserved']) || $_SESSION['checkout']['reserved'] == false) {
    $message = '<strong>Great news!</strong> Your car is ready to reserve';
} else {
    $message = '<strong>Even better news! </strong> Your ' . $make_name . ' ' . $model_name . ' is now reserved!';
    $col = 'col-12';
    $showCarDetails = false;
}
?>
<div class="top__ribbon py-3 mb-5">
    <div class="container">
        <div class="row px-3 px-md-0">
            <div class="<?php echo $col; ?> mb-3 mb-md-0 px-1">
                <button class="btn btn-ribbon w-100"><?php echo $message; ?></button>
            </div>
            <?php
            if ($showCarDetails) :
                ?>
            <div class="col-3 col-md-auto px-1">
                <img src="<?php
                echo $carImage; ?>" height="56px"/>
            </div>
            <div class="col-9 col-md-auto px-1 ribbon__cardetails">
                <h2><?php echo $make_name . ' ' . $model_name; ?></h2>
                <span><?php
                    echo get_field('derivative', $carId); ?></span>
            </div>
            <?php
            endif;
            ?>
            <!--<div class="col d-flex align-items-center justify-content-end text-right ribbon-close">
                <i class="fal fa-2x fa-window-close"></i>
            </div>-->
        </div>
    </div>
</div>
