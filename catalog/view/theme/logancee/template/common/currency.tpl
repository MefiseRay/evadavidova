<?php if (count($currencies) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="currency_form">
     <div class="currency-topbar">
          <div class="currency-sym">
               <?php foreach ($currencies as $currency) { ?>
               <?php if ($currency['code'] == $code) { ?>
               <a class="title"><?php echo $currency['title']; ?><i class="fa fa-angle-down"></i></a>
               <?php } ?>
               <?php } ?>
          </div>
          
          <div class="currency-list">
               <ul class="clearfix">
                    <?php foreach ($currencies as $currency) { ?>
                    <li <?php if ($currency['code'] == $code) { echo 'class="active"'; } ?>><a href="javascript:;" onclick="$('input[name=\'code\']').attr('value', '<?php echo $currency['code']; ?>'); $('.currency_form').submit();"><span class="sym"><?php echo $currency['symbol_left'].$currency['symbol_right']; ?></span><span class="title"><?php echo $currency['title']; ?></span></a></li>
                    <?php } ?>
               </ul>
          </div>
     </div>

    <input type="hidden" name="code" value="" />
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
<?php } ?>