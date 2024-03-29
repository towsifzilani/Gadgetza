<div class="uk-height-1-1">
            <div class="uk-section-large">
                <div class="uk-container uk-container-large">
                    <div uk-grid class="uk-child-width-1-1@s uk-child-width-2-3@l">
                        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
                        <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
                            <div class="uk-card uk-card-default uk-border-rounded uk-card-bordered">
                                <div class="uk-card-header">
                                <?php echo echoOutput($translation['tr_144']); ?>
                                </div>
                                <div class="uk-card-body">
                                <center>
                                        <a href="<?php echo $urlPath->dashboard(); ?>">
                                        <img class="uk-logo-small" src="<?php echo $urlPath->image($theme['th_logo']); ?>">
                                        </a>
                                        <br />
                                    </center>
                                    
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="submit-form" method="post">  

                                    <fieldset class="uk-fieldset">

                                            <div class="uk-margin">
                                                <div class="uk-position-relative">
                                                    <span class="uk-form-icon" uk-icon="user"></span>
                                                    <input name="user_email" class="uk-input uk-border-rounded" type="email" placeholder="<?php echo echoOutput($translation['tr_145']); ?>" required="">
                                                </div>
                                            </div>

                                            <div class="uk-margin">
                                                <div class="uk-position-relative">
                                                    <span class="uk-form-icon" uk-icon="lock"></span>
                                                    <input name="user_password" class="uk-input uk-border-rounded" type="password" placeholder="<?php echo echoOutput($translation['tr_146']); ?>" required="">
                                                </div>
                                            </div>

                                            <div class="uk-margin">
                                                <a href="<?php echo $urlPath->forgot(); ?>"><?php echo echoOutput($translation['tr_148']); ?></a>
                                            </div>

                                            <div class="uk-margin">
                                            <button class="uk-button uk-button-primary uk-border-rounded" type="submit" data-sitekey="<?php echo echoOutput($siteKey); ?>">
                                            <span uk-icon="sign-in"></span>&nbsp; <?php echo echoOutput($translation['tr_150']); ?>
                                            </button>
                                            </div>

                                                <?php if(!empty($errors)): ?>
                                                <div class="uk-width-1-1 uk-text-left">
                                                <div class="uk-margin">
                                                <div class="uk-alert-danger uk-padding-small uk-text-small uk-border-rounded uk-margin-remove">
                                                <ul class="uk-margin-remove">
                                                <?php foreach($errors as $key => $value):?>
                                                <li><?php echo echoOutput($value); ?></li>
                                                <?php endforeach; ?>
                                                </ul>
                                                </div>
                                                </div>
                                                </div>
                                                <?php endif; ?>

                                            <hr />

                                            <center>
                                                <p>
                                                <?php echo echoOutput($translation['tr_147']); ?>
                                                </p>
                                                <a href="<?php echo $urlPath->signup(); ?>" class="uk-button uk-button-default uk-border-rounded">
                                                    <span uk-icon="arrow-right"></span>&nbsp; <?php echo echoOutput($translation['tr_149']); ?>
                                                </a>
                                            </center>
                                            
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
                    </div>
                </div>

                <div class="uk-container uk-margin-medium-top">
            <div uk-grid>
                <div class="uk-width-1-1 uk-text-center">
                    <?php echo echoOutput($translation['tr_47']); ?>
                </div>
            </div>
        </div>
                
            </div>
        </div>