<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-google-sitemap" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid bootstrap">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-yandex_market_status" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-category" data-toggle="tab"><?php echo $tab_category; ?></a></li>
            <li><a href="#tab-delivery" data-toggle="tab"><?php echo $tab_delivery; ?></a></li>
            <li><a href="#tab-delivery-product" data-toggle="tab"><?php echo $tab_delivery_product; ?></a></li>
          </ul>
           <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
               <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="yandex_market_status" id="input-status" class="form-control">
                    <?php if ($yandex_market_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_yml; ?></label>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" <?php echo ($yandex_market_simple ? ' checked="checked"' : ''); ?> name="yandex_market_simple" value="1"/> <?php echo $text_enabled; ?></label>
                        <label class="radio-inline"><input type="radio" <?php echo (!$yandex_market_simple ? ' checked="checked"' : ''); ?> name="yandex_market_simple" value="0"/> <?php echo $text_disabled; ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-yandex_market_shopname"><span data-toggle="tooltip" title="<?php echo $help_shopname; ?>"><?php echo $entry_shopname; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="yandex_market_shopname" value="<?php echo $yandex_market_shopname; ?>" placeholder="<?php echo $entry_shopname; ?>" id="input-yandex_market_shopname" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-yandex_market_company"><span data-toggle="tooltip" title="<?php echo $help_company; ?>"><?php echo $entry_company; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="yandex_market_company" value="<?php echo $yandex_market_company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-yandex_market_company" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-yandex_market_vendor"><span data-toggle="tooltip" title="<?php echo $help_vendor; ?>"><?php echo $entry_vendor; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="yandex_market_vendor" value="<?php echo $yandex_market_vendor; ?>" placeholder="<?php echo $entry_vendor; ?>" id="input-yandex_market_vendor" class="form-control" />
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-yandex_market_model"><span data-toggle="tooltip" title="<?php echo $help_model; ?>"><?php echo $entry_model; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="yandex_market_model" value="<?php echo $yandex_market_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-yandex_market_model" class="form-control" />
                    </div>
                </div>    
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-yandex_market_sales_notes"><span data-toggle="tooltip" title="<?php echo $help_sales_notes; ?>"><?php echo $entry_sales_notes; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="yandex_market_sales_notes" value="<?php echo $yandex_market_sales_notes; ?>" placeholder="<?php echo $entry_sales_notes; ?>" id="input-yandex_market_sales_notes" class="form-control" maxlength="50" />
                    </div>
                </div>    
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                    <div class="col-sm-10">
                        <div class="panel panel-default">
                            <div class="tree-panel-heading tree-panel-heading-controls clearfix">
                                <div class="tree-actions pull-right">
                                    <a onclick="hidecatall($('#categoryBox')); return false;" id="collapse-all-categoryBox" class="btn btn-default">
                                        <i class="icon-collapse-alt"></i><?php echo $text_hide_all; ?>
                                    </a>
                                    <a onclick="showcatall($('#categoryBox')); return false;" id="expand-all-categoryBox" class="btn btn-default">
                                        <i class="icon-expand-alt"></i><?php echo $text_show_all; ?>
                                    </a>
                                    <a onclick="checkAllAssociatedCategories($('#categoryBox')); return false;" id="check-all-categoryBox" class="btn btn-default">
                                        <i class="icon-check-sign"></i><?php echo $text_select_all; ?>
                                    </a>
                                    <a onclick="uncheckAllAssociatedCategories($('#categoryBox')); return false;" id="uncheck-all-categoryBox" class="btn btn-default">
                                        <i class="icon-check-empty"></i><?php echo $text_unselect_all; ?>
                                    </a>
                                </div>
                            </div>		
                            <ul id="categoryBox" class="tree">
                                    <?php echo $market_cat_tree; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_country_of_origin; ?></label>
                    <div class="col-sm-10">
						<select name="yandex_market_country_of_origin" class="form-control">
							<option value="0" selected="selected"><?php echo $text_none; ?></option>
							<?php foreach ($attributes as $attribute) { ?>
								<?php if ($attribute['attribute_id'] == $yandex_market_country_of_origin) { ?>
									<option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name']; ?></option>
								<?php } ?>
							<?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_color_option; ?></label>
                    <div class="col-sm-10">
                        <div class="scrollbox" style="height: 160px; overflow-x: auto; width: 100%;">
                                <?php $class = 'odd'; ?>
                                <?php foreach ($options as $option) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($option['option_id'], $yandex_market_color_options)) { ?>
                                            <input type="checkbox" name="yandex_market_color_options[]" value="<?php echo $option['option_id']; ?>" checked="checked" /> <?php echo $option['name']; ?>
                                        <?php } else { ?>
                                            <input type="checkbox" name="yandex_market_color_options[]" value="<?php echo $option['option_id']; ?>" /> <?php echo $option['name']; ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                        </div>
                        <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_size_unit; ?>"><?php echo $entry_size_option; ?></span></label>
                    <div class="col-sm-10">
                        <div class="scrollbox" style="height: 160px; overflow-x: auto; width: 100%;">
                            <?php $class = 'odd'; ?>
                            <?php foreach ($options as $option) { ?>
                            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                <div class="<?php echo $class; ?>">
                                    <?php if (in_array($option['option_id'], $yandex_market_size_options)) { ?>
                                        <input type="checkbox" name="yandex_market_size_options[]" value="<?php echo $option['option_id']; ?>" checked="checked" /> <?php echo $option['name']; ?>
                                    <?php } else { ?>
                                        <input type="checkbox" name="yandex_market_size_options[]" value="<?php echo $option['option_id']; ?>" /> <?php echo $option['name']; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                    </div>
                </div>
               <div class="form-group">
                <label class="col-sm-2 control-label" for="yandex_market_currency"><span data-toggle="tooltip" title="<?php echo $help_currency; ?>"><?php echo $entry_currency; ?></span></label>
                <div class="col-sm-10">
                  <select name="yandex_market_currency" id="yandex_market_currency" class="form-control">
                        <?php foreach ($currencies as $currency) { ?>
                        <?php if ($currency['code'] == $yandex_market_currency) { ?>
                        <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
                        <?php } ?>
                        <?php } ?>
                        </select>
                </div>
              </div>
               <div class="form-group">
                <label class="col-sm-2 control-label" for="yandex_market_in_stock"><span data-toggle="tooltip" title="<?php echo $help_in_stock; ?>"><?php echo $entry_in_stock; ?></span></label>
                <div class="col-sm-10">
                  <select name="yandex_market_in_stock" id="yandex_market_in_stock" class="form-control">
                        <?php foreach ($stock_statuses as $stock_status) { ?>
                        <?php if ($stock_status['stock_status_id'] == $yandex_market_in_stock) { ?>
                        <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                        </select>
                </div>
              </div>
                            
              <div class="form-group">
                <label class="col-sm-2 control-label" for="yandex_market_out_of_stock"><span data-toggle="tooltip" title="<?php echo $help_out_of_stock; ?>"><?php echo $entry_out_of_stock; ?></span></label>
                <div class="col-sm-10">
                  <select name="yandex_market_out_of_stock" id="yandex_market_out_of_stock" class="form-control">
                        <?php foreach ($stock_statuses as $stock_status) { ?>
                        <?php if ($stock_status['stock_status_id'] == $yandex_market_out_of_stock) { ?>
                        <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                        </select>
                </div>
              </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2"><?php echo $entry_settings; ?></label>
                                            <div class="col-sm-8">
                                                <div class="checkbox">
                                                    <label for="yandex_market_available"><input type="checkbox" <?php echo ($yandex_market_available? ' checked="checked"' : ''); ?> name="yandex_market_available" id="yandex_market_available" class="" value="1"/> <?php echo $entry_available; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_additional_images"><input type="checkbox" <?php echo ($yandex_market_additional_images? ' checked="checked"' : ''); ?> name="yandex_market_additional_images" id="yandex_market_additional_images" class="" value="1"/> <?php echo $entry_additional_images; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_delivery_common"><input type="checkbox" <?php echo ($yandex_market_delivery_common ? ' checked="checked"' : ''); ?> name="yandex_market_delivery_common" id="yandex_market_delivery_common" class="" value="1"/> <?php echo $entry_delivery_common; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_delivery_individual"><input type="checkbox" <?php echo ($yandex_market_delivery_individual ? ' checked="checked"' : ''); ?> name="yandex_market_delivery_individual" id="yandex_market_delivery_individual" class="" value="1"/> <?php echo $entry_delivery_individual; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_combination"><input type="checkbox" <?php echo ($yandex_market_combination ? ' checked="checked"' : ''); ?> name="yandex_market_combination" id="yandex_market_combination" class="" value="1"/> <?php echo $entry_combination; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_features"><input type="checkbox" <?php echo ($yandex_market_features ? ' checked="checked"' : ''); ?> name="yandex_market_features" id="yandex_market_features" class="" value="1"/> <?php echo $entry_features; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_dimensions"><input type="checkbox" <?php echo ($yandex_market_dimensions ? ' checked="checked"' : ''); ?> name="yandex_market_dimensions" id="yandex_market_dimensions" class="" value="1"/> <?php echo $entry_dimensions; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_allcurrencies"><input type="checkbox" <?php echo ($yandex_market_allcurrencies ? ' checked="checked"' : ''); ?> name="yandex_market_allcurrencies" id="yandex_market_allcurrencies" class="" value="1"/> <?php echo $entry_allcurrencies; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_store"><input type="checkbox" <?php echo ($yandex_market_store ? ' checked="checked"' : ''); ?> name="yandex_market_store" id="yandex_market_store" class="" value="1"/> <?php echo $entry_store; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_delivery"><input type="checkbox" <?php echo ($yandex_market_delivery ? ' checked="checked"' : ''); ?> name="yandex_market_delivery" id="yandex_market_delivery" class="" value="1"/> <?php echo $entry_delivery; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_pickup"><input type="checkbox" <?php echo ($yandex_market_pickup ? ' checked="checked"' : ''); ?> name="yandex_market_pickup" id="yandex_market_pickup" class="" value="1"/> <?php echo $entry_pickup; ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="yandex_market_manufacturer_warranty"><input type="checkbox" <?php echo ($yandex_market_manufacturer_warranty ? ' checked="checked"' : ''); ?> name="yandex_market_manufacturer_warranty" id="yandex_market_manufacturer_warranty" class="" value="1"/> <?php echo $entry_manufacturer_warranty; ?></label>
                                                </div>
                                            </div>
                                        </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_data_feed; ?></label>
                <div class="col-sm-10">
                  <textarea rows="5" readonly id="input-data-feed" class="form-control"><?php echo $data_feed; ?></textarea>
                </div>
              </div>
               </div>
             
              <div class="tab-pane" id="tab-category"> 
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-yandex_market_category"><span data-toggle="tooltip" title="<?php echo $help_yandex_market_category; ?>"><?php echo $entry_yandex_market_category; ?></span></label>
						<div class="col-sm-10">
							<input type="text" name="yandex_market_category_default" value="<?php echo $yandex_market_category_default; ?>" placeholder="<?php echo $entry_yandex_market_category; ?>" id="input-yandex_market_category" class="form-control" />
						</div>
					</div>
					
					<table id="yandex-market-category" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left"><?php echo $entry_category; ?></td>
                          <td class="text-left"><?php echo $entry_yandex_market_category; ?></td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $yandex_market_category_row = 0; ?>
                        <?php foreach ($yandex_market_category_options as $yandex_market_category) { ?>
                        <tr id="delivery-row<?php echo $yandex_market_category_row; ?>">
                          <td class="text-left col-sm-4">
							<select name="yandex_market_category[<?php echo $yandex_market_category_row; ?>][category_id]" class="form-control">';  
								<?php foreach($categories as $category) { ?>
									<?php if ( $yandex_market_category['category_id'] == $category['category_id']) { ?>
										<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>';
									<?php } else { ?>
										<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>';
									<?php } ?>
								<?php } ?>
							</select>
						  </td>
						  <td class="text-left  col-sm-3">
                              <input type="text" name="yandex_market_category[<?php echo $yandex_market_category_row; ?>][category_name]" value="<?php echo $yandex_market_category['category_name']; ?>" placeholder="<?php echo $entry_days; ?>" class="form-control" />
                         </td>                        
                          <td class="text-left  col-sm-1"><button type="button" onclick="$('#delivery-row<?php echo $yandex_market_category_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $yandex_market_category_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2"></td>
                          <td class="text-left"><button type="button" onclick="addYandexMarketCategory();" data-toggle="tooltip" title="<?php echo $button_delivery_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
					
					
              </div>
               
                <div class="tab-pane" id="tab-delivery">
                    <table id="delivery-options" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left"><?php echo $entry_cost; ?></td>
                          <td class="text-left"><?php echo $entry_days; ?></td>
                          <td class="text-left"><?php echo $entry_order_before; ?></td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $delivery_row = 0; ?>
                        <?php foreach ($yandex_market_delivery_options as $yandex_market_delivery_option) { ?>
                        <tr id="delivery-row<?php echo $delivery_row; ?>">
                          <td class="text-left col-sm-4">
                               <input type="text" name="yandex_market_delivery_option[<?php echo $delivery_row; ?>][cost]" value="<?php echo $yandex_market_delivery_option['cost']; ?>" placeholder="<?php echo $entry_cost; ?>" class="form-control" />
                           </td>
                        <td class="text-left  col-sm-3">
                              <input type="text" name="yandex_market_delivery_option[<?php echo $delivery_row; ?>][days]" value="<?php echo $yandex_market_delivery_option['days']; ?>" placeholder="<?php echo $entry_days; ?>" class="form-control" />
                        </td>
                        <td class="text-left  col-sm-4">
                              <input type="text" name="yandex_market_delivery_option[<?php echo $delivery_row; ?>][order_before]" value="<?php echo $yandex_market_delivery_option['order_before']; ?>" placeholder="<?php echo $entry_order_before; ?>" class="form-control" />
                        </td>                         
                        <td class="text-left  col-sm-1"><button type="button" onclick="$('#delivery-row<?php echo $delivery_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $delivery_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"></td>
                          <td class="text-left"><button type="button" onclick="addDelivery();" data-toggle="tooltip" title="<?php echo $button_delivery_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
               </div>
                <div class="tab-pane" id="tab-delivery-product">
                    <table id="delivery-products" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left"><?php echo $entry_category; ?></td>
                          <td class="text-left"><?php echo $entry_price; ?></td>
                          <td class="text-left"><?php echo $entry_cost; ?></td>
                          <td class="text-left"><?php echo $entry_days; ?></td>
                          <td class="text-left"><?php echo $entry_order_before; ?></td>
                          <td class="text-left"><?php echo $entry_priority; ?></td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $delivery_product_row = 0; ?>
                        <?php foreach ($yandex_market_delivery_products as $yandex_market_delivery_product) { ?>
                        <tr id="delivery-product-row<?php echo $delivery_product_row; ?>">
                         <td class="text-left col-sm-2">
                               <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][category]" value="<?php echo $yandex_market_delivery_product['category']; ?>" placeholder="<?php echo $entry_category; ?>" class="form-control" />
                           </td>
                          <td class="text-left col-sm-2">
                                <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][price_from]" value="<?php echo $yandex_market_delivery_product['price_from']; ?>" placeholder="<?php echo $entry_price_from; ?>" class="form-control" />
                           </td>
                          <td class="text-left col-sm-2">
                               <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][cost]" value="<?php echo $yandex_market_delivery_product['cost']; ?>" placeholder="<?php echo $entry_cost; ?>" class="form-control" />
                           </td>
                        <td class="text-left  col-sm-2">
                              <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][days]" value="<?php echo $yandex_market_delivery_product['days']; ?>" placeholder="<?php echo $entry_days; ?>" class="form-control" />
                        </td>
                        <td class="text-left  col-sm-2">
                              <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][order_before]" value="<?php echo $yandex_market_delivery_product['order_before']; ?>" placeholder="<?php echo $entry_order_before; ?>" class="form-control" />
                        </td>
                         <td class="text-left  col-sm-1">
                              <input type="text" name="yandex_market_delivery_product[<?php echo $delivery_product_row; ?>][priority]" value="<?php echo $yandex_market_delivery_product['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" />
                        </td>       
                        <td class="text-left  col-sm-1"><button type="button" onclick="$('#delivery-product-row<?php echo $delivery_product_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $delivery_product_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="6"></td>
                          <td class="text-left"><button type="button" onclick="addDeliveryProduct();" data-toggle="tooltip" title="<?php echo $button_delivery_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
               </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function showcatall($tree) {
$tree.find("ul.tree").each(function() {
		$(this).slideDown();
	});
}

function hidecatall($tree) {
$tree.find("ul.tree").each(function() {
		$(this).slideUp();
	});
}
function checkAllAssociatedCategories($tree) {
$tree.find(":input[type=checkbox]").each(function() {
		$(this).prop("checked", true);
		$(this).parent().addClass("tree-selected");
	});
}
function uncheckAllAssociatedCategories($tree) {
$tree.find(":input[type=checkbox]").each(function() {
		$(this).prop("checked", false);
		$(this).parent().removeClass("tree-selected");
	});
}
</script>

<script type="text/javascript">
$(document).ready(function(){

	$('.tree-item-name label').click(function(){
		$(this).parent().find('input').click();
	});

	$('.tree-folder-name input').change(function(){
		if ($(this).prop("checked"))
		{
			$(this).parent().addClass("tree-selected");
			$(this).parents('.tree-folder').first().find('ul input').prop("checked", true).parent().addClass("tree-selected");
		}
		else
		{
			$(this).parent().removeClass("tree-selected");
			$(this).parents('.tree-folder').first().find('ul input').prop("checked", false).parent().removeClass("tree-selected");
		}
	});

	$('.tree-toggler').click(function(){
		$(this).parents('.tree-folder').first().find('ul').slideToggle('slow');
	});

	$('.tree input').change(function(){
		if ($(this).prop("checked"))
		{
			$(this).parent().addClass("tree-selected");
		}
		else
		{
			$(this).parent().removeClass("tree-selected");
		}
	});
	//
	var market_cat = JSON.parse('<?php echo json_encode($yandex_market_categories); ?>');
	//console.log(market_cat);
	for (i in market_cat)
		$('#categoryBox input[value="'+ market_cat[i] +'"]').prop("checked", true).change();
    
});
</script>

<script type="text/javascript">
var yandex_market_category_row = <?php echo $yandex_market_category_row; ?>;

function addYandexMarketCategory() {
    html  = '<tr id="yandex-market-category-row' + yandex_market_category_row + '">';
	html += '  <td class="text-left">';
	html += '  		<select name="yandex_market_category[' + yandex_market_category_row + '][category_id]" class="form-control">';
					<?php foreach($categories as $category) { ?>
    html += '           <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>';
                    <?php } ?>
    html += '       </select>';
	html += '  <td class="text-left"><input type="text" name="yandex_market_category[' + yandex_market_category_row + '][category_name]"  value="" placeholder="<?php echo $entry_days; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#yandex-market-category-row' + yandex_market_category_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

	$('#yandex-market-category tbody').append(html);

	yandex_market_category_row++;
}
</script>

<script type="text/javascript">
var delivery_row = <?php echo $delivery_row; ?>;

function addDelivery() {
    html  = '<tr id="delivery-row' + delivery_row + '">';
	html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_option[' + delivery_row + '][cost]" value="" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_option[' + delivery_row + '][days]"  value="" placeholder="<?php echo $entry_days; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_option[' + delivery_row + '][order_before]"  value="" placeholder="<?php echo $entry_order_before; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#delivery-row' + delivery_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

	$('#delivery-options tbody').append(html);

	delivery_row++;
}
</script>

<script type="text/javascript">
var delivery_product_row = <?php echo $delivery_product_row; ?>;

function addDeliveryProduct() {
    html  = '<tr id="delivery-product-row' + delivery_product_row + '">';
    html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][category]" value="" placeholder="<?php echo $entry_category; ?>" class="form-control" /></td>';
	html += '  <td class="text-left">';
    html += '  <input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][price_from]" value="" placeholder="<?php echo $entry_price_from; ?>" class="form-control" />';
    html += '  </td>';
    html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][cost]" value="" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][days]"  value="" placeholder="<?php echo $entry_days; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][order_before]"  value="" placeholder="<?php echo $entry_order_before; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><input type="text" name="yandex_market_delivery_product[' + delivery_product_row + '][priority]"  value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><button type="button" onclick="$(\'#delivery-product-row' + delivery_product_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

	$('#delivery-products tbody').append(html);

	delivery_product_row++;
}
</script>

<style>
.bootstrap .tree-panel-heading-controls {
    line-height: 2.2em;
    font-size: 1.1em;
    color: #00aff0;
}

.bootstrap .tree-panel-heading-controls i {
    font-size: 14px;
}

.bootstrap .tree {
    list-style: none;
    padding: 0 0 0 20px;
}

.bootstrap .tree input {
    vertical-align: baseline;
    margin-right: 4px;
    line-height: normal;
}

.bootstrap .tree i {
    font-size: 14px;
}

.bootstrap .tree .tree-item-name,.bootstrap .tree .tree-folder-name {
    padding: 2px 5px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}

.bootstrap .tree .tree-item-name label,.bootstrap .tree .tree-folder-name label {
    font-weight: 400;
}

.bootstrap .tree .tree-item-name:hover,.bootstrap .tree .tree-folder-name:hover {
    background-color: #eee;
    cursor: pointer;
}

.bootstrap .tree .tree-selected {
    color: #fff;
    background-color: #00aff0;
}

.bootstrap .tree .tree-selected:hover {
    background-color: #009cd6;
}

.bootstrap .tree .tree-selected i.tree-dot {
    background-color: #fff;
}

.bootstrap .panel-footer {
	height: 73px;
	border-color: #eee;
	background-color: #fcfdfe;
}

.bootstrap .tree i.tree-dot {
    display: inline-block;
    position: relative;
    width: 6px;
    height: 6px;
    margin: 0 4px;
    background-color: #ccc;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}

.bootstrap .tree .tree-item-disable,.bootstrap .tree .tree-folder-name-disable {
    color: #ccc;
}

.bootstrap .tree .tree-item-disable:hover,.bootstrap .tree .tree-folder-name-disable:hover {
    color: #ccc;
    background-color: none;
}

.bootstrap .tree-actions {
    display: inline-block;
}

.bootstrap .tree-panel-heading-controls {
    padding: 5px;
    border-bottom: solid 1px #dfdfdf;
}

.bootstrap .tree-actions .twitter-typeahead {
    padding: 0 0 0 4px;
}

.bootstrap #categoryBox {
	padding: 10px 5px 5px 20px;
}

.bootstrap .tree-panel-label-title {
    font-weight: 400;
    margin: 0;
    padding: 0 0 0 8px;
}

.scrollbox > div {
	height: 23px;
}
</style>
<?php echo $footer; ?>
