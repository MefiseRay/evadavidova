<?php echo $header; 
if(isset($mfilter_json)) {
	if(!empty($mfilter_json)) { 
		echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; 
	} 
}

$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/wrapper_top.tpl'); ?>

<div id="mfilter-content-container">
	<label class="control-label" for="input-search" style="padding-bottom: 5px;"><b><?php echo $entry_search; ?></b></label>
	<div class="row" id="content-search">
	  <div class="col-sm-4">
	    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
	  </div>
	  <div class="col-sm-3">
	    <select name="category_id" class="form-control">
	      <option value="0"><?php echo $text_category; ?></option>
	      <?php foreach ($categories as $category_1) { ?>
	      <?php if ($category_1['category_id'] == $category_id) { ?>
	      <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
	      <?php } else { ?>
	      <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
	      <?php } ?>
	      <?php foreach ($category_1['children'] as $category_2) { ?>
	      <?php if ($category_2['category_id'] == $category_id) { ?>
	      <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
	      <?php } else { ?>
	      <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
	      <?php } ?>
	      <?php foreach ($category_2['children'] as $category_3) { ?>
	      <?php if ($category_3['category_id'] == $category_id) { ?>
	      <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
	      <?php } else { ?>
	      <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
	      <?php } ?>
	      <?php } ?>
	      <?php } ?>
	      <?php } ?>
	    </select>
	  </div>
	  <div class="col-sm-3" style="padding-top: 7px">
	    <label class="checkbox-inline">
	      <?php if ($sub_category) { ?>
	      <input type="checkbox" name="sub_category" value="1" checked="checked" />
	      <?php } else { ?>
	      <input type="checkbox" name="sub_category" value="1" />
	      <?php } ?>
	      <?php echo $text_sub_category; ?></label>
	  </div>
	</div>
	<p>
	  <label class="checkbox-inline">
	    <?php if ($description) { ?>
	    <input type="checkbox" name="description" value="1" id="description" checked="checked" />
	    <?php } else { ?>
	    <input type="checkbox" name="description" value="1" id="description" />
	    <?php } ?>
	    <?php echo $entry_description; ?></label>
	</p>
	<input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" style="margin-top: 10px" />
	<h2 style="padding-top: 40px;padding-bottom:  35px;"><?php echo $text_search; ?></h2>
  
  <?php if ($products) { ?>
  <!-- Filter -->
  <!-- Filter -->
  <div class="product-filter clearfix">
    <?php if ($theme_options->get( 'product_compare_info' ) || $theme_options->get( 'product_view' ) || $theme_options->get( 'product_display' )) { ?>
        <div class="options">
            <?php if ($theme_options->get( 'product_compare_info' )) { ?>
                <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
            <?php } ?>
            
            <?php if ($theme_options->get( 'product_view' )) { ?>
                <div class="product-tile-view">
                    <span class="total"><?php echo $total; ?> </span>
                    <?php echo $text_view; ?> 
                    <?php foreach ($views as $view) { ?>
                        <span onclick="view('<?php echo $view['value']; ?>');" class="<?php echo $view['value']; ?>-tile-view <?php echo ($view['text'] == $theme_options->get( 'product_per_pow2' ) ? 'active' : ''); ?>" aria-label="grid view change <?php echo $view['value']; ?> products" href="#" data-reactid="2806"> <?php echo $view['text']; ?> </span>
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php if ($theme_options->get( 'product_display' )) { ?>
                <div class="button-group display" data-toggle="buttons-radio">
                    <button id="grid" <?php if($theme_options->get('default_list_grid') == '1') { echo 'class="active"'; } ?> rel="tooltip" title="Grid" onclick="display('grid');"><i class="fa fa-th-large"></i></button>
                    <button id="list" <?php if($theme_options->get('default_list_grid') != '1') { echo 'class="active"'; } ?> rel="tooltip" title="List" onclick="display('list');"><i class="fa fa-th-list"></i></button>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
  	<?php if ($theme_options->get( 'product_sort_by' ) || $theme_options->get( 'product_limit' )) { ?>
        <div class="list-options">
            <?php if ($theme_options->get( 'product_sort_by' )) { ?>
                <div class="sort">
                    <?php echo $text_sort; ?>
                    <select onchange="location = this.value;" class="styleme">
                      <?php foreach ($sorts as $sorts) { ?>
                      <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                      <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <?php if ($theme_options->get( 'product_limit' )) { ?>
                <div class="limit">
                    <?php echo $text_limit; ?>
                    <select onchange="location = this.value;">
                      <?php foreach ($limits as $limits) { ?>
                      <?php if ($limits['value'] == $limit) { ?>
                      <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
     <?php } ?>
  </div>
  
  <!-- Products list -->
  <div class="product-list"<?php if(!($theme_options->get('default_list_grid') == '1')) { echo ' class="active"'; } ?>>
  	<?php foreach ($products as $product) { 
  	$product_detail = $theme_options->getDataProduct( $product['product_id'] );
  	$text_new = 'New';
  	if($theme_options->get( 'latest_text', $config->get( 'config_language_id' ) ) != '') {
  	    $text_new = $theme_options->get( 'latest_text', $config->get( 'config_language_id' ) );
  	} ?>
  	<div class="row">
  	     <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
  	          <div class="product-list-img">
  	               <div class="product-show">
  	               	<?php if($product['special'] && $theme_options->get( 'display_text_sale' ) != '0') { ?>
  	               		<?php $text_sale = 'Sale';
  	               		if($theme_options->get( 'sale_text', $config->get( 'config_language_id' ) ) != '') {
  	               			$text_sale = $theme_options->get( 'sale_text', $config->get( 'config_language_id' ) );
  	               		} ?>
  	               		<?php if($theme_options->get( 'type_sale' ) == '1') { ?>
  	               		<?php $product_detail = $theme_options->getDataProduct( $product['product_id'] );
  	               		$roznica_ceny = $product_detail['price']-$product_detail['special'];
  	               		$procent = ($roznica_ceny*100)/$product_detail['price']; ?>
  	               		<div class="sale">-<?php echo round($procent); ?>%</div>
  	               		<?php } else { ?>
  	               		<div class="sale"><?php echo $text_sale; ?></div>
  	               		<?php } ?>
  	               	<?php } ?>
  	               	
  	               	<?php if($product_detail['is_latest'] && $theme_options->get( 'display_text_latest' ) != '0'):?>
  	               	    <div class="new-label"><span><?php echo $text_new; ?></span></div>
  	               	<?php endif; ?>
  	               	
  	                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="product-image">
  	                         <span class="front margin-image">
  	                         	<?php if($product['thumb']) { ?>
  	                         		<?php if($theme_options->get( 'lazy_loading_images' ) != '0') { ?>
  	                         		<img src="image/catalog/blank.gif" data-echo="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
  	                         		<?php } else { ?>
  	                         		<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
  	                         		<?php } ?>
  	                         	<?php } else { ?>
  	                         	<img src="image/no_image.jpg" alt="<?php echo $product['name']; ?>" />
  	                         	<?php } ?>
  	                         </span>
  	                         
  	                         <?php if($theme_options->get( 'product_image_effect' ) == '1') {
  	                         	$nthumb = str_replace(' ', "%20", ($product['thumb']));
  	                         	$nthumb = str_replace(HTTP_SERVER, "", $nthumb);
  	                         	$image_size = getimagesize($nthumb);
  	                         	$image_swap = $theme_options->productImageSwap($product['product_id'], $image_size[0], $image_size[1]);
  	                         	if($image_swap != '') echo '<span class="product-img-additional back margin-image"><img src="' . $image_swap . '" alt="' . $product['name'] . '" class="swap-image" /></span>';
  	                         } ?> 
  	                    </a>
  	                    
  	                    <?php if($theme_options->get( 'quick_view' ) == 1) { ?>
  	                    <div class="category-over product-show-box">
  	                         <div class="main-quickview quickview">  	                              
  	                              <a class="btn show-quickview" href="index.php?route=product/quickview&product_id=<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>"><span><i aria-hidden="true" class="arrow_expand"></i></span></a>
  	                         </div>
  	                    </div>
  	                    <?php } ?>
  	               </div>
  	          </div>
  	     </div>
  	     
  	     <div class="col-xs-8 col-sm-8 col-md-8 col-lg-9">
  	          <div class="product-shop">
  	               <h2 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
  	               <div class="product-value">
  	                    <div class="price-box">
  	                    	<?php if (!$product['special']) { ?>
  	                    	<span class="regular-price"><span class="price"><?php echo $product['price']; ?></span></span>
  	                    	<?php } else { ?>
  	                    	<p class="old-price">
  	                    	     <span class="price"><?php echo $product['price']; ?></span>
  	                    	</p>
  	                    	
  	                    	<p class="special-price">
  	                    	     <span class="price"><?php echo $product['special']; ?></span>
  	                    	</p>
  	                    	<?php } ?>
  	                    </div>
  	                    
  	                    <?php if ($product['rating']) { ?>
  	                    <div class="rating-reviews clearfix">
  	                         <div class="rating"><i class="fa fa-star<?php if($product['rating'] >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($product['rating'] >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($product['rating'] >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($product['rating'] >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($product['rating'] >= 5) { echo ' active'; } ?>"></i></div>
  	                    </div>
  	                    <?php } ?>
  	               </div>
  	               
  	               <div class="desc std"><?php echo $product['description']; ?></div>
  	               <div class="typo-actions clearfix">
  	                    <div class="addtocart">
  	                           <?php $enquiry = false; if($config->get( 'product_blocks_module' ) != '') { $enquiry = $theme_options->productIsEnquiry($product['product_id']); }
  	                           if(is_array($enquiry)) { ?>
  	                           <a href="javascript:openPopup('<?php echo $enquiry['popup_module']; ?>', '<?php echo $product['product_id']; ?>')" class="button button-enquiry">
  	                                <?php if($enquiry['icon'] != '' && $enquiry['icon_position'] == 'left') { echo '<img src="image/' . $enquiry['icon']. '" align="left" class="icon-enquiry" alt="Icon">'; } ?>
  	                                <span class="text-enquiry"><?php echo $enquiry['block_name']; ?></span>
  	                                <?php if($enquiry['icon'] != '' && $enquiry['icon_position'] == 'right') { echo '<img src="image/' . $enquiry['icon']. '" align="right" class="icon-enquiry" alt="Icon">'; } ?>
  	                           </a>
  	                           <?php } else { ?>
  	                           <a onclick="cart.add('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a>
  	                           <?php } ?>
  	                    </div>

  	                    <div class="addtolist">
  	                         <div class="add-to-links">
  	                              <div class="wishlist">
  	                                   <a onclick="wishlist.add('<?php echo $product['product_id']; ?>');" title="" data-toggle="tooltip" data-placement="top" class="link-wishlist" data-original-title="<?php if($theme_options->get( 'add_to_wishlist_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'add_to_wishlist_text', $config->get( 'config_language_id' ) ); } else { echo 'Add to wishlist'; } ?>"><i aria-hidden="true" class="icon_heart_alt"></i></a>
  	                              </div>
  	                              
  	                              <div class="compare">
  	                                   <a rel="nofollow" onclick="compare.add('<?php echo $product['product_id']; ?>');" title="" data-toggle="tooltip" data-placement="top" class="link-compare" data-original-title="<?php if($theme_options->get( 'add_to_compare_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'add_to_compare_text', $config->get( 'config_language_id' ) ); } else { echo 'Add to compare'; } ?>"><i aria-hidden="true" class="icon_piechart"></i></a>
  	                              </div>
  	                         </div>
  	                    </div>
  	               </div>
  	          </div>
  	     </div>
  	</div>
  	<?php } ?>
  </div>
  
  <!-- Products grid -->
  <?php 
  $class = 3; 
  $row = 4; 
  
  if($theme_options->get( 'product_per_pow' ) == 6) { $class = 2; }
  if($theme_options->get( 'product_per_pow' ) == 5) { $class = 25; }
  if($theme_options->get( 'product_per_pow' ) == 3) { $class = 4; }
  
  if($theme_options->get( 'product_per_pow' ) > 1) { $row = $theme_options->get( 'product_per_pow' ); } 
  ?>
  <div class="product-grid"<?php if($theme_options->get('default_list_grid') == '1') { echo ' class="active"'; } ?>>
  	<ul class="product-wrapper product-wrapper-<?php echo $class; ?>-tile">
	  	<?php foreach ($products as $product) { ?>
		  	<li class="product-tile small-6 medium-3">
		  	    <?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
		  	</li>
	    <?php } ?>
    </ul>
  </div>
  
  <div class="row pagination-results">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
  </div>
  <?php } else { ?>
  <p style="padding-bottom: 10px"><?php echo $text_empty; ?></p>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#content-search input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').bind('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').attr('disabled', 'disabled');
		$('input[name=\'sub_category\']').removeAttr('checked');
	} else {
		$('input[name=\'sub_category\']').removeAttr('disabled');
	}
});

$('select[name=\'category_id\']').trigger('change');

$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	
	var search = $('#content-search input[name=\'search\']').attr('value');
	
	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').attr('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').attr('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

function display(view) {

	if (view == 'list') {
		$('.product-grid').removeClass("active");
		$('.product-list').addClass("active");

		$('.display').html('<button id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"><i class="fa fa-th-large"></i></button> <button class="active" id="list" rel="tooltip" title="List" onclick="display(\'list\');"><i class="fa fa-th-list"></i></button>');
		
		localStorage.setItem('display', 'list');
	} else {
	
		$('.product-grid').addClass("active");
		$('.product-list').removeClass("active");
					
		$('.display').html('<button class="active" id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"><i class="fa fa-th-large"></i></button> <button id="list" rel="tooltip" title="List" onclick="display(\'list\');"><i class="fa fa-th-list"></i></button>');
		
		localStorage.setItem('display', 'grid');
	}
}
    
function view(per_row) {
    $('.product-tile-view span').removeClass('active');
    $('.' + per_row + '-tile-view').addClass("active");
    $('.product-wrapper').attr('class','product-wrapper product-wrapper-' + per_row + '-tile');
	
    localStorage.setItem('view', per_row);
}    

if (localStorage.getItem('display') == 'list') {
	display('list');
} else if (localStorage.getItem('display') == 'grid') {
	display('grid');
} else {
	display('<?php if($theme_options->get('default_list_grid') == '1') { echo 'grid'; } else { echo 'list'; } ?>');
}
    
if (localStorage.getItem('view')) {
	view(localStorage.getItem('view'));
}   
//--></script> 
<script type="text/javascript"><!--
    $(document).ready(function() {     
        // Form Styler
        setTimeout(function() {
            $('.styleme').styler();
        }, 100) 
    });
//--></script>
<?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>