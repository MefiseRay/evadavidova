<?php if($position == 'mobile_menu') { ?>
	<div id="dl-menu" class="dl-menuwrapper hidden-lg hidden-md">
		<button class="dl-trigger"><?php echo $heading_title; ?></button>
		<ul class="dl-menu">
			 <li class="close"></li>
			<?php if ($telephone) { ?>
				<li class="mb-phone">
					<span class="user-data"><?php echo $telephone; ?></span>
					<span class="callback" onclick="getOCwizardModal_smcm(1);">Заказать обратный звонок</span>
				</li>
			<?php } ?>			 
			<?php foreach ($items as $smenu) { ?>		
				 <li><a href="<?php echo $smenu['href']; ?>" title="<?php echo $smenu['title']; ?>"><?php echo $smenu['name']; ?></a>
					<?php if ($smenu['children']) { ?>
						 <ul class="dl-submenu">
							<li class="dl-back"><a href="#"><?php echo $smenu['name']; ?></a></li>
							<?php foreach ($smenu['children'] as $child) { ?>
								<li><a href="<?php echo $child['href']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['name']; ?></a>
									<?php if ($child['children']) { ?>
										<ul class="dl-submenu">
											<li class="dl-back"><a href="#"><?php echo $child['name']; ?></a></li>
											<?php foreach ($child['children'] as $child2) { ?>
												<li><a href="<?php echo $child2['href']; ?>" title="<?php echo $child2['title']; ?>"><?php echo $child2['name']; ?></a></li>
											<?php } ?>
										</ul>
									<?php } ?>		
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</li>
			<?php } ?>
	</div><!-- /dl-menuwrapper -->										
	<script>
		$(function() {
			$( '#dl-menu' ).dlmenu({
				animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
			});
		});
	</script>
                                        
<?php } else { ?>
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="list-group">
		<?php foreach ($items as $smenu) { ?>
			<?php if ($smenu['active']) { ?>
			<a href="<?php echo $smenu['href']; ?>" class="list-group-item active" title="<?php echo $smenu['title']; ?>"><?php echo $smenu['name']; ?></a>
			<?php } else { ?>
			<a href="<?php echo $smenu['href']; ?>" class="list-group-item" title="<?php echo $smenu['title']; ?>"><?php echo $smenu['name']; ?></a>
			<?php } ?>
			<?php if ($smenu['children']) { ?>
				<?php foreach ($smenu['children'] as $child) { ?>
					<?php if ($smenu['active']) { ?>
					<a href="<?php echo $child['href']; ?>" class="list-group-item active" title="<?php echo $child['title']; ?>">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
					<?php } else { ?>
					<a href="<?php echo $child['href']; ?>" class="list-group-item" title="<?php echo $child['title']; ?>">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
					<?php } ?>
					<?php if ($child['children']) { ?>
						<?php foreach ($child['children'] as $child) { ?>
							<?php if ($smenu['active']) { ?>
								<a href="<?php echo $child['href']; ?>" class="list-group-item active" title="<?php echo $child['title']; ?>">&nbsp;&nbsp;&nbsp;-- <?php echo $child['name']; ?></a>
							<?php } else { ?>
								<a href="<?php echo $child['href']; ?>" class="list-group-item" title="<?php echo $child['title']; ?>">&nbsp;&nbsp;&nbsp;-- <?php echo $child['name']; ?></a>
							<?php } ?>
						<?php } ?>
					<?php } ?>		
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>
