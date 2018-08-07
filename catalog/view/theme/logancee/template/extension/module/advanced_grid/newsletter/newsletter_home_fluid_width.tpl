<div class="subscribe home03 clearfix" id="newsletter<?php echo $id; ?>">
     <h2 class="title"><span><?php echo $module['content']['title']; ?></span></h2>
     <?php if ($module['content']['text'] != '') { ?>
         <div class="text"><?php echo $module['content']['text']; ?></div>
     <?php } ?>
          <div class="block-content">
               <div class="input-box">
                    <input name="email" type="text" id="newsletter" placeholder="<?php echo $module['content']['input_placeholder']; ?>" class="input-text email required-entry validate-email">
                    <button class="hover-effect07 subscribebutton" type="submit" title="<?php echo $module['content']['subscribe_text']; ?>"><span><?php echo $module['content']['subscribe_text']; ?></span></button>
               </div>
          </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	function Unsubscribe() {
		$.post('<?php echo $module['content']['unsubscribe_url']; ?>', 
			{ 
				email: $('#newsletter<?php echo $id; ?> .email').val() 
			}, function (e) {
				$('#newsletter<?php echo $id; ?> .email').val('');
				alert(e.message);
			}
		, 'json');
	}
	
	function Subscribe() {
		yaCounter48659294.reachGoal('subscribe');
		$.post('<?php echo $module['content']['subscribe_url']; ?>', 
			{ 
				email: $('#newsletter<?php echo $id; ?> .email').val() 
			}, function (e) {
				if(e.error === 1) {
					var r = confirm(e.message);
					if (r == true) {
					    $.post('<?php echo $module['content']['unsubscribe_url']; ?>', { 
					    	email: $('#newsletter<?php echo $id; ?> .email').val() 
					    }, function (e) {
					    	$('#newsletter<?php echo $id; ?> .email').val('');
					    	alert(e.message);
					    }, 'json');
					}
				} else if (e.error === 2) {
					alert(e.message);
				} else {
					yaCounter48659294.reachGoal('subscribe');
					$('#newsletter<?php echo $id; ?> .email').val('');
					alert(e.message);
				}
			}
		, 'json');
	}
	
	$('#newsletter<?php echo $id; ?> .subscribebutton').click(Subscribe);
	$('#newsletter<?php echo $id; ?> .unsubscribe').click(Unsubscribe);
	$('#newsletter<?php echo $id; ?> .email').keypress(function (e) {
	    if (e.which == 13) {
	        Subscribe();
	    }
	});
});
</script>
