<?php 
if($registry->has('theme_options') == false) { 
	header("location: themeinstall/index.php"); 
	exit; 
} 

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
$url = $registry->get('url'); ?>
<!DOCTYPE html>
<html class="quickview <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>>
<head>
     <!-- Google Fonts -->
     <link href="//fonts.googleapis.com/css?family=Lato:800,700,600,500,400,300" rel="stylesheet" type="text/css">
     <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
     <?php 
     if( $theme_options->get( 'font_status' ) == '1' ) {
     	$lista_fontow = array();
     	if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' && $theme_options->get( 'body_font' ) != 'Arial' && $theme_options->get( 'body_font' ) != 'Georgia' && $theme_options->get( 'body_font' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'body_font' );
     		$lista_fontow[$font] = $font;
     	}
     	
     	if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' && $theme_options->get( 'categories_bar' ) != 'Arial' && $theme_options->get( 'categories_bar' ) != 'Georgia' && $theme_options->get( 'categories_bar' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'categories_bar' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' && $theme_options->get( 'headlines' ) != 'Arial' && $theme_options->get( 'headlines' ) != 'Georgia' && $theme_options->get( 'headlines' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'headlines' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard'  && $theme_options->get( 'footer_headlines' ) != 'Arial' && $theme_options->get( 'footer_headlines' ) != 'Georgia' && $theme_options->get( 'footer_headlines' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'footer_headlines' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' && $theme_options->get( 'page_name' ) != 'Arial' && $theme_options->get( 'page_name' ) != 'Georgia' && $theme_options->get( 'page_name' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'page_name' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' && $theme_options->get( 'button_font' ) != 'Arial' && $theme_options->get( 'button_font' ) != 'Georgia' && $theme_options->get( 'button_font' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'button_font' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' && $theme_options->get( 'custom_price' ) != 'Arial' && $theme_options->get( 'custom_price' ) != 'Georgia' && $theme_options->get( 'custom_price' ) != 'Times New Roman' ) {
     		$font = $theme_options->get( 'custom_price' );
     		if(!isset($lista_fontow[$font])) {
     			$lista_fontow[$font] = $font;
     		}
     	}
     	
     	foreach($lista_fontow as $font) {
     		echo '<link href="//fonts.googleapis.com/css?family=' . $font . ':800,700,600,500,400,300" rel="stylesheet" type="text/css">';
     		echo "\n";
     	}
     }
     ?>
     
     <?php $lista_plikow = array(
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/animate.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/eleganticons.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/simple-line-icons.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/stylesheet.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/responsive.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/owl.carousel.css',
     		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/font-awesome.min.css',
     		'catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css'
     ); 
     
     //RTL
     if($page_direction[$config->get( 'config_language_id' )] == 'RTL'){
         $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/rtl.css';
         $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap_rtl.css';
     }
     
     echo $theme_options->compressorCodeCss( $config->get($config->get('config_theme') . '_directory'), $lista_plikow, 0, HTTP_SERVER ); 
     
     // Custom colors, fonts and backgrounds
     include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/custom_colors.php'); ?>

     <?php $lista_plikow = array(); 
     
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-2.1.1.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-migrate-1.2.1.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.easing.1.3.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/bootstrap.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.elevateZoom-3.0.3.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/common.js';
     $lista_plikow[] = 'catalog/view/javascript/jquery/datetimepicker/moment.js';
     $lista_plikow[] = 'catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/bootstrap-notify.min.js';
     
     echo $theme_options->compressorCodeJs( $config->get($config->get('config_theme') . '_directory'), $lista_plikow, 0, HTTP_SERVER ); ?>
     
     <link rel="stylesheet" type="text/css" href="/catalog/view/javascript/jquery/formstyler/jquery.formstyler.css" media="screen" />
     <link rel="stylesheet" type="text/css" href="/catalog/view/javascript/jquery/formstyler/jquery.formstyler.theme.css" media="screen" />
     <script type="text/javascript" src="/catalog/view/javascript/jquery/formstyler/jquery.formstyler.min.js"></script>
     
     <script type="text/javascript" src="catalog/view/extension/related_options/js/liveopencart.select_option_toggle.js?v=1513059520"></script>
     <script type="text/javascript" src="catalog/view/extension/related_options/js/liveopencart.related_options.js?v=1513059520"></script>

     <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/owl.carousel.min.js"></script>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	
	<div id="notification-popupmaster" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $titulo ; ?></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
			<center>
			<div style="float:right">
                <button type="button" style="margin-top:10px;" class="btn btn-default" data-dismiss="modal"><?php echo $continuar ; ?> <i class="fa fa-check"></i></button>
				<a href="/cart/" style="margin-top:3px;" class="btn btn-warning"><?php echo $carrinho ; ?> <i class="fa fa-shopping-cart"></i></a>
                <a href="<?php echo $checkout;?>" style="margin-top:3px;" class="btn btn-success"><?php echo $comprar ; ?> <i class="fa fa-credit-card"></i></a>
				</div>
				</center>
            </div>
        </div>
    </div>
</div> <!-- https://www.opencartmaster.com.br Desenvolvido por Denis Cunha -->
	

  <div class="product-info">
  	<div class="row">
  		<div class="col-sm-12">
  			<div class="row" id="quickview_product">
			    <script>
			    	$(document).ready(function(){
			    	    $('#ex1, .review-link').live('click', function () {
			    	         top.location.href = "<?php echo $url->link('product/product&product_id=' . $product_id); ?>";
			    	         return false;
			    	     });
			    	     
     			    	$('#image').elevateZoom({
     			    		zoomType: "inner",
     			    		cursor: "pointer",
     			    		zoomWindowFadeIn: 500,
     			    		zoomWindowFadeOut: 750
     			    	});
     
     			    	$('.thumbnails a, .thumbnails-carousel a').click(function() {
     			    		var smallImage = $(this).attr('data-image');
     			    		var largeImage = $(this).attr('data-zoom-image');
     			    		var ez =   $('#image').data('elevateZoom');	
     			    		ez.swaptheimage(smallImage, largeImage); 
     			    		return false;
     			    	});
			    	});
			    </script>
			    <?php $image_grid = 6; $product_center_grid = 6; 
			    if ($theme_options->get( 'product_image_size' ) == 1) {
			    	$image_grid = 5; $product_center_grid = 7;
			    }
			    
			    if ($theme_options->get( 'product_image_size' ) == 3) {
			    	$image_grid = 8; $product_center_grid = 4;
			    }
			    ?>
			    <div class="col-sm-<?php echo $image_grid; ?> popup-gallery">
			      <div class="row">
			      	  <?php if ($images && $theme_options->get( 'position_image_additional' ) == 2) { ?>
			      	  <div class="col-sm-2">
						<div class="image-additional thumbnails thumbnails-left clearfix">
							<ul>
							  <?php if($thumb) { ?>
						      <li><div class='item'><a href="<?php echo $popup; ?>" class="popup-image" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $theme_options->productImageThumb($product_id, $config->get($config->get('config_theme') . '_image_additional_width'), $config->get($config->get('config_theme') . '_image_additional_height')); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div></li>
							  <?php } ?>
						      <?php foreach ($images as $image) { ?>
			<?php // << Product Option Image PRO module ?>
      <?php if ( ($poip_theme_name == 'goshop'
							|| ($poip_theme_name == 'fastor' && $theme_options->get( 'product_image_zoom' ) != 2)
							|| $poip_theme_name == 'journal2'
							|| $poip_theme_name == 'fractal'
							|| $poip_theme_name == 'OPC080191'
							|| $poip_theme_name == 'BurnEngine_pavilion'
							|| $poip_theme_name == 'BurnEngine_technopolis'
							|| $poip_theme_name == 'BurnEngine_shoppica'
							) && !empty($poip_installed) && !empty($popup)  ) {
      
				// to not show the main image twice
				if ( $image['popup'] == $popup || (!empty($thumb) && $thumb == $image['popup'] ) ) continue;
			} ?>
      <?php // >> Product Option Image PRO module ?>
      
						      <li><div class='item'><a href="<?php echo $image['popup']; ?>" class="popup-image" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img 
      src="<?php echo $image['thumb']; ?>" title="<?php echo ( (isset($image['title']) && $image['title']) ? ' '.$image['title'] : $heading_title); ?>" alt="<?php echo ((isset($image['title']) && $image['title']) ? ' '.$image['title'] : $heading_title); ?>"
       /></a></div></li>
						      <?php } ?>
						  </ul>
						</div>
			      	  </div>
			      	  <?php } ?>
			      	  
				      <div class="col-sm-<?php if($theme_options->get( 'position_image_additional' ) == 2) { echo 10; } else { echo 12; } ?>">
				      	<?php if ($thumb) { ?>
					      <div class="product-image inner-cloud-zoom">
					      	 <?php if($special && $theme_options->get( 'display_text_sale' ) != '0') { ?>
					      	 	<?php $text_sale = 'Sale';
					      	 	if($theme_options->get( 'sale_text', $config->get( 'config_language_id' ) ) != '') {
					      	 		$text_sale = $theme_options->get( 'sale_text', $config->get( 'config_language_id' ) );
					      	 	} ?>
					      	 	<?php if($theme_options->get( 'type_sale' ) == '1') { ?>
					      	 	<?php $product_detail = $theme_options->getDataProduct( $product_id );
					      	 	$roznica_ceny = $product_detail['price']-$product_detail['special'];
					      	 	$procent = ($roznica_ceny*100)/$product_detail['price']; ?>
					      	 	<div class="sale">-<?php echo round($procent); ?>%</div>
					      	 	<?php } else { ?>
					      	 	<div class="sale"><?php echo $text_sale; ?></div>
					      	 	<?php } ?>
					      	 <?php } ?>
					      	 
					     	 <a href="#" title="<?php echo $heading_title; ?>" id="ex1"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" data-zoom-image="<?php echo $popup; ?>" /></a>
					      </div>
					  	 <?php } else { ?>
					  	 <div class="product-image">
					  	 	 <a href="#" id="ex1"><img src="image/no_image.jpg" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" /></a>
					  	 </div>
					  	 <?php } ?>
				      </div>
				      
				      <?php if ($images && $theme_options->get( 'position_image_additional' ) != 2) { ?>
				      <div class="col-sm-12">
				           <div class="overflow-thumbnails-carousel">
     					      <div class="thumbnails-carousel owl-carousel">
     					      	<?php if($thumb) { ?>
     					      	     <div class="item"><a href="<?php echo $popup; ?>" class="popup-image" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $theme_options->productImageThumb($product_id, $config->get($config->get('config_theme') . '_image_additional_width'), $config->get($config->get('config_theme') . '_image_additional_height')); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
     					      	<?php } ?>
     						     <?php foreach ($images as $image) { ?>
			<?php // << Product Option Image PRO module ?>
      <?php if ( ($poip_theme_name == 'goshop'
							|| ($poip_theme_name == 'fastor' && $theme_options->get( 'product_image_zoom' ) != 2)
							|| $poip_theme_name == 'journal2'
							|| $poip_theme_name == 'fractal'
							|| $poip_theme_name == 'OPC080191'
							|| $poip_theme_name == 'BurnEngine_pavilion'
							|| $poip_theme_name == 'BurnEngine_technopolis'
							|| $poip_theme_name == 'BurnEngine_shoppica'
							) && !empty($poip_installed) && !empty($popup)  ) {
      
				// to not show the main image twice
				if ( $image['popup'] == $popup || (!empty($thumb) && $thumb == $image['popup'] ) ) continue;
			} ?>
      <?php // >> Product Option Image PRO module ?>
      
     						         <div class="item"><a href="<?php echo $image['popup']; ?>" class="popup-image" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img 
      src="<?php echo $image['thumb']; ?>" title="<?php echo ( (isset($image['title']) && $image['title']) ? ' '.$image['title'] : $heading_title); ?>" alt="<?php echo ((isset($image['title']) && $image['title']) ? ' '.$image['title'] : $heading_title); ?>"
       /></a></div>
     						     <?php } ?>
     					      </div>
					      </div>
					      
					      <script type="text/javascript">
					           $(document).ready(function() {
					             $(".thumbnails-carousel").owlCarousel({
					                 autoPlay: 6000, //Set AutoPlay to 3 seconds
					                 navigation: true,
					                 navigationText: ['', ''],
					                 itemsCustom : [
					                   [0, 4],
					                   [450, 5],
					                   [550, 6],
					                   [768, 4]
					                 ],
					                 <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
					                 direction: 'rtl'
					                 <?php endif; ?>
					             });
					           });
					      </script>
				      </div>
				      <?php } ?>
			      </div>
			    </div>

			    <div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
			     <div itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
			      <h2 class="product-name"><a href="#" class="review-link"><?php echo $heading_title; ?></a></h2>
			      <span class="model"><?php echo $text_model; ?> <?php	echo "<font id='product_model'>".$model."</font>"; // <- Related Options / Связанные опции ?>
      </span>
			      
			      <div class="row">
                       <?php if ($price) { ?>
                           <div class="price col-sm-6">
                            <div class="main-price">
                                <?php if (!$special) { ?>
                                <span class="price-new"><span itemprop="price" id="price-old"><?php echo $price; ?></span></span>
                                <?php } else { ?>
                                <span class="price-old" id="price-old"><?php echo $price; ?></span>
                                <span class="price-new"><span itemprop="price" id="price-special"><?php echo $special; ?></span></span>
                                <?php } ?>
                              </div>

                              <div class="other-price">
                                <?php if ($tax) { ?>
                                <span class="price-tax"><?php echo $text_tax; ?> <span id="price-tax"><?php echo $tax; ?></span></span><br />
                                <?php } ?>
                                <?php if ($points) { ?>
                                <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
                                <?php } ?>
                                <?php if ($discounts) { ?>
                                <br />
                                <div class="discount">
                                  <?php foreach ($discounts as $discount) { ?>
                                  <?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?><br />
                                  <?php } ?>
                                </div>
                                <?php } ?>
                              </div>
                           </div>
                       <?php } ?>
                       <?php if ($review_status) { ?>
                          <div class="review col-sm-6">
                            <?php if($rating > 0) { ?>
                            <span itemprop="review" class="hidden" itemscope itemtype="http://schema.org/Review-aggregate">
                                <span itemprop="itemreviewed"><?php echo $heading_title; ?></span>
                                <span itemprop="rating"><?php echo $rating; ?></span>
                                <span itemprop="votes"><?php preg_match_all('/\(([0-9]+)\)/', $tab_review, $wyniki);
                                if(isset($wyniki[1][0])) { echo $wyniki[1][0]; } else { echo 0; } ?></span>
                            </span>
                            <?php } ?>
                            <div class="rating"><i class="fa fa-star<?php if($rating >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 5) { echo ' active'; } ?>"></i> <span class="rating-info"><a onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({scrollTop:$('#tab-review').offset().top}, '500', 'swing');"><?php echo $rating; ?></a> | <?php echo $reviews; ?></span>
                            <p class="rating-links"><a onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({scrollTop:$('#tab-review').offset().top}, '500', 'swing');"><?php echo $text_write; ?></a></p></div>
                          </div>
                       <?php } ?>
			       </div>
			     			     
			     <div id="product">
			      <?php if ($options) { ?>
			      <div class="options">
			        <?php foreach ($options as $option) { ?>
			        <?php if ($option['type'] == 'select') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			          <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
			            <option value=""><?php echo $text_select; ?></option>
			            <?php foreach ($option['product_option_value'] as $option_value) { ?>
			            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
			            <?php if ($option_value['price']) { ?>
			            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
			            <?php } ?>
			            </option>
			            <?php } ?>
			          </select>
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'radio') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label"><?php echo $option['name']; ?></label>
			          <div id="input-option<?php echo $option['product_option_id']; ?>">
			            <?php foreach ($option['product_option_value'] as $option_value) { ?>
			            <div class="radio <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { echo 'radio-type-button2'; } ?>">
			              <label<?php if ($option_value['image']) { ?> class="with-thumb"<?php } ?>>
			                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo ($option_value['default_value'] ? 'checked="checked"' : ''); ?> />
			                <span class="<?php echo ($option_value['default_value'] ? 'active' : ''); ?>"><?php echo (!$option_value['image'] ? $option_value['name'] : ''); ?>
			                <?php if ($option_value['image']) { ?>
								<span class="thumb"><img src="<?php echo $option_value['image']; ?>" title="<?php echo $option_value['name']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /></span>
			                <?php } ?> 
			                <?php if($theme_options->get( 'product_page_radio_style' ) != 1) { ?><?php if ($option_value['price']) { ?>
			                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
			                <?php } ?><?php } ?></span>
			              </label>
			            </div>
			            <?php } ?>
			            
			            <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>
			            <script type="text/javascript">
			                 $(document).ready(function(){
			                      $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {

				// << Related Options / Связанные опции
				if ( $(this).siblings(':radio, :checkbox').is(':disabled') ) {
					return
				}
				// >> Related Options / Связанные опции
			
			                           $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
			                           $(this).addClass("active");
			                      });
			                 });
			            </script>
			            <?php } ?>
			          </div>
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'checkbox') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label"><?php echo $option['name']; ?></label>
			          <div id="input-option<?php echo $option['product_option_id']; ?>">
			            <?php foreach ($option['product_option_value'] as $option_value) { ?>
			            <div class="checkbox <?php if($theme_options->get( 'product_page_checkbox_style' ) == 1) { echo 'radio-type-button2'; } ?>">
			              <label>
			                <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
			                <span><?php echo $option_value['name']; ?>
			                <?php if($theme_options->get( 'product_page_checkbox_style' ) != 1) { ?><?php if ($option_value['price']) { ?>
			                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
			                <?php } ?><?php } ?></span>
			              </label>
			            </div>
			            <?php } ?>
			            
			            <?php if($theme_options->get( 'product_page_checkbox_style' ) == 1) { ?>
			            <script type="text/javascript">
			                 $(document).ready(function(){
			                      $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {

				// << Related Options / Связанные опции
				if ( $(this).siblings(':radio, :checkbox').is(':disabled') ) {
					return
				}
				// >> Related Options / Связанные опции
			
			                           if($(this).hasClass("active") == true) {
			                                $(this).removeClass("active");
			                           } else {
			                                $(this).addClass("active");
			                           }
			                      });
			                 });
			            </script>
			            <?php } ?>
			          </div>
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'image') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label"><?php echo $option['name']; ?></label>
			          <div id="input-option<?php echo $option['product_option_id']; ?>">
			            <?php foreach ($option['product_option_value'] as $option_value) { ?>
			            <div class="radio <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { echo 'radio-type-button'; } ?>">
			              <label>
			                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
			                <span <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>data-toggle="tooltip" data-placement="top" title="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>"<?php } ?>><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>width="<?php if($theme_options->get( 'product_page_radio_image_width' ) > 0) { echo $theme_options->get( 'product_page_radio_image_width' ); } else { echo 25; } ?>px" height="<?php if($theme_options->get( 'product_page_radio_image_height' ) > 0) { echo $theme_options->get( 'product_page_radio_image_height' ); } else { echo 25; } ?>px"<?php } ?> /> <?php if($theme_options->get( 'product_page_radio_style' ) != 1) { ?><?php echo $option_value['name']; ?>
			                <?php if ($option_value['price']) { ?>
			                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
			                <?php } ?><?php } ?></span>
			              </label>
			            </div>
			            <?php } ?>
			            <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>
			            <script type="text/javascript">
			                 $(document).ready(function(){
			                      $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {

				// << Related Options / Связанные опции
				if ( $(this).siblings(':radio, :checkbox').is(':disabled') ) {
					return
				}
				// >> Related Options / Связанные опции
			
			                           $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
			                           $(this).addClass("active");
			                      });
			                 });
			            </script>
			            <?php } ?>
			          </div>
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'text') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'textarea') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			          <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
			        </div>
			        <?php } ?>
			        <?php if ($option['type'] == 'file') { ?>
			        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			          <label class="control-label"><?php echo $option['name']; ?></label>
			          <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" class="btn btn-default btn-block" style="margin-top: 7px"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
			          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
			        </div>
			        <?php } ?>
			       	<?php if ($option['type'] == 'date') { ?>
			       	<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			       	  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			       	  <div class="input-group date">
			       	    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			       	    <span class="input-group-btn">
			       	    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
			       	    </span></div>
			       	</div>
			       	<?php } ?>
			       	<?php if ($option['type'] == 'datetime') { ?>
			       	<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			       	  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			       	  <div class="input-group datetime">
			       	    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			       	    <span class="input-group-btn">
			       	    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
			       	    </span></div>
			       	</div>
			       	<?php } ?>
			       	<?php if ($option['type'] == 'time') { ?>
			       	<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			       	  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
			       	  <div class="input-group time">
			       	    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
			       	    <span class="input-group-btn">
			       	    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
			       	    </span></div>
			       	</div>
			       	<?php } ?>
			        <?php } ?>
			      </div>
			      <?php } ?>
			      
			      <?php if ($recurrings) { ?>
			      <div class="options">
			          <h2><?php echo $text_payment_recurring ?></h2>
			          <div class="form-group required">
			            <select name="recurring_id" class="form-control">
			              <option value=""><?php echo $text_select; ?></option>
			              <?php foreach ($recurrings as $recurring) { ?>
			              <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
			              <?php } ?>
			            </select>
			            <div class="help-block" id="recurring-description"></div>
			          </div>
			      </div>
			      <?php } ?>
			      
			      <div class="cart">
			        <div class="add-to-cart clearfix">
			          <?php $enquiry = false; if($config->get( 'product_blocks_module' ) != '') { $enquiry = $theme_options->productIsEnquiry($product_id); }
			          if(is_array($enquiry)) { ?>
     			          <a href="#" class="button review-link button-enquiry"><?php if($theme_options->get( 'more_details_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'more_details_text', $config->get( 'config_language_id' ) ); } else { echo 'More details'; } ?></a>
			          <?php } else { ?>
     			          <div class="quantity">
                              <span class="pdp-label"><?php echo $text_quantity; ?></span>
     			              <select name="quantity" class="styleme">
                                  <?php for ($x = $minimum; $x <= $minimum + 4; $x++ ) { ?>
     			                      <option value="<?php echo $x; ?>"<?php echo ($x == $minimum ? ' selected="selected"' : ''); ?>><?php echo $x; ?></option>
     			                  <?php } ?>  
     			              </select>
     			          </div>
     			          <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
     			          <div class="add-product-buttons">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" rel="<?php echo $product_id; ?>" data-loading-text="<?php echo $text_loading; ?>" class="button hover-effect07" />
                                  </div>
                                  <div class="col-sm-6">
                                      <?php if($theme_options->get( 'product_wishlist' ) || $theme_options->get( 'product_compare' )) { ?>
                                            <div class="links">
                                                <?php if($theme_options->get( 'product_wishlist' )) { ?>
													<span class="add-to-wishlist<?php echo ($wishlist ? ' active': '');?>" onclick="wishlist.add('<?php echo $product_id; ?>');return false;"><i class="im im-like"></i></span>
                                                <?php } ?>
                                                <?php if($theme_options->get( 'product_compare' )) { ?>
                                                    <a class="compare" onclick="compare.add('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a>
                                                <?php } ?>
                                            </div>
                                      <?php } ?>
                                  </div>
                              </div>
                              
                              <?php if($theme_options->get( 'product_social_share' ) != '0') { ?>
                                 <div class="share">
                                    <!-- AddThis Button BEGIN -->
                                        <div class="addthis_toolbox addthis_default_style">
                                            <a class="addthis_button_vk"><i class="fa fa-vk"></i></a>
                                            <a class="addthis_button_facebook"><i class="fa fa-facebook"></i></a>
                                            <a class="addthis_button_twitter"><i class="fa fa-twitter"></i></a>
                                            <a class="addthis_button_odnoklassniki_ru"><i class="fa fa-odnoklassniki"></i></a>
                                        </div>
                                        <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
                                    <!-- AddThis Button END --> 
                                 </div>
                              <?php } ?>       
                          </div>
			          <?php } ?>
			        </div>

                    <div class="description-section ">
                        <span class="pdp-label"><?php echo $tab_description; ?></span>
     			        <div itemprop="description"><?php echo $description; ?></div>
                    </div>
                    
                    <?php $details = $theme_options->getProductAttributeText( $product_id, 7 ); ?>
                    <?php if ($details) { ?>
						<div class="description-section">
							<span class="pdp-label"><?php echo $tab_details; ?></span>
							<div><?php echo $theme_options->getProductAttributeText( $product_id, 7 ); ?></div>
						</div>
					<?php } ?>
              
			      </div>
			     </div><!-- End #product -->
			     
		    </div>
    	</div>
    </div>
  </div>

			

			<?php
				//<< Product Option Image PRO module
				if (isset($poip_theme_name) && ($poip_theme_name=='pav_fashion' || $poip_theme_name=='fashion' || $poip_theme_name=='pav_styleshop' || $poip_theme_name=='megashop'
				|| $poip_theme_name == 'lexus_shopping' || $poip_theme_name == 'pav_sportshop' ) ) { ?>
				<script type="text/javascript"><!--
					$('div.product-action').css('top', '-70px');
					$('a.pav-colorbox').css('top', 'auto');
					$('a.pav-colorbox').css('bottom', '-40px');
				--></script>
				<?php }
				// >> Product Option Image PRO module
				?>
      

      <!-- Product Option Image PRO module << -->
      <?php
				if ( !empty($poip_installed) ) {  
					
					if ( !empty($poip_inclide_file_name_default) ) {
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($poip_inclide_file_name_default) ) );
						} else {
							include( modification($poip_inclide_file_name_default) );
						}
					}
					if ( !empty($poip_inclide_file_name_custom) ) {
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($poip_inclide_file_name_custom) ) );
						} else {
							include( modification($poip_inclide_file_name_custom) );
						}
					} else { // no custom (owerwise it was created in custom file)
						?>
						<script  type = "text/javascript" ><!--
							if ( typeof(poip_product_default) != 'undefined' ) { 
								var poip_product = new poip_product_default();
							}
						//--></script>
						<?php
					}
					
				}
			?>
      <!-- >> Product Option Image PRO module -->
      
<!-- << Related Options / Связанные опции  -->
			
			<?php if ( !empty($ro_installed) ) { ?>
			
				<?php if ( !empty($ro_data) || !empty($ro_settings['show_clear_options']) ) { // the common part and the part for option reset ?> 
					<style>
						.ro_option_disabled { color: #e1e1e1!important; }
					</style>
				
					<?php if ( empty($ro_custom_selectbox_script_included) ) { ?>
						<?php if ( $ro_theme_name == 'theme625' || $ro_theme_name == 'theme628' || $ro_theme_name == 'theme638' || $ro_theme_name == 'theme649' || $ro_theme_name == 'theme707' || $ro_theme_name == 'theme725' || $ro_theme_name == 'themeXXX' ) { ?>
							<script src="catalog/view/theme/<?php echo $ro_theme_name; ?>/js/jquery.selectbox-0.2.min.js" type="text/javascript"></script>
							<style>
								<?php if ( $ro_theme_name == 'theme725' ) { ?>
									.sbDisabled { padding-left:10px; padding-top:8px; padding-bottom:8px; opacity:0.4; line-height:32px; }
								<?php } else { ?>
									.sbDisabled { padding-left:10px; padding-top:8px; padding-bottom:8px; opacity:0.4; line-height:37px; }
								<?php } ?>
							</style>
							<?php
								$ro_custom_selectbox_script_included = true;
							?>
						<?php } ?>
					<?php } ?>	
	
					<?php
						$ro_tpl_common_js = 'catalog/view/extension/related_options/tpl/product_page_common.tpl';
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($ro_tpl_common_js) ) );
						} else {
							include( modification($ro_tpl_common_js) );
						}	
					?>
				
				<?php } // the common part and the part for option reset ?>
				
				
				<?php if ( !empty($ro_data) ) { // the part when the product has related options ?>
					
					<?php
						$ro_tpl_ro_js = 'catalog/view/extension/related_options/tpl/product_page_related_options.tpl';
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($ro_tpl_ro_js) ) );
						} else {
							include( modification($ro_tpl_ro_js) );
						}	
					?>
					
				<?php } // the part for related options ?>	
				
				<?php if ( !empty($ro_data) || !empty($ro_settings['show_clear_options']) ) {	?>
					<script type="text/javascript">
					
					(function(){	
						var ro_params = {};
						ro_params['ro_settings'] = <?php echo json_encode($ro_settings); ?>;
						ro_params['ro_data'] = <?php echo json_encode($ro_data); ?>;
						ro_params['ro_theme_name'] = '<?php echo $ro_theme_name; ?>';
						<?php if ( isset($ros_to_select) && $ros_to_select ) { ?>
							ro_params['ros_to_select'] = <?php echo json_encode($ros_to_select); ?>;
						<?php } elseif (isset($_GET['filter_name'])) { ?>
							ro_params['filter_name'] = '<?php echo $_GET['filter_name']; ?>';
						<?php } elseif (isset($_GET['search'])) { ?>
							ro_params['filter_name'] = '<?php echo $_GET['search']; ?>';
						<?php } ?>
						<?php if ( isset($poip_ov) ) { ?>
							ro_params['poip_ov'] = '<?php echo $poip_ov; ?>';
						<?php } ?>
						
						var $container_of_options = $('body');
						<?php if ( $ro_theme_name == 'themeXXX' || $ro_theme_name == 'theme725' ) { ?>
							if ( $('.ajax-quickview').length ) {
								var $container_of_options = $('.ajax-quickview');
							}
						<?php } elseif ( $ro_theme_name == 'revolution') { ?>
							if ( $('#purchase-form').length ) { // quickorder
								var $container_of_options = $('#purchase-form');
							} else if ( $('#popup-view-wrapper').length ) { // quickview	
								var $container_of_options = $('#popup-view-wrapper');
							}	else if ( $('.product-info').length ) { // product page
								var $container_of_options = $('.product-info');
							}
						<?php } ?>
						
						var ro_instance = $container_of_options.liveopencart_RelatedOptions(ro_params);
						
						ro_instance.common_fn = ro_getCommonFunctions(ro_instance);
						ro_instance.common_fn.initBasic();
							
						<?php if ( !empty($ro_data) ) { // the part when the product has related options ?>
						
							var spec_fn = ro_getSpecificFunctions(ro_instance);
						
							// to custom
							ro_instance.use_block_options = ($('a[id^=block-option][option-value]').length || $('a[id^=block-image-option][option-value]').length || $('a[id^=color-][optval]').length);
							
							ro_instance.bind('setOptionValue_after.ro', spec_fn.event_setOptionValue_after);
							ro_instance.bind('init_after.ro', spec_fn.event_init_after);
							ro_instance.bind('setAccessibleOptionValues_select_after.ro', spec_fn.event_setAccessibleOptionValues_select_after);
							ro_instance.bind('setAccessibleOptionValues_radioUncheck_after.ro', spec_fn.event_setAccessibleOptionValues_radioUncheck_after);
							ro_instance.bind('setAccessibleOptionValues_radioToggle_after.ro', spec_fn.event_setAccessibleOptionValues_radioToggle_after);
							ro_instance.bind('setAccessibleOptionValues_radioEnableDisable_after.ro', spec_fn.event_setAccessibleOptionValues_radioEnableDisable_after);
							ro_instance.bind('setSelectedCombination_withAccessControl_after.ro', spec_fn.event_setSelectedCombination_withAccessControl_after);
							ro_instance.bind('controlAccessToValuesOfAllOptions_after.ro', spec_fn.event_controlAccessToValuesOfAllOptions_after);
							
							ro_instance.custom_radioToggle = spec_fn.custom_radioToggle;
							ro_instance.custom_radioEnableDisable = spec_fn.custom_radioEnableDisable;
							
							ro_instance.sstore_setOptionsStyles = spec_fn.sstore_setOptionsStyles;
							
							ro_instance.spec_fn = spec_fn;
							
						<?php } ?>
						
						ro_instance.initRO();
					
					})();
					
					</script>
				
				<?php } ?>
				
			<?php } ?>

<!-- >> Related Options / Связанные опции  -->
			<?php /* Product Option Image PRO for quickview <?php echo $footer; ?> */  ?>
			
      
<script type="text/javascript"><!--
    $(document).ready(function() {     
        // Form Styler
        setTimeout(function() {
            $('.styleme').styler();
        }, 100) 
    });
//--></script>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			
			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
// << Related Options / Связанные опции 
	<?php
		
		if ( !empty($ro_installed) ) {
			if (isset($ro_settings['stock_control']) && $ro_settings['stock_control'] && isset($ro_data) && $ro_data ) {
	?>
	
		if (!$('#button-cart').attr('allow_add_to_cart')) {
			if ( window.liveopencart && window.liveopencart.related_options_instances && window.liveopencart.related_options_instances.length ) {
				var ro_instances = window.liveopencart.related_options_instances;
				for ( var i_ro_instances in ro_instances ) {
					if ( !ro_instances.hasOwnProperty(i_ro_instances) ) continue;
					
					var ro_instance = ro_instances[i_ro_instances];
					if ( ro_instance.spec_fn && typeof(ro_instance.spec_fn.stockControl) == 'function' ) {
						// currently this function should exist only for one instance (product page)
						ro_instance.spec_fn.stockControl(1);
						return;
					}
					
				}
			}
			//ro_stock_control(1);
			//return;
		}
		$('#button-cart').attr('allow_add_to_cart','');
		
	<?php
			}
		}
	?>
			
// >> Related Options / Связанные опции  
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}
				
				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}
				
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
					
			if (json['success']) {
  
				parent.$.notify({
					message: json['success'],
					target: '_blank'
				},{
					// settings
					element: 'body',
					position: null,
					type: "info",
					allow_dismiss: true,
					newest_on_top: false,
					placement: {
						from: "top",
						align: "right"
					},
					offset: 20,
					spacing: 10,
					z_index: 2031,
					delay: 5000,
					timer: 1000,
					url_target: '_blank',
					mouse_over: null,
					animate: {
						enter: 'animated fadeInDown',
						exit: 'animated fadeOutUp'
					},
					onShow: null,
					onShown: null,
					onClose: null,
					onClosed: null,
					icon_type: 'class',
					template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
						'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
						'<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
						'<div class="progress" data-notify="progressbar">' +
							'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
						'</div>' +
						'<a href="{3}" target="{4}" data-notify="url"></a>' +
					'</div>' 
				});
                
                /*
                $("#notification-popupmaster .modal-footer").show();
				$("#notification-popupmaster").modal('show');
				$("#notification-popupmaster .modal-body p").html(json['success']);	
				*/
                
				parent.$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
				parent.$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
				parent.$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
			}
		}
	});
});
//--></script> 

<script type="text/javascript"><!--
	$('#button-wishlist').on('click', function() {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + <?php echo $product_id; ?>,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					$.notify({
						message: json['success'],
						target: '_blank'
					},{
						element: 'body',
						position: null,
						type: "info",
						allow_dismiss: true,
						newest_on_top: false,
						placement: {
							from: "top",
							align: "right"
						},
						offset: 20,
						spacing: 10,
						z_index: 2031,
						delay: 5000,
						timer: 1000,
						url_target: '_blank',
						mouse_over: null,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						},
						onShow: null,
						onShown: null,
						onClose: null,
						onClosed: null,
						icon_type: 'class',
						template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
							'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
							'<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
							'<div class="progress" data-notify="progressbar">' +
								'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
							'</div>' +
							'<a href="{3}" target="{4}" data-notify="url"></a>' +
						'</div>' 
					});
				}   
				
				if (json['info']) {
					$.notify({
						message: json['info'],
						target: '_blank'
					},{
						// settings
						element: 'body',
						position: null,
						type: "info",
						allow_dismiss: true,
						newest_on_top: false,
						placement: {
							from: "top",
							align: "right"
						},
						offset: 20,
						spacing: 10,
						z_index: 2031,
						delay: 5000,
						timer: 1000,
						url_target: '_blank',
						mouse_over: null,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						},
						onShow: null,
						onShown: null,
						onClose: null,
						onClosed: null,
						icon_type: 'class',
						template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-info" role="alert">' +
							'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
							'<span data-notify="message"><i class="fa fa-info"></i>&nbsp; {2}</span>' +
							'<div class="progress" data-notify="progressbar">' +
								'<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
							'</div>' +
							'<a href="{3}" target="{4}" data-notify="url"></a>' +
						'</div>' 
					});
				}   
				
				$('#wishlist-total').html(json['total']);
			}
		});
	});
//--></script>


<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
		
$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;
	
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();
					
					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}
					
					if (json['success']) {
						alert(json['success']);
						
						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 

<script type="text/javascript">
var ajax_price = function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/liveprice/index',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
			success: function(json) {
			if (json.success) {
				change_price('#price-special', json.new_price.special);
				change_price('#price-tax', json.new_price.tax);
				change_price('#price-old', json.new_price.price);
			}
		}
	});
}

var change_price = function(id, new_price) {
	$(id).html(new_price);
}

$('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\'], .product-info input[type=\'checkbox\'], .product-info select, .product-info textarea, .product-info input[name=\'quantity\']').on('change', function() {
	ajax_price();
});
</script>

</body>
</html>
