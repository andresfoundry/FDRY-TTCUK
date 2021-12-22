<?php
global $branch;
?>
<div class="d-md-none sticky-mobile-footer">
    <div class="container-fluid d-block d-xs-block d-sm-block d-md-none d-lg-none d-xl-none | sticky-mobile-footer__buttons">
        <div class="row">
            <div class="col list-group | sticky-mobile-footer__button--left">
                <a href="#clickcollect" id="link--px-valuation">PX<br>Valuation</a>
            </div>

            <div class="col | sticky-mobile-footer__button--middle">
                <a href="#" id="link--locations">
                    <?php if (isset($branch)) : ?>
                    Directions &amp; Opening Times
                    <?php else : ?>
                    Locations
                    <br><i class="fas fa-map-marked-alt"></i>
                    <?php endif; ?>
                </a>
            </div>

            <div class="col list-group | sticky-mobile-footer__button--right">
                <a href="#freefinance" id="link--ffc">Free Finance Check</a>
            </div>
        </div>
    </div>
</div>