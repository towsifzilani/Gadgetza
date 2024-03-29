<?php if( !empty($languages)): ?>
  <div class="ml-auto w-15">
    <div class="dropdown">
      <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownLanguage" data-toggle="dropdown" aria-expanded="false">

        <?php if( !empty($lang)): ?>
          <?php echo $lang; ?>    
        <?php endif; ?>

        <?php if(empty($lang)): ?>
          <?php echo "<?php echo _TABLEFIELDLANG; ?>" ?>    
        <?php endif; ?>

      </button>
      <div class="dropdown-menu" aria-label="dropdownLanguage">
       <?php 
       foreach($languages as $language)
       {
        if($lang != $language['language_code'])
        {
         ?>
         <a class="dropdown-item" href="<?php echo $actual_link ?>?lang=<?php echo $language['language_code']; ?><?php if( !empty($id)): ?><?php echo '&id='.$id; ?><?php endif; ?>"><?php echo $language['language_name']; ?></a>
       <?php }else{ ?>

        <a class="dropdown-item" href="#"><?php echo $language['language_name']; ?></a>

      <?php }} ?>
    </div>
  </div>

</div>
<?php endif; ?>




