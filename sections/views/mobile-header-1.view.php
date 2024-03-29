<nav class="tas_mobile_nav uk-navbar-container uk-padding uk-hidden@m" uk-navbar>

    <div class="uk-navbar-left">
        <a class="uk-button uk-button-link tas_button" href="#sidemenu" uk-toggle>
            <i class="ti ti-align-justified"></i>
        </a>
    </div>

    <div class="uk-navbar-center">

		<a class="uk-navbar-item uk-logo" href="<?php echo $urlPath->home(); ?>">
		<img src="<?php echo $urlPath->image($theme['th_whitelogo']); ?>">
		</a>

    </div>

    <div class="uk-navbar-right">
        <a class="uk-button uk-button-link tas_button" href="<?php echo $urlPath->search(); ?>">
            <i class="ti ti-search"></i>
        </a>
    </div>

</nav>