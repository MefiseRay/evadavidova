<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
$page_direction = $theme_options->get( 'page_direction' );
include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/wrapper_top.tpl');

$product_detail = $theme_options->getDataProduct( $product_id );
$text_new = 'New';
if($theme_options->get( 'latest_text', $config->get( 'config_language_id' ) ) != '') {
    $text_new = $theme_options->get( 'latest_text', $config->get( 'config_language_id' ) );
} ?>

<div itemscope itemtype="http://schema.org/Product">
  <span itemprop="name" class="hidden"><?php echo $heading_title; ?></span>
  <div class="product-info">
  	<div class="row">
  		<div class="col-sm-12">
  			<div class="row" id="quickview_product">
			    <?php if($theme_options->get( 'product_image_zoom' ) != 2) { ?>
			    <script>
			    	$(document).ready(function(){
			    	     if($(window).width() > 992) {
     			    		<?php if($theme_options->get( 'product_image_zoom' ) == 1) { ?>
     			    			$('#image, .zoom').elevateZoom({
     			    				zoomType: "inner",
     			    				cursor: "pointer",
     			    				zoomWindowFadeIn: 500,
     			    				zoomWindowFadeOut: 750
     			    			});                                                                                                                
     			    		<?php } else { ?>
     				    		$('#image, .zoom').elevateZoom({
     								zoomWindowFadeIn: 500,
     								zoomWindowFadeOut: 500,
     								zoomWindowOffetx: 20,
     								zoomWindowOffety: -1,
     								cursor: "pointer",
     								lensFadeIn: 500,
     								lensFadeOut: 500,
     				    		});
     			    		<?php } ?>
     			    		/*
     			    		var z_index = 0;
     			    		
     			    		$(document).on('click', '.open-popup-image', function () {
     			    		  $('.popup-gallery').magnificPopup('open', z_index);
     			    		  return false;
     			    		});
     			    		*/
     			    		  $('.open-popup-image').magnificPopup({
							  type: 'image',
							  closeOnContentClick: true,
							  image: {
								verticalFit: true
							  }
							});

     			    		
     			    		
			    		/*
     			    		$('.thumbnails a, .thumbnails-carousel a').click(function() {
     			    			var smallImage = $(this).attr('data-image');
     			    			var largeImage = $(this).attr('data-zoom-image');
     			    			var ez =   $('#image').data('elevateZoom');	
     			    			$('#ex1').attr('href', largeImage);  
     			    			ez.swaptheimage(smallImage, largeImage); 
     			    			z_index = $(this).index('.thumbnails a, .thumbnails-carousel a');
     			    			return false;
     			    		});
                         */     
                             
                        $('.airSticky2').hcSticky({
                            top: 70,
							stickTo: '#quickview_product'
						});
                             
                             
						$('.airSticky').stickyfloat( {duration: 400, startOffset:80} );
                        
                         
                           $(document).on("scroll", function(e){
								onScroll;
							});
                             
                            var menu_selector = ".thumbnails-left";
                             
                            function onScroll(){
                                var scroll_top = $(document).scrollTop();
                                $(menu_selector + " a").each(function(){
                                    var hash = $(this).data("class");
                                    var target = $('.' + hash);
                                    if (target.position().top <= scroll_top && target.position().top + target.outerHeight() > scroll_top) {
                                        $(menu_selector + " a.active").removeClass("active");
                                        $(this).addClass("active");
                                    } else {
                                        $(this).removeClass("active");
                                    }
                                });
                            }
                            
                            function goToImage(el){

                                $(document).off("scroll");
                                $(menu_selector + " a.active").removeClass("active");
                                el.addClass("active");
                                var hash = '.' + el.data("class");
                                var target = $(hash);

								var delay = 500;

								if ($('.popup-gallery').offset().top == target.offset().top) {
									delay = 0;
								} 
	
                                $("html, body").animate({
                                    scrollTop: target.offset().top-70
                                }, delay, "linear", function(){
                                    //window.location.hash = hash;
                                    $(document).on("scroll", onScroll);
                                });
                            }
                                                        
                            $(".thumbnails li a").click(function(e){
                                e.preventDefault();

								goToImage($(this));
                            });
           
			    		} else {
			    			$(document).on('click', '.open-popup-image', function () {
			    			  $('.popup-gallery .col-sm-10').magnificPopup('open', 0);
			    			  return false;
			    			});
			    		}
			    	});
			    </script>
			    <?php } ?>
			    <?php $image_grid = 6; $product_center_grid = 6; 
			    if ($theme_options->get( 'product_image_size' ) == 1) {
			    	$image_grid = 4; $product_center_grid = 8;
			    }
			    
			    if ($theme_options->get( 'product_image_size' ) == 3) {
			    	$image_grid = 8; $product_center_grid = 4;
			    }
			    ?>
			    <div class="col-sm-<?php echo $image_grid; ?> popup-gallery">
			      <?php 
			      $product_image_top = $modules_old_opencart->getModules('product_image_top');
			      if( count($product_image_top) ) { 
			      	foreach ($product_image_top as $module) {
			      		echo $module;
			      	}
			      } ?>
			         			         
			      <div class="row">
			      	  <?php if (($images || $theme_options->get( 'product_image_zoom' ) != 2) && $theme_options->get( 'position_image_additional' ) == 2) { ?>
			      	  <div class="airSticky col-sm-2 hidden-xs">
						<div class=" image-additional thumbnails thumbnails-left clearfix">
							<ul>
						      <?php $i=1; foreach ($images as $image) { ?>
						      <li class="image-option-<?php echo $image['product_option_id']; ?>-<?php echo $image['product_option_value_id']; ?>" style="<?php echo (!$image['default_value'] ? 'display:none' : '' ); ?>"><div class='item'><a href="<?php echo $image['popup']; ?>" class="popup-image"  data-class="image-<?php echo $i++; ?>" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div></li>
						      <?php } ?>
						  </ul>
						</div>
			      	  </div>
			      	  <?php } ?>
			      	  
				      <div class="col-sm-<?php if($theme_options->get( 'position_image_additional' ) == 2) { echo 10; } else { echo 12; } ?>">

                         <?php $i=1; foreach ($images as $image) { ?>
					  	    <div class="product-image" data-toggle="modal" data-target=".productDetail-modalSlider">
                                  <?php if ($i == 1) { ?>
                                     <img src="<?php echo $image['image']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" class="image-<?php echo $i++; ?>" id="image" itemprop="image" data-zoom-image="<?php echo $image['popup']; ?>" />
                                <?php } else { ?>
                                       <img src="<?php echo $image['image']; ?>" title="<?php echo $heading_title; ?>" class="zoom image-<?php echo $i++; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $image['popup']; ?>" />
                                 <?php } ?>   
                             </div>
     			          <?php } ?>
				      </div>
  
				      <?php if (($images || $theme_options->get( 'product_image_zoom' ) != 2) && $theme_options->get( 'position_image_additional' ) != 2) { ?>
				      <div class="col-sm-12">
				           <div class="overflow-thumbnails-carousel">
     					      <div class="thumbnails-carousel owl-carousel">
     					      	<?php if($theme_options->get( 'product_image_zoom' ) != 2 && $thumb) { ?>
     					      	     <div class="item"><a href="<?php echo $popup; ?>" class="popup-image" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $theme_options->productImageThumb($product_id, $config->get($config->get('config_theme') . '_image_additional_width'), $config->get($config->get('config_theme') . '_image_additional_height')); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
     					      	<?php } ?>
     						     <?php foreach ($images as $image) { ?>
     						         <div class="item">
     						             <a href="<?php echo $image['popup']; ?>" class="popup-image" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>">
     						                 <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
     						             </a>
     						         </div>
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
					                   [768, 3],
					                   [1200, 4]
					                 ],
					                 <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
					                 direction: 'rtl'
					                 <?php endif; ?>
					             });
					           });
					      </script>
				      </div>
				      <?php } ?>

				      <!-- Modal -->
<div class="modal fade productDetail-modalSlider" tabindex="-1" role="dialog" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="productFullscreen">
            <button type="button" class="button-white-circle modal-close-action modal-close-action-productFullscreen close float-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <!-- sliderProductModule -->
            <div class="sliderProductModule">
                
                <div class="owl-carousel" data-slider-id="1">

                     <?php $i=1; foreach ($images as $image) { ?>
                                   <img src="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="modal-slide image-<?php echo $i++; ?>" alt="<?php echo $heading_title; ?>" />
     			          <?php } ?>
</div>
<div class="bx-pager-thumbFull owl-thumbs" data-slider-id="1">
     						     <?php foreach ($images as $image) { ?>
     						                 <img src="<?php echo $image['thumb']; ?>" data-big-image="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
     						     <?php } ?>
</div>
                
                	      <script type="text/javascript">
					          $(document).ready(function(){
  $('.owl-carousel').owlCarousel({
      items: 1,
      loop: true,
      nav:true,
      navText: ['',''],
      dots: false,
    thumbs: true,
    thumbsPrerendered: true
  });
});
					      </script>
                <!-- sliderProduct -->
            </div>
            <!-- sliderProductModule -->
        </div>
    </div>
</div>
				     <script type="text/javascript" src="catalog/view/theme/logancee/js/slider.js"></script> 
			      </div>
			      
			      <?php 
			      $product_image_bottom = $modules_old_opencart->getModules('product_image_bottom');
			      if( count($product_image_bottom) ) { 
			      	foreach ($product_image_bottom as $module) {
			      		echo $module;
			      	}
			      } ?>
			    </div>

            
			    <div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
			    <div class="">
			    <div class="airSticky2 commerce-area-wrapper">
			     <div itemprop="offerDetails" itemscope itemtype="http://schema.org/Offer">
			     <h1 class="product-name"><?php echo $heading_title; ?></h1>
			     <span class="model"><?php echo $text_model; ?> <?php echo $model; ?></span>
			      <?php 
			      $product_options_top = $modules_old_opencart->getModules('product_options_top');
			      if( count($product_options_top) ) { 
			      	foreach ($product_options_top as $module) {
			      		echo $module;
			      	}
			      } ?>
			      
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
			      </div>
			      
	             <div id="product">
			      <?php 
			      $product_options_center = $modules_old_opencart->getModules('product_options_center');
			      if( count($product_options_center) ) { 
			      	foreach ($product_options_center as $module) {
			      		echo $module;
			      	}
			      } ?>
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
			      
			      <div class="cart ">
			        <div class="add-to-cart clearfix">
			          <?php 
			          $product_enquiry = $modules_old_opencart->getModules('product_enquiry');
			          if( count($product_enquiry) ) { 
			          	foreach ($product_enquiry as $module) {
			          		echo $module;
			          	}
			          } else { ?>
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
			        
			        <?php 
     			          $product_question = $modules_old_opencart->getModules('product_question');
     			          if( count($product_question) ) { 
     			          	foreach ($product_question as $module) {
     			          		echo $module;
     			          	}
     			    } ?>
     			    <div class="description-section ">
                        <span class="pdp-label"><?php echo $tab_description; ?></span>
     			        <div itemprop="description"><?php echo $description; ?></div>
                    </div>
                    
                    <?php $details = $theme_options->getProductAttributeText( $product_id, 13 ); ?>
                    <?php if ($details) { ?>
						<div class="description-section">
							<span class="pdp-label"><?php echo $tab_details; ?></span>
							<div><?php echo $details; ?></div>
						</div>
					<?php } ?>
     			    
			        <?php $product_custom_block = $modules_old_opencart->getModules('product_custom_block'); ?>
			        <?php if($theme_options->get( 'custom_block', 'product_page', $config->get( 'config_language_id' ), 'status' ) == 1 || count($product_custom_block)) { ?>                                         
                        <div class="panel-group additional-info" id="collapse-group">
                        <?php if($theme_options->get( 'custom_block', 'product_page', $config->get( 'config_language_id' ), 'status' ) == 1) { ?>
                            <div class="panel panel-default">
                                <?php if($theme_options->get( 'custom_block', 'product_page', $config->get( 'config_language_id' ), 'heading' ) != '') { ?>
                                    <h4 class="panel-heading"><a class="popup-modal" href="#el1"><?php echo $theme_options->get( 'custom_block', 'product_page', $config->get( 'config_language_id' ), 'heading' ); ?> <i class="icon_plus" aria-hidden="true"></i></a></h4>
                                <?php } ?>
                                <div id="el1" class="mfp-hide white-popup-block">
                                    <div class="panel-body"><?php echo html_entity_decode($theme_options->get( 'custom_block', 'product_page', $config->get( 'config_language_id' ), 'text' )); ?></div>
                                </div>
                            </div>
                       <?php } ?>
                      </div>
                      <script type="text/javascript">
                            $(document).ready(function() {
								$('.popup-modal').magnificPopup({
								  type: 'inline',
								  preloader: false,
								});
                            });
                      </script>
                       <?php foreach ($product_custom_block as $module) { echo $module; } ?>
                    <?php } ?>
			         
			        <?php if ($minimum > 1) { ?>
			        <div class="minimum"><?php echo $text_minimum; ?></div>
			        <?php } ?>
			      </div>
			     </div><!-- End #product -->
			      
			      <?php 
			      $product_options_bottom = $modules_old_opencart->getModules('product_options_bottom');
			      if( count($product_options_bottom) ) { 
			      	foreach ($product_options_bottom as $module) {
			      		echo $module;
			      	}
			      } ?>
		    	</div>
		     </div>
		     </div>
		    </div>
    	</div>
    </div>
  </div>
  
  <?php 
  $product_over_tabs = $modules_old_opencart->getModules('product_over_tabs');
  if( count($product_over_tabs) ) { 
  	foreach ($product_over_tabs as $module) {
  		echo $module;
  	}
  } ?>
  
  <?php 
  	  $language_id = $config->get( 'config_language_id' );
	  $tabs = array();
	  	  	   
	  if(is_array($config->get('product_tabs'))) {
		  foreach($config->get('product_tabs') as $tab) {
		  	if($tab['status'] == 1 || $tab['product_id'] == $product_id) {
		  		foreach($tab['tabs'] as $zakladka) {
		  			if($zakladka['status'] == 1) {
		  				$heading = false; $content = false;
		  				if(isset($zakladka[$language_id])) {
		  					$heading = $zakladka[$language_id]['name'];
		  					$content = html_entity_decode($zakladka[$language_id]['html']);
		  				}
		  				$tabs[] = array(
		  					'heading' => $heading,
		  					'content' => $content,
		  					'sort' => $zakladka['sort_order']
		  				);
		  			}
		  		}
		  	}
		  }
	  }
	  
	  usort($tabs, "cmp_by_optionNumber");
  ?>
  <div id="tabs" class="htabs">
  	<?php $i = 0; foreach($tabs as $tab) { $i++;
  		$id = 'tab_'.$i;
  		echo '<a href="#'.$id.'">'.$tab['heading'].'</a>';
  	} ?>
  </div>
  <?php $i = 0; foreach($tabs as $tab) { $i++;
  	$id = 'tab_'.$i;
    echo '<div id="'.$id.'" class="tab-content">'.$tab['content'].'</div>';
  } ?>
  
    <?php if ($products && $theme_options->get( 'product_related_status' ) != '0') { ?>
  <?php 
  $class = 3; 
  $id = rand(0, 5000)*rand(0, 5000); 
  $all = 4; 
  $row = 4; 
  
  if($theme_options->get( 'product_per_pow' ) == 6) { $class = 2; }
  if($theme_options->get( 'product_per_pow' ) == 5) { $class = 25; }
  if($theme_options->get( 'product_per_pow' ) == 3) { $class = 4; }
  
  if($theme_options->get( 'product_per_pow' ) > 1) { $row = $theme_options->get( 'product_per_pow' ); $all = $theme_options->get( 'product_per_pow' ); } 
  ?>
  <div class="box clearfix <?php if($theme_options->get( 'product_scroll_related' ) != '0') { echo 'with-scroll'; } ?>">
    <?php if($theme_options->get( 'product_scroll_related' ) != '0') { ?>
    <!-- Carousel nav -->
    <a class="next" href="#myCarousel<?php echo $id; ?>" id="myCarousel<?php echo $id; ?>_next"><span></span></a>
    <a class="prev" href="#myCarousel<?php echo $id; ?>" id="myCarousel<?php echo $id; ?>_prev"><span></span></a>
    <?php } ?>
  	
    <div class="box-heading"><?php echo $text_related; ?></div>
    <div class="strip-line"></div>
    <div class="box-content products related-products">
      <div class="box-product">
      	<div id="myCarousel<?php echo $id; ?>" <?php if($theme_options->get( 'product_scroll_related' ) != '0') { ?>class="carousel slide"<?php } ?>>
      		<!-- Carousel items -->
      		<div class="owl-carousel">
      			<?php $i = 0; $row_fluid = 0; $item = 0; foreach ($products as $product) { $row_fluid++; ?>
  	    			<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
  	    			<?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { if($theme_options->get( 'product_scroll_related' ) != '0') { echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">'; $item++; } else { echo '</div><div class="row">'; } } else { $r=$row_fluid-floor($row_fluid/$row)*$row; if($row_fluid>$row && $r == 1) { echo '</div><div class="row">'; } } ?>
  	    			<div class="col-sm-<?php echo $class; ?> col-xs-6">
  	    				<?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
  	    			</div>
      			<?php $i++; } ?>
      			<?php if($i > 0) { echo '</div></div></div>'; } ?>
      		</div>
  	  </div>
      </div>
    </div>
  </div>
  
  <?php if($theme_options->get( 'product_scroll_related' ) != '0') { ?>
  <script type="text/javascript">
  $(document).ready(function() {
    var owl<?php echo $id; ?> = $(".box #myCarousel<?php echo $id; ?> .owl-carousel");
  	
    $("#myCarousel<?php echo $id; ?>_next").click(function(){
        owl<?php echo $id; ?>.trigger('next.owl.carousel');
        return false;
      })
    $("#myCarousel<?php echo $id; ?>_prev").click(function(){
        owl<?php echo $id; ?>.trigger('prev.owl.carousel');
        return false;
    });
      
    owl<?php echo $id; ?>.owlCarousel({
          items: 1,
          dots: false,
     });
  });
  </script>
  <?php } ?>
  <?php } ?>
  
  
  <?php if ($review_status) { ?>
  <div class="box clearfix" id="tab-review">
    <div class="box-heading"><?php echo $tab_review; ?></div>
	<form class="form-horizontal" id="form-review">
	  <?php if($rating > 0) { ?>
		  <?php if ($review_guest) { ?> 
			  <div class="clearfix">
				<div onclick="$('html, body').animate({scrollTop:$('#review-form').offset().top - 80}, '500', 'swing');" class="btn btn-default pull-right">Оставить отзыв</div>
			  </div>
		  <?php } ?>
		  <div class="product-filter clearfix">
			<div class="pull-left">
				<div class="bv-results">
				
				</div>
			</div>
			<div class="list-options pull-right">
				<div class="bv-dropdown">
					<div class="bv-dropdown-target"> 
						<span class="bv-dropdown-title"> Sort </span> <span class="bv-dropdown-arrow" aria-hidden="true" role="presentation"> ▼ </span>
					</div>
					<div class="bv-dropdown-select">
						<ul class="bv-dropdown-content"> 
							<li data-sort="rating" data-order="ASC"> Highest to Lowest Rating </li> 
							<li data-sort="rating" data-order="DESC"> Lowest to Highest Rating </li> 
							<li data-sort="date_added" data-order="DESC"> Most Recent </li> 
						</ul>
					</div>
				</div>
			</div> 
		  </div> 
	  <?php } ?>
	  
	  <div id="review"></div>
	  <h2><?php echo $text_write; ?></h2>
	  <?php if ($review_guest) { ?>
	  <div id="review-form" class="form-group required">
	    <div class="col-sm-12">
	      <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
	      <input type="text" name="name" value="" id="input-name" class="form-control" />
	    </div>
	  </div>
	  <div class="form-group required">
	    <div class="col-sm-12">
	         <label class="control-label"><?php echo $entry_rating; ?></label>
	        
	       <div class="rating set-rating">
	          <i class="fa fa-star" data-value="1"></i>
	          <i class="fa fa-star" data-value="2"></i>
	          <i class="fa fa-star" data-value="3"></i>
	          <i class="fa fa-star" data-value="4"></i>
	          <i class="fa fa-star" data-value="5"></i>
	      </div>
	      <script type="text/javascript">
	          $(document).ready(function() {
	            $('.set-rating i').hover(function(){
	                var rate = $(this).data('value');
	                var i = 0;
	                $('.set-rating i').each(function(){
	                    i++;
	                    if(i <= rate){
	                        $(this).addClass('active');
	                    }else{
	                        $(this).removeClass('active');
	                    }
	                })
	            })
	            
	            $('.set-rating i').mouseleave(function(){
	                var rate = $('input[name="rating"]:checked').val();
	                rate = parseInt(rate);
	                i = 0;
	                  $('.set-rating i').each(function(){
	                    i++;
	                    if(i <= rate){
	                        $(this).addClass('active');
	                    }else{
	                        $(this).removeClass('active');
	                    }
	                  })
	            })
	            
	            $('.set-rating i').click(function(){
	                $('input[name="rating"]:nth('+ ($(this).data('value')-1) +')').prop('checked', true);
	            });
	          });
	      </script>
	      <div class="hidden">
	         &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
	         <input type="radio" name="rating" value="1" />
	         &nbsp;
	         <input type="radio" name="rating" value="2" />
	         &nbsp;
	         <input type="radio" name="rating" value="3" />
	         &nbsp;
	         <input type="radio" name="rating" value="4" />
	         &nbsp;
	         <input type="radio" name="rating" value="5" />
	         &nbsp;<?php echo $entry_good; ?>
	      </div>
	   </div>
	  </div>
	  <div class="form-group required">
	    <div class="col-sm-12">
	      <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
	      <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
	      <div class="help-block"><?php echo $text_note; ?></div>
	    </div>
	  </div>
	  <?php echo $captcha; ?>
	  <div class="buttons clearfix" style="margin-bottom: 0px">
	    <div class="pull-right">
	      <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
	    </div>
	  </div>
	  <?php } else { ?>
	  <?php echo $text_login; ?>
	  <?php } ?>
	</form>
  </div>
  <?php } ?>
  
  <?php if ($tags) { ?>
  <div class="tags_product"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  
</div>

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
	yaCounter48659294.reachGoal('cart');
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
                $("#notification-popupmaster .modal-footer").show();
				$("#notification-popupmaster").modal('show');
				$("#notification-popupmaster .modal-body p").html(json['success']);	
				
				$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
				$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
				$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
    $(document).ready(function() {     
        // Form Styler
        setTimeout(function() {
            $('.styleme').styler();
        }, 100) 
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
<script type="text/javascript"><!--
	
$('.bv-dropdown-select li').on('click', function() {
	$('.bv-dropdown-title').text($(this).text());
	$( "#review" ).load( "index.php?route=product/product/review&product_id=<?php echo $product_id; ?>&sort=" + $(this).data('sort') + "&order=" + $(this).data('order'), function() {
		$('.bv-dropdown-select').css('opacity', '0');
		//alert( "Load was performed." );
	});
});	
	
$('#review').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();
	
    $('#review').fadeOut('slow');
        
    $('#review').load(this.href);
    
    $('#review').fadeIn('slow');
});         

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
    $.ajax({
        url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
        type: 'post',
        dataType: 'json',
        data: $("#form-review").serialize(),
        beforeSend: function() {
            $('#button-review').button('loading');
        },
        complete: function() {
            $('#button-review').button('reset');
        },
        success: function(json) {
			$('.alert-success, .alert-danger').remove();
            
			if (json['error']) {
                $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }
            
            if (json['success']) {
                $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
                                
                $('input[name=\'name\']').val('');
                $('textarea[name=\'text\']').val('');
                $('input[name=\'rating\']:checked').prop('checked', false);
            }
        }
    });
});
</script>


<script type="text/javascript">
var ajax_price = function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/liveprice/index',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
			success: function(json) {
			if (json.success) {
				change_price('#price-tax', json.new_price.tax);
				if (json.new_price.special) {
                    $('.main-price').html('<span class="price-old" id="price-old">' + json.new_price.price + '</span><span class="price-new"><span id="price-special">' + json.new_price.special + '</span></span>');
				} else {
					change_price('#price-old', json.new_price.price);
				}
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

<script type="text/javascript">
$.fn.tabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		$(obj).click(function() {
			$(selector).removeClass('selected');
			
			$(selector).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).show();
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
};
</script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 


<script type="text/javascript"><!--
$(document).ready(function() {        
var tempScrollTop, currentScrollTop = 0;
    

$(window).scroll(function(){
    
    var productDetailsBlock = $(".commerce-area-wrapper").offset();
    var productDetailsBlockEnd = productDetailsBlock.top + $(".commerce-area-wrapper").height();
    
    var productImagesBlock = $(".popup-gallery").offset();
    var productImagesBlockEnd = productDetailsBlock.top + $(".commerce-area-wrapper").height();
    
//alert(productDetailsBlockEnd);
currentScrollTop = $("#product").scrollTop();
if (tempScrollTop < currentScrollTop ) {
    alert('down');
} else if (tempScrollTop > currentScrollTop ) {
 alert('up');
}

tempScrollTop = currentScrollTop;
});
        });
//--></script> 
<?php if($theme_options->get( 'product_image_zoom' ) != 2) { 
echo '<script type="text/javascript" src="catalog/view/theme/' . $config->get($config->get('config_theme') . '_directory') . '/js/jquery.elevateZoom-3.0.3.min.js"></script>';
} ?>

<?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>
