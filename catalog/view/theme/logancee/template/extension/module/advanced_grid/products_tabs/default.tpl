<?php 
if($registry->has('theme_options') == true) { 

$class = 3; 
$all = 8;
$ids = rand(0, 5000)*rand(5000, 50000);

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' ); ?>

<div class="filter-product version2">
	<div class="filter-tabs">
	     <div class="main-heading"><div class="heading-title"><h2><span><?php echo $module['content']['title']; ?></span></h2></div></div>
		<div class="bg-filter-tabs"><div class="bg-filter-tabs2 clearfix">
		<ul id="tab<?php echo $ids; ?>">
			<?php $i = 0; foreach($module['content']['products_tabs'] as $product_tab) {
				echo '<li'.($i == 0 ? ' class="active"' : '').'><a href="#pko'.$ids.'-'.$i.'">'.$product_tab['name'].'</a></li>';
			$i++; } ?>
		</ul>
		</div></div>
	</div>
	
	<div class="tab-content clearfix">
		<?php $s = 0; foreach($module['content']['products_tabs'] as $product_tab) { ?>
		<div class="tab-pane <?php if($s == 0) { echo 'active'; } ?>" id="pko<?php echo $ids.'-'.$s; ?>">
			<script type="text/javascript">
			$(document).ready(function() {
			  var owl<?php echo $ids . '_' . $s; ?> = $(".filter-product #myCarousel<?php echo $ids.'-'.$s; ?> .carousel-inner");

			  owl<?php echo $ids . '_' . $s; ?>.owlCarousel({
			  	  slideSpeed : 500,
			      items: 4,
			      itemsDesktop : [1199,3],
			      <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
			      direction: 'rtl'
			      <?php endif; ?>
			   });
			});
			</script>
			
			<div class="box-product">
				<div id="myCarousel<?php echo $ids.'-'.$s; ?>" class="carousel slide">
					<!-- Carousel items -->
					<div class="carousel-inner">
					     
					     <div class="item"><div class="product-grid">
						<?php $i = 0; foreach ($product_tab['products'] as $product) { ?>
			    			<?php if(!($i%2) && $i > 0) { echo '</div></div><div class="item"><div class="product-grid">'; } ?>
			    				<?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
						<?php $i++; } ?>
						</div></div>

					</div>
				</div>
			</div>
		</div>
		<?php $s++; } ?>
	</div>
</div>
 
<script type="text/javascript">
$('#tab<?php echo $ids; ?> a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>
<?php } ?>