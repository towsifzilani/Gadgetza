
    <div class="uk-section-small">
        <div class="uk-container uk-container-small">
            
            <div class="uk-grid-small uk-margin-small-bottom uk-print-none" uk-grid>
                <div class="uk-width-1-2 uk-text-left"><a class="uk-button uk-button-secondary uk-border-rounded uk-text-capitalize" onclick="window.history.back()"><?php echo echoOutput($translation['tr_396']); ?></a></div>
                <div class="uk-width-1-2 uk-text-right"><a class="uk-button uk-button-primary uk-border-rounded uk-text-capitalize" onclick="window.print();"><?php echo echoOutput($translation['tr_397']); ?></a></div>
            </div>

            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

            <div class="uk-grid-small uk-margin-small-bottom uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-1-2 uk-text-left"><img class="inv-logo" src="<?php echo $urlPath->image($theme['th_logo']); ?>"></div>
                <div class="uk-width-1-2 uk-text-right"><h3 class="uk-text-bold uk-maring-remove"><?php echo echoOutput($translation['tr_398']); ?></h3></div>
            </div>

            <hr class="uk-margin-small">

            <div class="uk-grid-small uk-margin-small-bottom uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-1-2 uk-text-left"><?php echo echoOutput($translation['tr_399']); ?> <?php echo formatDate($itemDetails['payment_date']); ?></div>
                <div class="uk-width-1-2 uk-text-right"><?php echo echoOutput($translation['tr_400']); ?> <?php echo echoOutput($settings['st_billing_invoice_prefix']); ?><?php echo echoOutput($itemDetails['payment_id']); ?></div>
            </div>

            <hr class="uk-margin-small">

            <div class="uk-grid-small uk-margin-small-bottom" uk-grid>
                <div class="uk-width-1-2 uk-text-left">

                <p class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_401']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_company']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_address']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_postal']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_city']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_country']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_phone']); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput($settings['st_billing_vat']); ?></p>

                </div>
                <div class="uk-width-1-2 uk-text-right">

                <p class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_402']); ?></p>
                <?php if((!empty($userBilling->user_billing_company))): ?>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_company : $userBilling->user_billing_name)); ?></p>
                <?php endif; ?>
                <?php if((empty($userBilling->user_billing_company))): ?>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_name : $itemDetails['user_name'])); ?></p>
                <?php endif; ?>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_address : null)); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_zip : null)); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_city : null)); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_country : $itemDetails['user_country'])); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_phone : null)); ?></p>
                <p class="uk-margin-remove"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_tax_id : null)); ?></p>

                </div>
            </div>

            <div class="uk-width-1-1 uk-margin-top">

            <table class="uk-table uk-table-divider uk-table-small uk-table-justify">
    <thead>
        <tr>
            <th><?php echo echoOutput($translation['tr_403']); ?></th>
            <th class="uk-text-right"></th>
            <th class="uk-text-right"><?php echo echoOutput($translation['tr_404']); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo echoOutput($itemDetails['plan_title']); ?> <span>(<?php echo getFrequencyText($itemDetails['payment_frequency']); ?>)</span></td>
            <td class="uk-text-right"></td>
            <td class="uk-text-right"><?php echo echoOutput($itemDetails['payment_base_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <tr>
            <td></td>
            <td class="uk-text-right"><?php echo echoOutput($translation['tr_406']); ?></td>
            <td class="uk-text-right"><?php echo echoOutput($itemDetails['payment_base_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php if(!empty($itemDetails['payment_code'])): ?>
        <tr>
            <td></td>
            <td class="uk-text-right"><?php echo echoOutput($itemDetails['payment_code']); ?> (<?php echo echoOutput($itemDetails['code_discount']); ?>% <?php echo echoOutput($translation['tr_405']); ?>)</td>
            <td class="uk-text-right">-<?php echo calcTaxesByPrice($itemDetails['payment_base_amount'], $itemDetails['code_discount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php endif; ?>

        <?php if(!empty($itemDetails['payment_taxes'])): ?>

        <?php foreach($taxes as $tax): ?>
        <tr>
            <td></td>
            <td class="uk-text-right"><?php echo $tax['tax_title']; ?> (<?php echo $tax['tax_percentage']; ?>% <?php echo ($tax['tax_type'] == 'exclusive' ? 'excl.' : 'incl.'); ?>)</td>
            <td class="uk-text-right"><?php echo ($tax['tax_type'] == 'exclusive' ? '+' : null); ?><?php echo calcTaxesByPrice($itemDetails['payment_base_amount'], $tax['tax_percentage']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php endforeach; ?>

        <?php endif; ?>

        <tr>
            <td></td>
            <td class="uk-text-right uk-text-bold"><?php echo echoOutput($translation['tr_407']); ?></td>
            <td class="uk-text-right uk-text-bold"><?php echo echoOutput($itemDetails['payment_total_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
    </tbody>
</table>

            </div>

            </div>

        </div>
    </div>