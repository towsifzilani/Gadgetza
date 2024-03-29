<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

$id_item = cleardata(getId());

if(!$id_item){
	header('Location: home.php');
}

if(check_permission('view_stats')){

$deal = get_deal_per_id($id_item);
$dealClicks = get_deal_clicks_by_interval($id_item);
$dealReferrers = get_deal_clicks_by_referrers($id_item, 6);
$dealBrowsers = get_deal_clicks_by_browsers($id_item, 6);
$dealDevices = get_deal_clicks_by_devices($id_item, 6);
$dealOS = get_deal_clicks_by_os($id_item, 6);
$dealLanguages = get_deal_clicks_by_languages($id_item, 6);
$dealCountries = get_deal_clicks_by_country($id_item, 6);
$dealCities = get_deal_clicks_by_city($id_item, 6);

if (!$deal){
	header('Location: ./home.php');
}

require '../views/stats.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>