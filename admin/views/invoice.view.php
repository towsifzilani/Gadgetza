<?php require 'header.php'; ?>

    <div class="container mt-4">
            
            <div class="row d-print-none">
                <div class="col-6"><a class="btn btn-secondary" onclick="window.history.back()"><?= _BACKTEXT; ?></a></div>
                <div class="col-6 text-right"><a class="btn btn-secondary" onclick="window.print();"><?= _PRINTTEXT; ?></a></div>
            </div>

            <div class="card p-5 mt-4 rounded">

            <div class="row d-flex align-items-center">
                <div class="col-6 text-left"><div class="w-50"><img class="mw-100" src="<?php echo $target_dir . $theme['th_logo']; ?>"></div></div>
                <div class="col-6 text-right"><h4 class="font-weight-bold m-0"><?= _INVOICETEXT; ?></h4></div>
            </div>

            <hr class="mt-1 mb-1">

            <div class="row d-flex align-items-center">
                <div class="col-6 text-left"><?= _INVOICEDATE; ?> <?php echo formatDate($itemDetails['payment_date']); ?></div>
                <div class="col-6 text-right"><?= _INVOICEID; ?> <?php echo echoOutput($settings['st_billing_invoice_prefix']); ?><?php echo echoOutput($itemDetails['payment_id']); ?></div>
            </div>

            <hr class="mt-1 mb-1">

            <div class="row">
                <div class="col-6 text-left">

                <p class="m-0 font-weight-bold"><?= _INVOICEPAYTO; ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_company']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_address']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_postal']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_city']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_country']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_phone']); ?></p>
                <p class="m-0"><?php echo echoOutput($settings['st_billing_vat']); ?></p>

                </div>
                <div class="col-6 text-right">

                <p class="m-0 font-weight-bold"><?= _INVOICEINVOICETO; ?></p>
                <?php if((!empty($userBilling->user_billing_company))): ?>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_company : $userBilling->user_billing_name)); ?></p>
                <?php endif; ?>
                <?php if((empty($userBilling->user_billing_company))): ?>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_name : $itemDetails['user_name'])); ?></p>
                <?php endif; ?>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_address : null)); ?></p>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_zip : null)); ?></p>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_city : null)); ?></p>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_country : $itemDetails['user_country'])); ?></p>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_phone : null)); ?></p>
                <p class="m-0"><?php echo echoOutput((!empty($userBilling) ? $userBilling->user_billing_tax_id : null)); ?></p>

                </div>
            </div>

            <div class="mt-5">

            <table class="table">
    <thead>
        <tr>
            <th><?= _INVOICEDESCRIPTION; ?></th>
            <th class="text-right"></th>
            <th class="text-right"><?= _INVOICEAMOUNT; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo echoOutput($itemDetails['plan_title']); ?> <span>(<?php echo get_frequency_text($itemDetails['payment_frequency']); ?>)</span></td>
            <td class="text-right"></td>
            <td class="text-right"><?php echo echoOutput($itemDetails['payment_base_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right"><?= _INVOICESUBTOTAL; ?></td>
            <td class="text-right"><?php echo echoOutput($itemDetails['payment_base_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php if(!empty($itemDetails['payment_code'])): ?>
        <tr>
            <td></td>
            <td class="text-right"><?php echo echoOutput($itemDetails['payment_code']); ?> (<?php echo echoOutput($itemDetails['code_discount']); ?>% Discount)</td>
            <td class="text-right">-<?php echo calc_taxes_by_price($itemDetails['payment_base_amount'], $itemDetails['code_discount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php endif; ?>

        <?php if(!empty($itemDetails['payment_taxes'])): ?>

        <?php foreach($taxes as $tax): ?>
        <tr>
            <td></td>
            <td class="text-right"><?php echo $tax['tax_title']; ?> (<?php echo $tax['tax_percentage']; ?>% <?php echo ($tax['tax_type'] == 'exclusive' ? 'excl.' : 'incl.'); ?>)</td>
            <td class="text-right"><?php echo ($tax['tax_type'] == 'exclusive' ? '+' : null); ?><?php echo calc_taxes_by_price($itemDetails['payment_base_amount'], $tax['tax_percentage']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
        <?php endforeach; ?>

        <?php endif; ?>

        <tr>
            <td></td>
            <td class="text-right font-weight-bold"><?= _INVOICETOTAL; ?></td>
            <td class="text-right font-weight-bold"><?php echo echoOutput($itemDetails['payment_total_amount']); ?> <?php echo echoOutput($itemDetails['payment_currency']); ?></td>
        </tr>
    </tbody>
</table>

            </div>

            </div>

        </div>

<?php require 'footer.php'; ?>
