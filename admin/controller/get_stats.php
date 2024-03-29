<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('view_stats')){

$id_item = cleardata(getId());

if(getStatsFor() && getId()){

    if(getStatsFor() == "referrers"){
        $data = get_deal_clicks_by_referrers($id_item);
    }elseif(getStatsFor() == "browsers"){
        $data = get_deal_clicks_by_browsers($id_item);
    }elseif(getStatsFor() == "devices"){
        $data = get_deal_clicks_by_devices($id_item);
    }elseif(getStatsFor() == "os"){
        $data = get_deal_clicks_by_os($id_item);
    }elseif(getStatsFor() == "languages"){

        $data = get_deal_clicks_by_languages($id_item);
        
        foreach ($data as $key => $string) {
           $data[$key] = str_replace($string['track_browser_language'], get_language_from_locale($languagesArray, $string['track_browser_language']), $string);
        }

    }elseif(getStatsFor() == "countries"){
        $data = get_deal_clicks_by_country($id_item);
    }elseif(getStatsFor() == "cities"){
        $data = get_deal_clicks_by_city($id_item);
    }else{
        $data = array();
    }
    
}

$results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData"=> $data);

echo json_encode($results);

}else{
	
	header('Location: ./denied.php');
	
}

}else{

    header('Location:'.SITE_URL);
}

?>