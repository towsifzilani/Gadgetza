<?php

require '../core.php';

if(isLogged($connect)){

if(isset($_POST["category_id"]) && !empty($_POST["category_id"])){

    $category_id = clearGetData($_POST["category_id"]);
    $response = getSubCategories($connect, $category_id);

?>

<?php if(!empty($response)){ ?>
<option value="" selected></option>
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