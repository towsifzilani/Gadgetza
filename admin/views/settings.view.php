<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<!--Page Container-->
<section class="page-container">
<div class="page-content-wrapper">

<!--Main Content-->

<div class="content sm-gutter">
<div class="container-fluid padding-25 sm-padding-10">
<div class="row">
<div class="col-12">
<div class="section-title">
  <h4><?php echo _SETTINGS; ?></h4> 
</div>
</div>

<div class="col-12 c-col-12">
<button class="btn btn-primary" type="submit" name="save" form="setSettings"><?php echo _SAVECHANGES; ?></button>
</div>


<div class="col-md-12">

<div class="block form-block mb-4" style="margin-top: 20px;">

  <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="setSettings">

    <div class="form-row">

      <div class="form-group col-md-12">

        <div class="table-responsive">

          <fieldset>
            <legend><?php echo _SITESETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _MAINTENANCEMODE; ?></label>

                  <select class="custom-select form-control" name="st_maintenance">
                    <?php
                      if($settings['st_maintenance'] == '1')
                      {
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }
                      else
                      {
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _LANGDIR; ?></label>
                  <select class="custom-select form-control" id="langdir" data-selected="<?php echo $settings['st_langdir']; ?>" name="st_langdir">
                    <option value="ltr">Left to Right (LTR)</option>
                    <option value="rtl">Right to Left (RTL)</option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _CURRENCYSYMBOL; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_currency']; ?>" name="st_currency" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _CURRENCYCODE; ?></label>
                
                    <select name="st_currencycode" id="currency-code" data-selected="<?php echo $settings['st_currencycode']; ?>" class="form-control">
                    <?php foreach($currenciesArray as $item => $value): ?>
                      <option value="<?php echo $item; ?>"><?php echo $item; ?> - <?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _CURRENCYPOSITION; ?></label>
                  <select class="custom-select form-control" id="currency-position" data-selected="<?php echo $settings['st_currencyposition']; ?>" name="st_currencyposition">
                    <option value="left"><?php echo $settings['st_currency']; ?>0.00</option>
                    <option value="right">0.00<?php echo $settings['st_currency']; ?></option>
                    <option value="left-space"><?php echo $settings['st_currency']; ?> 0.00</option>
                    <option value="right-space">0.00 <?php echo $settings['st_currency']; ?></option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DECIMALSEPARATOR; ?></label>
                  <select class="custom-select form-control" id="decimal-separator" data-selected="<?php echo $settings['st_decimalseparator']; ?>" name="st_decimalseparator">
                    <option value=".">100.11</option>
                    <option value=",">100,11</option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DECIMALNUMBER; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_decimalnumber']; ?>" name="st_decimalnumber" type="number">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DATEFORMAT; ?></label>
                  <select class="custom-select form-control" id="date-format" data-selected="<?php echo $settings['st_dateformat']; ?>" name="st_dateformat">
                    <option value="d/m/Y">DD/MM/YYYY</option>
                    <option value="m/d/Y">MM/DD/YYYY</option>
                    <option value="Y/m/d">YYYY/MM/DD</option>
                    <option value="d-m-Y">DD-MM-YYYY</option>
                    <option value="m-d-Y">MM-DD-YYYY</option>
                    <option value="Y-m-d">YYYY-MM-DD</option>
                    <option value="d.m.Y">DD.MM.YYYY</option>
                    <option value="m.d.Y">MM.DD.YYYY</option>
                    <option value="Y.m.d">YYYY.MM.DD</option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _TIMEZONE; ?></label>
                  <select class="custom-select form-control" id="timezone" data-selected="<?php echo $settings['st_timezone']; ?>" name="st_timezone">
                  <?php foreach($timezonesArray as $item => $value): ?>
                      <option value="<?php echo $item; ?>"><?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _AUTOAPPROVENEW; ?></label>
                  <select class="custom-select form-control" name="st_auto_approve_subsmission">
                  <?php
                      if($settings['st_auto_approve_subsmission'] == '1'){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0" >'._NOTEXT.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _AUTOAPPROVEUPDATED; ?></label>
                  <select class="custom-select form-control" name="st_auto_approve_update">
                  <?php
                      if($settings['st_auto_approve_update'] == '1'){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0" >'._NOTEXT.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _ENABLEREPORTFORM; ?></label>
                  <select class="custom-select form-control" name="st_enable_report_form">
                  <?php
                      if($settings['st_enable_report_form'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _ENABLECOOKIE; ?></label>
                  <select class="custom-select form-control" name="st_cookie_consent">
                  <?php
                      if($settings['st_cookie_consent'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _LOGINONLYVERIFIEDUSERS; ?></label>
                  <select class="custom-select form-control" name="st_login_verified_users_only">
                  <?php
                      if($settings['st_login_verified_users_only'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _ONLYREGISTEREDUSERS; ?></label>
                  <select class="custom-select form-control" name="st_access_registered_only">
                  <?php
                      if($settings['st_access_registered_only'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _ONLYREGISTEREDUSERSEXCLUSIVE; ?></label>
                  <select class="custom-select form-control" name="st_access_registered_only_exclusive">
                  <?php
                      if($settings['st_access_registered_only_exclusive'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DISABLEREGISTRATION; ?></label>
                  <select class="custom-select form-control" name="st_disable_registration">
                  <?php
                      if($settings['st_disable_registration'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _REQUIREEMAILVERIFICATION; ?></label>
                  <select class="custom-select form-control" name="st_verification_email">
                  <?php
                      if($settings['st_verification_email'] == '1'){
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _ONLYACTIVESUBSCRIPTIONSDUSERS; ?></label>
                  <select class="custom-select form-control" name="st_only_active_subscription">
                  <?php
                      if($settings['st_only_active_subscription'] == '1'){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0" >'._NOTEXT.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset id="pages">
            <legend><?php echo _DEFAULTPAGES; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _PAGESEARCH; ?></label>

                  <select class="custom-select form-control" name="st_defaultsearchpage">
                    <option value>-</option>
                    <?php
                    foreach($searchpages as $page)
                    {
                      if($settings['st_defaultsearchpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultsearchpage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGEPRIVACYPOLICY; ?></label>

                  <select class="custom-select form-control" name="st_defaultprivacypage">
                    <option value>-</option>
                    <?php
                    foreach($privacypages as $page)
                    {
                      if($settings['st_defaultprivacypage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultprivacypage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGETERMSCONDITIONS; ?></label>

                  <select class="custom-select form-control" name="st_defaulttermspage">
                    <option value>-</option>
                    <?php
                    foreach($termspages as $page)
                    {
                      if($settings['st_defaulttermspage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaulttermspage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGECATEGORIES; ?></label>

                  <select class="custom-select form-control" name="st_defaultcategoriespage">
                    <option value>-</option>
                    <?php
                    foreach($categoriespages as $page)
                    {
                      if($settings['st_defaultcategoriespage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultcategoriespage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGESTORES; ?></label>

                  <select class="custom-select form-control" name="st_defaultstorespage">
                    <option value>-</option>
                    <?php
                    foreach($storespages as $page)
                    {
                      if($settings['st_defaultstorespage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultstorespage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGECONTACT; ?></label>

                  <select class="custom-select form-control" name="st_defaultcontactpage">
                    <option value>-</option>
                    <?php
                    foreach($contactpages as $page)
                    {
                      if($settings['st_defaultcontactpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultcontactpage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAGELOCATIONS; ?></label>

                  <select class="custom-select form-control" name="st_defaultlocationspage">
                    <option value>-</option>
                    <?php
                    foreach($locationspages as $page)
                    {
                      if($settings['st_defaultlocationspage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultlocationspage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              
              <tr>  
                <td>
                  <label><?php echo _PAGEPRICING; ?></label>

                  <select class="custom-select form-control" name="st_defaultpricingpage">
                    <option value>-</option>
                    <?php
                    foreach($pricingpages as $page)
                    {
                      if($settings['st_defaultpricingpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultpricingpage'].'" selected="selected">'.$page['page_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>


            </table>
          </fieldset>

          <fieldset>
            <legend><?php echo _COMPANYINFO; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label>Facebook</label>
                  <input class="form-control" value="<?php echo $settings['st_facebook']; ?>" name="st_facebook" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Twitter</label>
                  <input class="form-control" value="<?php echo $settings['st_twitter']; ?>" name="st_twitter" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Youtube</label>
                  <input class="form-control" value="<?php echo $settings['st_youtube']; ?>" name="st_youtube" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Instagram</label>
                  <input class="form-control" value="<?php echo $settings['st_instagram']; ?>" name="st_instagram" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Linkedin</label>
                  <input class="form-control" value="<?php echo $settings['st_linkedin']; ?>" name="st_linkedin" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Whatsapp</label>
                  <input class="form-control" value="<?php echo $settings['st_whatsapp']; ?>" name="st_whatsapp" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLEPLAYLINK; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_googleplay_app']; ?>" name="st_googleplay_app" type="url" pattern="https://.*">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _APPSTORELINK; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_appstore_app']; ?>" name="st_appstore_app" type="url" pattern="https://.*">
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _SMTPEMAILS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _RECIPIENTEMAIL; ?>  <small style="display: block; margin-bottom: 8px; margin-top: 5px;"><?php echo _MESSAGERECIPIENTEMAIL; ?></small></label>
                  <input class="form-control" value="<?php echo $settings['st_recipientemail']; ?>" name="st_recipientemail" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPHOST; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtphost']; ?>" name="st_smtphost" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPUSER; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpemail']; ?>" name="st_smtpemail" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPPASSWORD; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtppassword']; ?>" name="st_smtppassword" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPENCRYPT; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpencrypt']; ?>" name="st_smtpencrypt" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPPORT; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpport']; ?>" name="st_smtpport" type="text">
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _GENERALSETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _ANALYTICSTRACKINGCODE; ?></label>
                  <textarea class="form-control mceNoEditor" name="st_analytics" type="text"><?php echo $settings['st_analytics']; ?></textarea>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLERECAPTCHAENABLE; ?></label>

                  <select class="custom-select form-control" name="st_recaptcha_enable">
                    <?php
                      if($settings['st_recaptcha_enable'] == '1'){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="0" >'._DISABLED.'</option>';
                    }else{
                      echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLERECAPTCHAKEY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_recaptchakey']; ?>" name="st_recaptchakey" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLERECAPTCHASECRETKEY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_recaptchasecretkey']; ?>" name="st_recaptchasecretkey" type="text">
                </td>
              </tr>

            </table>

          </fieldset>
 
          <fieldset>
            <legend><?php echo _BILLINGINFO; ?></legend>

            <table class="display table s-table">

            <tr>  
                <td colspan="2">
                  <label><?php echo _BILLINGCOMPANY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_company']; ?>" name="st_billing_company" type="text">
                </td>

                <td>
                  <label><?php echo _BILLINGINVOICEPREFIX; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_invoice_prefix']; ?>" name="st_billing_invoice_prefix" type="text">
                </td>

              </tr>

              <tr>  
                <td colspan="3">
                  <label><?php echo _BILLINGADDRESS; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_address']; ?>" name="st_billing_address" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _BILLINGCOUNTRY; ?></label>
                  <select class="custom-select form-control" id="countries" data-selected="<?php echo $settings['st_billing_country']; ?>" name="st_billing_country">
                  <?php foreach($countriesArray as $item => $value): ?>
                      <option value="<?php echo $item; ?>"><?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
                <td>
                  <label><?php echo _BILLINGCITY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_city']; ?>" name="st_billing_city" type="text">
                </td>
                <td>
                  <label><?php echo _BILLINGPOSTALCODE; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_postal']; ?>" name="st_billing_postal" type="text">
                </td>
              </tr>

              <tr>  
                <td colspan="2">
                  <label><?php echo _BILLINGPHONE; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_phone']; ?>" name="st_billing_phone" type="text">
                </td>

                <td>
                  <label><?php echo _BILLINGTAXID; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_billing_vat']; ?>" name="st_billing_vat" type="text">
                </td>

              </tr>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _PAYMENTS; ?></legend>

            <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link text-dark active" href="#" data-target="#1" data-toggle="tab"><?php echo _PAYPAL; ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#" data-target="#2" data-toggle="tab"><?php echo _STRIPE; ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#" data-target="#3" data-toggle="tab"><?php echo _RAZORPAY; ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#" data-target="#4" data-toggle="tab"><?php echo _PAYSTACK; ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#" data-target="#5" data-toggle="tab"><?php echo _MOLLIE; ?></a>
  </li>
</ul>

      <div class="tab-content mb-4">
			  <div class="tab-pane active border border-top-0 p-3 rounded" id="1">
        
            <table class="display table s-table">

            <tr>  
                <td>
                  <label><?php echo _PAYPALSTATUS; ?></label>

                  <select class="custom-select form-control" name="st_paypal_status">
                    <?php
                      if($settings['st_paypal_status'] == '1'){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="0" >'._DISABLED.'</option>';
                    }else{
                      echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAYPALSANDBOX; ?></label>

                  <select class="custom-select form-control" name="st_paypal_mode">
                    <?php
                      if($settings['st_paypal_mode'] == 'sandbox'){
                        echo '<option value="sandbox" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="live" >'._DISABLED.'</option>';
                      }else{
                        echo '<option value="live" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="sandbox">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAYPALCLIENTID; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_paypal_id']; ?>" name="st_paypal_id" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PAYPALSECRETKEY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_paypal_secret']; ?>" name="st_paypal_secret" type="text">
                </td>
              </tr>

            </table>

        </div>
			  <div class="tab-pane border border-top-0 p-3 rounded" id="2">
    

<table class="display table s-table">

<tr>  
    <td>
      <label><?php echo _STRIPESTATUS; ?></label>

      <select class="custom-select form-control" name="st_stripe_status">
        <?php
          if($settings['st_stripe_status'] == '1'){
          echo '<option value="1" selected="selected">'._ENABLED.'</option>';
          echo '<option value="0" >'._DISABLED.'</option>';
        }else{
          echo '<option value="0" selected="selected">'._DISABLED.'</option>';
          echo '<option value="1">'._ENABLED.'</option>';
        }
        ?>
      </select>
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _STRIPEKEY; ?></label>
      <input class="form-control" value="<?php echo $settings['st_stripe_key']; ?>" name="st_stripe_key" type="text">
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _STRIPESECRET; ?></label>
      <input class="form-control" value="<?php echo $settings['st_stripe_secret']; ?>" name="st_stripe_secret" type="text">
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _STRIPEWEBHOOK; ?></label>
      <input class="form-control" value="<?php echo $settings['st_stripe_webhook']; ?>" name="st_stripe_webhook" type="text">
    </td>
  </tr>

</table>
      

      </div>

			  <div class="tab-pane border border-top-0 p-3 rounded" id="3">
      
        <table class="display table s-table">

<tr>  
    <td>
      <label><?php echo _RAZORPAYSTATUS; ?></label>

      <select class="custom-select form-control" name="st_razorpay_status">
        <?php
          if($settings['st_razorpay_status'] == '1'){
          echo '<option value="1" selected="selected">'._ENABLED.'</option>';
          echo '<option value="0" >'._DISABLED.'</option>';
        }else{
          echo '<option value="0" selected="selected">'._DISABLED.'</option>';
          echo '<option value="1">'._ENABLED.'</option>';
        }
        ?>
      </select>
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _RAZORPAYKEY; ?></label>
      <input class="form-control" value="<?php echo $settings['st_razorpay_publickey']; ?>" name="st_razorpay_publickey" type="text">
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _RAZORPAYSECRET; ?></label>
      <input class="form-control" value="<?php echo $settings['st_razorpay_secretkey']; ?>" name="st_razorpay_secretkey" type="text">
    </td>
  </tr>

  <tr>  
    <td>
      <label><?php echo _RAZORPAYWEBHOOK; ?></label>
      <input class="form-control" value="<?php echo $settings['st_razorpay_webhook']; ?>" name="st_razorpay_webhook" type="text">
    </td>
  </tr>

</table>

      </div>


    <div class="tab-pane border border-top-0 p-3 rounded" id="4">
      
      <table class="display table s-table">

<tr>  
  <td>
    <label><?php echo _PAYSTACKSTATUS; ?></label>

    <select class="custom-select form-control" name="st_paystack_status">
      <?php
        if($settings['st_paystack_status'] == '1'){
        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
        echo '<option value="0" >'._DISABLED.'</option>';
      }else{
        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
        echo '<option value="1">'._ENABLED.'</option>';
      }
      ?>
    </select>
  </td>
</tr>

<tr>  
  <td>
    <label><?php echo _PAYSTACKKEY; ?></label>
    <input class="form-control" value="<?php echo $settings['st_paystack_public']; ?>" name="st_paystack_public" type="text">
  </td>
</tr>

<tr>  
  <td>
    <label><?php echo _PAYSTACKSECRET; ?></label>
    <input class="form-control" value="<?php echo $settings['st_paystack_secret']; ?>" name="st_paystack_secret" type="text">
  </td>
</tr>

</table>

    </div>

    <div class="tab-pane border border-top-0 p-3 rounded" id="5">
      
      <table class="display table s-table">

<tr>  
  <td>
    <label><?php echo _MOLLIESTATUS; ?></label>

    <select class="custom-select form-control" name="st_mollie_status">
      <?php
        if($settings['st_mollie_status'] == '1'){
        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
        echo '<option value="0" >'._DISABLED.'</option>';
      }else{
        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
        echo '<option value="1">'._ENABLED.'</option>';
      }
      ?>
    </select>
  </td>
</tr>

<tr>  
  <td>
    <label><?php echo _MOLLIEKEY; ?></label>
    <input class="form-control" value="<?php echo $settings['st_mollie_api']; ?>" name="st_mollie_api" type="text">
  </td>
</tr>

</table>

    </div>

			</div>


</div>
</div>
</div>

<button class="btn btn-primary" type="submit" name="save" form="setSettings"><?php echo _SAVECHANGES; ?></button>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

  <div class="scrollTop">
    <span><a href=""><i class="dripicons-arrow-thin-up"></i></a></span>
  </div>

<?php require 'footer.php'; ?>
