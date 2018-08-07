<!-- 
@category  : OpenCart
@module    : Smart Contact Me
@author    : OCdevWizard <ocdevwizard@gmail.com> 
@copyright : Copyright (c) 2015, OCdevWizard
@license   : http://license.ocdevwizard.com/Licensing_Policy.pdf
-->

<div class="tile">
  <div class="tile-heading">
    <?php echo $heading_title; ?>
  </div>
  <div class="tile-body"><i class="fa fa-envelope-o" aria-hidden="true"></i>
		<div class="table-responsive">
			<table class="table smcm-table" style="margin-bottom: 0;">
	    	<tr>
	    		<td><?php echo $text_total_viewed; ?></td>
	    		<td class="text-right"><?php echo $total_viewed; ?></td>
	    	</tr>
	    	<tr>
	    		<td><?php echo $text_total_not_viewed; ?></td>
	    		<td class="text-right"><?php echo $total_not_viewed; ?></td>
	    	</tr>
	    	<tr>
	    		<td><?php echo $text_total; ?></td>
	    		<td class="text-right"><?php echo $total; ?></td>
	    	</tr>
  		</table>
  	</div>
  </div>
  <div class="tile-footer"><a href="<?php echo $link; ?>"><?php echo $button_view_more; ?></a></div>
</div>