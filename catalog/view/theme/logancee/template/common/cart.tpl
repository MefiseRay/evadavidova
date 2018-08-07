<?php if($registry->has('theme_options') == true) { 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$cart_info = $theme_options->getCart(); ?>

<div class="typo-top-cart" id="cart_block">
     <div class="typo-maincart">
          <div class="typo-cart">
               <div class="typo-icon-ajaxcart">
                    <a class="typo-cart-label" href="<?php echo $cart; ?>">
                         <span class="icon-cart"><i class="im im-basket"></i></span>
                         <span class="print">
                              <span class="items">
                                   <span class="qty-cart" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?></span></span> 
                                   <span><?php if($theme_options->get( 'items_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'items_text', $config->get( 'config_language_id' ) )); } else { echo 'item(s)'; } ?></span>
                              </span>
                              
                              <span>-</span> 
                              <span>
                                   <span class="price" id="total_price_ajax"><span id="total_price"><?php echo $cart_info['total_price']; ?></span></span>
                              </span>
                         </span>
                         <span class="icon-dropdown"><i class="fa fa-angle-down"></i></span>
                    </a>
               </div>
               
               <div class="ajaxcart" id="cart_content"><div id="cart_content_ajax">
                    <div class="ajax-over" id="ajaxcart-scrollbar">
                         <div class="typo-ajax-container">
                              <?php if ($products || $vouchers) { ?>
                              <ul class="clearfix">
                                   <?php foreach ($products as $product) { ?>
                                   <li class="item">
                                        <?php if ($product['thumb']) { ?>
                                        <a href="<?php echo $product['href']; ?>" title="London t-shirt" class="product-image"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"/>
                                        <span class="qty-count"><?php echo $product['quantity']; ?>x</span></a>
                                        <?php } ?>
                                        <div class="product-details show-grid">
                                             <p class="product-name clearfix"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
                                             <div class="items clearfix"><span class="price"><?php echo $product['total']; ?></span></div>
                                             <div class="access clearfix"><a ref="javascript:;" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove deletecart"><i aria-hidden="true" class="icon_close"></i></a></div>
                                        </div>
                                   </li>
                                   <?php } ?>
                                   
                                   <?php foreach ($vouchers as $voucher) { ?>
                                   <li class="item">
                                        <div class="product-details show-grid">
                                             <p class="product-name clearfix"><?php echo $voucher['description']; ?></p>
                                             <div class="items clearfix"><span class="price"><?php echo $voucher['amount']; ?></span></div>
                                             <div class="access clearfix"><a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove deletecart"><i aria-hidden="true" class="icon_close"></i></a></div>
                                        </div>
                                   </li>
                                   <?php } ?>
                              </ul>
                              
                              <?php $left = false; $right = false; foreach ($totals as $total) { ?>
                                   <?php $left = $total['title']; $right = $total['text']; ?>
                              <?php } ?>
                              <p class="subtotal"><span class="title"><?php echo $left; ?></span> <span class="price"><?php echo $right; ?></span></p>
                              
                              <div class="typo-ajax-checkout clearfix">
                                   <a href="<?php echo $cart; ?>" class="button view-cart"><span><?php echo $text_cart; ?></span></a>
                                   <a class="button view-checkout" href="<?php echo $checkout; ?>"><span><?php echo $text_checkout; ?></span></a>
                              </div>
                              <?php } else { ?>
                              <p class="no-items-in-cart"><?php echo $text_empty; ?></p>
                              <?php } ?>
                         </div>
                    </div>
               </div></div>
          </div>
     </div>
</div>
<?php } ?>
