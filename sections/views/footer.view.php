<div class="uk-container uk-margin-large-top">
<hr>
</div>

<div class="tas-footer uk-margin-large-bottom">
    <div class="uk-container">
        <div class="tas-widgets uk-grid-large" uk-grid>
            <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-2@m">
                <h4 class="tas-title"><?php echo echoOutput($translation['tr_40']); ?></h4>
                <p class="tas-about"><?php echo echoOutput($translation['tr_41']); ?></p>
                <ul class="tas-follow uk-iconnav">
<?php foreach($socialMedia as $item): ?>
<?php if (!empty($item['st_facebook'])): ?>
<li><a href="<?php echo $item['st_facebook'] ?>" uk-icon="icon: facebook"></a></li>
<?php endif;?>
<?php if (!empty($item['st_twitter'])): ?>
<li><a href="<?php echo $item['st_twitter'] ?>" uk-icon="icon: twitter"></a></li>
<?php endif;?> 
<?php if (!empty($item['st_youtube'])): ?>
<li><a href="<?php echo $item['st_youtube'] ?>" uk-icon="icon: youtube"></a></li>
<?php endif;?>
<?php if (!empty($item['st_linkedin'])): ?>
<li><a href="<?php echo $item['st_linkedin'] ?>" uk-icon="icon: linkedin"></a></li>
<?php endif;?>
<?php if (!empty($item['st_instagram'])): ?>
<li><a href="<?php echo $item['st_instagram'] ?>" uk-icon="icon: instagram"></a></li>
<?php endif;?>
<?php if (!empty($item['st_whatsapp'])): ?>
<li><a href="<?php echo $item['st_whatsapp'] ?>" uk-icon="icon: whatsapp"></a></li>
<?php endif;?>
<?php endforeach; ?>
                </ul>
            </div>
            <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
                <h4 class="tas-title"><?php echo echoOutput($translation['tr_42']); ?></h4>
                <ul class="uk-list">
<?php foreach($navigationFooter as $item): ?>
<?php if ($item['navigation_type'] == 'custom') { ?>
    <?php if($item['navigation_url'] == '/'){ ?>
    <li><a href="<?php echo $urlPath->home(); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
    <?php }else{ ?>
    <li><a href="<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
    <?php } ?>
<?php } else { ?>
<li><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
<?php } ?>
<?php endforeach; ?>
                </ul>
            </div>
            <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
                <h4 class="tas-title"><?php echo echoOutput($translation['tr_44']); ?></h4>

<div class="new-subscriber">
                <form>
                    <div class="uk-inline uk-width-1-1">
                        <i class="ti ti-at uk-form-icon"></i>
<input type="email" id="subscriber_email" name="subscriber_email" class="uk-input uk-width-1-1 uk-form-large uk-border-pill" placeholder="<?php echo echoOutput($translation['tr_46']); ?>">
                    </div>
<button class="uk-button uk-width-1-1 uk-button-large uk-button-primary uk-border-pill uk-margin-small-top" value="<?php echo echoOutput($translation['tr_45']); ?>" type="submit" id="submit-subscriber"><?php echo echoOutput($translation['tr_45']); ?></button>

<div id="showresults"></div>

                </form>
            </div>

            </div>
        </div>
    </div> 


        <div class="uk-container uk-margin-large-top">
            <div class="uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-1-1 uk-width-1-2@s uk-text-center uk-text-left@s">
                    <p class="uk-text-light"><?php echo echoOutput($translation['tr_47']); ?></p>
                </div>
                <div class="uk-width-1-1 uk-width-1-2@s uk-flex uk-flex-center uk-flex-right@s">
                
                    <div class="uk-grid-small" uk-grid>
                        <?php if (!empty($settings['st_googleplay_app'])): ?>
                        <div><a target="_blank" href="<?php echo $settings['st_googleplay_app']; ?>"><img class="app_stores_footer" src="<?php echo $urlPath->assets_img("googleplay.png"); ?>"/></a></div>
                        <?php endif; ?>

                        <?php if (!empty($settings['st_appstore_app'])): ?>
                        <div><a target="_blank" href="<?php echo $settings['st_appstore_app']; ?>"><img class="app_stores_footer" src="<?php echo $urlPath->assets_img("appstore.png"); ?>"/></a></div>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>

</div>