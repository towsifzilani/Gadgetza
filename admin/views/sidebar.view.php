<nav id="navigation" class="navigation-sidebar navbar-expand-lg static-top bg-primary">
        <div class="navigation-header">
        <a href="<?php echo SITE_URL ?>/admin"><img src="../assets/images/wbdashboard.png" class="logo-side"></a>
    </div>

    <div class="welcome">
        <?php echo _WELCOME; ?> <b><?php echo $userInfo['user_name']; ?></b> <a href="../controller/logout.php" class="sidebar-user"><i class="dripicons-exit"></i></a>
    </div>

    <div class="navigation-menu">

        <ul class="menu-items custom-scroll">
            
            <?php foreach($menuItems as $item): ?>
            <li>
                <a href="<?php echo $item['url']; ?>">
                    <span class="icon-thumbnail"><i class="<?php echo $item['icon']; ?>"></i></span>
                    <span class="title"><?php echo $item['title']; ?></span>
                </a>
            </li>
            <?php endforeach; ?>

        </ul>
    </div>
</nav>

<div class="header fixed-header">
    <div class="container-fluid side-padding">
        <div class="row">
            
            <div class="col-7 col-md-6 d-lg-none">
                <a id="toggle-navigation" href="javascript:void(0);" class="icon-btn mr-3"><i class="fa fa-bars"></i></a>
                <img src="../assets/images/wbdashboard-dark.png" class="logo-side-dark">
            </div>

            <div class="col-lg-8 d-none d-lg-block">
                <p class="sidebar-relative"><?php echo _WELCOME; ?> <b><?php echo $userInfo['user_name']; ?></b> <a href="../controller/logout.php" class="sidebar-logout"><i class="dripicons-exit"></i></a></p>
            </div>
            
            <div class="col-5 col-md-6 col-lg-4 sidebar-right">
            <span style="position: relative; float: right;"> <a href="<?php echo SITE_URL ?>" target="_blank" style="color: var(--primary-color); top: -2px; position: relative; margin-right: 8px; font-weight: 500; font-size: 14px; margin-left: 6px;"><i class="dripicons-preview d-none d-sm-inline" style="top: 5px; position: relative; font-size: 22px; margin-right: 6px;"></i><?php echo _VIEWSITE; ?></a></span>
            </div> 

        </div>
    </div>
    
</div>



