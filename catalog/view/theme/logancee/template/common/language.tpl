<?php if (count($languages) > 1) { ?>
<!-- Language -->
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="language_form">
     <div class="language-desktop">
          <div class="language-topbar">
               <div class="lang-curr">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $code) { ?>
                    <a class="title" style="background-image: url(catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png);"><?php echo $language['name']; ?><i class="fa fa-angle-down"></i></a>
                    <?php } ?>
                    <?php } ?>
               </div>
               
               <div class="lang-list">
                    <ul class="clearfix">
                         <?php foreach ($languages as $language) { ?>
                         <li <?php if ($language['code'] == $code) { echo 'class="active"'; } ?>><a href="javascript:;" onclick="$('input[name=\'code\']').attr('value', '<?php echo $language['code']; ?>'); $('.language_form').submit();" style="background-image: url(catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png);"><span class="lang-name"><?php echo $language['name']; ?></span></a></li>
                         <?php } ?>
                    </ul>
               </div>
          </div>
     </div>
     
     <input type="hidden" name="code" value="" />
     <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
<?php } ?>