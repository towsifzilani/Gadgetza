<?php

session_start();

require(__DIR__ . '/config.php');
require(__DIR__ . '/functions.php');
require(__DIR__ . '/routes.php');
require(__DIR__ . '/translation.php');

$connect = connect();

if (!$connect) {
	exit();
}

// Site Configuration
$settings = getSettings($connect);
$theme = getTheme($connect);
$translation = $langStrings[0];

$langDir = $settings['st_langdir'];

// Ads
$headerAd = getHeaderAd($connect);
$footerAd = getFooterAd($connect);
$sidebarAd = getSidebarAd($connect);

// Social Media Links
$socialMedia = getSocialMedia($connect);

// Get user info
if (isLogged()){

$userInfo = getUserInfo();

}

// Default Pages
$defaultSearchPage = getDefaultPage($connect, $settings['st_defaultsearchpage']);
$defaultPrivacyPage = getDefaultPage($connect, $settings['st_defaultprivacypage']);
$defaultTermsPage = getDefaultPage($connect, $settings['st_defaulttermspage']);
$defaultContactPage = getDefaultPage($connect, $settings['st_defaultcontactpage']);
$defaultCategoriesPage = getDefaultPage($connect, $settings['st_defaultcategoriespage']);
$defaultStoresPage = getDefaultPage($connect, $settings['st_defaultstorespage']);
$defaultLocationsPage = getDefaultPage($connect, $settings['st_defaultlocationspage']);
$defaultPricingPage = getDefaultPage($connect, $settings['st_defaultpricingpage']);

define('SEARCH_PAGE', $defaultSearchPage['page_slug']);
define('PRIVACY_PAGE', $defaultPrivacyPage['page_slug']);
define('TERMS_PAGE', $defaultTermsPage['page_slug']);
define('CONTACT_PAGE', $defaultContactPage['page_slug']);
define('CATEGORIES_PAGE', $defaultCategoriesPage['page_slug']);
define('STORES_PAGE', $defaultStoresPage['page_slug']);
define('LOCATIONS_PAGE', $defaultLocationsPage['page_slug']);
define('PRICING_PAGE', $defaultPricingPage['page_slug']);

// Maintenance Mode
$maintenanceMode = $settings['st_maintenance'];

$urlPath = new Routes();

if (isLogged()) {

if ($maintenanceMode == 1 && !isAdmin() && basename($_SERVER['PHP_SELF']) != 'offline.php') {

	header('Location: '. $urlPath->offline());
}

}elseif($maintenanceMode == 1 && basename($_SERVER['PHP_SELF']) != 'offline.php') {

	header('Location: '. $urlPath->offline());
}


?>