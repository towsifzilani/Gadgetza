<?php

if(isset($_POST["category_id"]) && !empty($_POST["category_id"])){

require '../../config.php';
require '../functions.php';

$category_id = cleardata($_POST["category_id"]);
$response = get_subcategories_per_parent($category_id);

if(check_session() == true){

?>

<?php if(!empty($response)){ ?>
<option value="" selected>---</option>
<?php foreach($response as $item): ?>
    <option value="<?php echo $item['subcategory_id']; ?>"><?php echo $item['subcategory_title']; ?></option>
<?php endforeach; ?>
<?php }else{ ?>
    <option value="" selected>---</option>
<?php

    }

}else{
    
    exit();
}

}else{
    
    exit();
}

?>