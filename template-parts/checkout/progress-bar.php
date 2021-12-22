<?php

global $make_name, $model_name, $carImage, $type, $step_id, $carId;

if (!isset($_SESSION['checkoutSteps']) || $step_id == 1) {
    if ($type === 'cash') {
        $_SESSION['checkoutSteps'] = [
            ['step_id' => 1, 'label' => 'Personal Details'],
            ['step_id' => 2, 'label' => 'Your Appointment'],
            ['step_id' => 'complete', 'label' => 'Confirmation'],
        ];
    } elseif ($type === 'finance') {
        $_SESSION['checkoutSteps'] = [
            ['step_id' => 1, 'label' => 'Finance Check'],
            ['step_id' => 2, 'label' => 'Eligibility'],
            ['step_id' => 'complete', 'label' => 'Confirmation'],
        ];
    } elseif ($type === 'bespoke') {
        $_SESSION['checkoutSteps'] = [
            ['step_id' => 1, 'label' => 'Personal Details'],
            ['step_id' => 'complete', 'label' => 'Confirmation'],
        ];
    }
}
?>
<div class="progress__bar">
    <div class="container">
        <div class="row">
            <?php
            $steps = count($_SESSION['checkoutSteps']) - 1;
            $col = '4';
            if ($steps == 1) {
                $col = '6';
            }
            foreach ($_SESSION['checkoutSteps'] as $i => $checkoutStep) :
                $pointerClasses = '';
                //var_dump([$step_id, $checkoutStep['step_id']]);
                //die;
                if ($step_id == $checkoutStep['step_id']) {
                    $pointerClasses = 'pointer__icon--selected';
                }
                $colClasses = '';
                if ($i === $steps) {
                    $colClasses = 'justify-content-end';
                } elseif ($i !== 0) {
                    $colClasses = 'justify-content-center';
                }
            ?>
                <div class="col-<?php echo $col; ?> d-flex align-items-start <?php echo $colClasses; ?>">
                    <img class="pointer__icon <?php echo $pointerClasses; ?>" src="<?php
                    echo get_stylesheet_directory_uri() . '/images/marker-medium.svg' ?>" height="32px"/>
                    &nbsp;<?php echo $checkoutStep['label'] ?>
                </div>
            <?php
            endforeach;
            ?>
            <div class="col-12">
                <hr/>
            </div>
        </div>
    </div>
</div>