<section>
    <div class="height-100-vh bg-primary-trans">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <img src="../assets/images/wbdashboard.png" class="logo-auth">
                    <div class="login-div">
                       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="login" id="needs-validation" novalidate>  
                            <?=$csrf->input('login-token');?>

                            <div class="form-group">
                                <label><?php echo _LOGINUSERNAME; ?></label>
                                <input class="form-control input-lg" placeholder="<?php echo _LOGINUSERNAME; ?>" name="user_email" type="text" required>
                                <div class="invalid-feedback"><?php echo _LOGINREQUIREDFORM; ?></div>
                            </div>
                            <div class="form-group">
                                <label><?php echo _LOGINPASSWORD; ?></label>
                                <input class="form-control input-lg" placeholder="<?php echo _LOGINPASSWORD; ?>" name="user_password" type="password" required>
                                <div class="invalid-feedback"><?php echo _LOGINREQUIREDFORM; ?></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label><?php echo _LOGINPCAPTCHA; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo _LOGINPCAPTCHA; ?>" name="captcha" required>
                                    <div class="invalid-feedback"><?php echo _LOGINREQUIREDFORM; ?></div>
                                </div>
                                <div class="form-group col-6">
                                    <label><?php echo _LOGINPCAPTCHACODE; ?></label>
                                    <img src="../controller/captcha.php" style="width: 100%; border-radius: 4px; height: 38px;">
                                </div>
                            </div>

                            <button class="btn btn-primary mt-2" type="submit" style="width: 100%"><?php echo _LOGINBUTTON; ?></button>

                            <?php if( !empty($errors)): ?>

							<div class="alert alert-danger animated fadeIn alert-login" role="alert">
    
    						<?php echo $errors; ?>
    
							</div>
							
							<?php endif; ?>

                        </form>
                    </div>
                    <div class="copyright-text">
                    <span><?php echo _COPYRIGHTFOOTER; ?></span><br>
                    <span>&copy; <?php echo date("Y"); ?> <?php echo _AUTHORCOPYRIGHT; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

