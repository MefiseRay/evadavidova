<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  
  <div class="container-fluid"> <!-- continut -->
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    
    <div class="panel panel-default"> <!-- filters div -->
      
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $masstxt_p_filters_h; ?></h3>
        
        
        <br />
        <a id="allfilters_more" class="more_less"><?php echo $masstxt_show_f; ?> <i class="fa fa-chevron-down"></i></a> 
        <a id="allfilters_less" class="more_less"><?php echo $masstxt_hide_f; ?> <i class="fa fa-chevron-up"></i></a>
        
        
      </div>
      
      <div class="panel-body">
      <div class="table-responsive">
    	<table class="table table-bordered table-hover"> <!-- filters table -->
    	<tbody>

    	<tr class="allfilters_row">
    	  <td class="text-left coloana1">
    	  <strong><?php echo $masstxt_name; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <input type="text" value="<?php echo $filter_name; ?>" name="filter_name" class="fil_control3">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_name_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_tag; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <input type="text" value="<?php echo $filter_tag; ?>" name="filter_tag" class="fil_control3">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_tag_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_model; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <input type="text" value="<?php echo $filter_model; ?>" name="filter_model" class="fil_control3">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_model_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_categories; ?></strong>
    	  </td>
    	  <td class="text-left">
              <div class="well well-sm scroll1 categs_div">
                <?php $stl = 'bg_row_1'; ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array(0, $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="0" checked="checked" /><?php echo $masstxt_none_cat; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="0" /><?php echo $masstxt_none_cat; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($categories as $category) { ?>
                <?php $stl = ($stl == 'bg_row_2' ? 'bg_row_1' : 'bg_row_2'); ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array($category['category_id'], $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <div class="sub_scroll1">
                <a id="categs_more" class="more_less"><?php echo $masstxt_show_more_r; ?> <i class="fa fa-chevron-down"></i></a> 
                <a id="categs_less" class="more_less"><?php echo $masstxt_show_less_r; ?> <i class="fa fa-chevron-up"></i></a> 
                <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
                <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
              </div>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_manufacturers; ?></strong>
    	  </td>
    	  <td class="text-left">
              <div class="well well-sm scroll1 manufacts_div">
                <?php $stl = 'bg_row_1'; ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array(0, $manufacturer_ids)) { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="0" checked="checked" /><?php echo $masstxt_none; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="0" /><?php echo $masstxt_none; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($manufacturers as $manufacturer) { ?>
                <?php $stl = ($stl == 'bg_row_2' ? 'bg_row_1' : 'bg_row_2'); ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array($manufacturer['manufacturer_id'], $manufacturer_ids)) { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <div class="sub_scroll1">
                <a id="manufacts_more" class="more_less"><?php echo $masstxt_show_more_r; ?> <i class="fa fa-chevron-down"></i></a> 
                <a id="manufacts_less" class="more_less"><?php echo $masstxt_show_less_r; ?> <i class="fa fa-chevron-up"></i></a> 
                <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
                <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
              </div>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_p_filters; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <?php if($p_filters) { ?>
              <div class="well well-sm scroll1 filts_div">
                <?php $stl = 'bg_row_1'; ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array(0, $filters_ids)) { ?>
                    <input type="checkbox" name="filters_ids[]" value="0" checked="checked" /><?php echo $masstxt_none_fil; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="filters_ids[]" value="0" /><?php echo $masstxt_none_fil; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($p_filters as $p_filter) { ?>
                <?php $stl = ($stl == 'bg_row_2' ? 'bg_row_1' : 'bg_row_2'); ?>
                <div class="checkbox <?php echo $stl; ?>">
                  <label>
                    <?php if (in_array($p_filter['filter_id'], $filters_ids)) { ?>
                    <input type="checkbox" name="filters_ids[]" value="<?php echo $p_filter['filter_id']; ?>" checked="checked" />
                    <?php echo $p_filter['group'].' &gt; '.$p_filter['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="filters_ids[]" value="<?php echo $p_filter['filter_id']; ?>" />
                    <?php echo $p_filter['group'].' &gt; '.$p_filter['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <div class="sub_scroll1">
                <a id="filts_more" class="more_less"><?php echo $masstxt_show_more_r; ?> <i class="fa fa-chevron-down"></i></a> 
                <a id="filts_less" class="more_less"><?php echo $masstxt_show_less_r; ?> <i class="fa fa-chevron-up"></i></a> 
                <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
                <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
              </div>
    	  <?php } else { echo $masstxt_p_filters_none; } ?>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_p_data; ?></strong>
    	  </td>
    	  <td class="text-left">

    	  <label class="fil_label5"><?php echo $masstxt_SKU; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_sku; ?>" name="filter_sku" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_UPC; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_upc; ?>" name="filter_upc" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_EAN; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_ean ?>" name="filter_ean" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_JAN; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_jan; ?>" name="filter_jan" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_ISBN; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_isbn; ?>" name="filter_isbn" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_MPN; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_mpn; ?>" name="filter_mpn" class="fil_control5">
    	  </span>

    	  <label class="fil_label5"><?php echo $masstxt_location; ?> </label>
    	  <span class="fil_right_box5">
    	    <input type="text" value="<?php echo $filter_location; ?>" name="filter_location" class="fil_control5">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_price; ?></strong>
    	  <span class="help"> <?php echo $masstxt_price_help; ?></span>
    	  </td>
    	  <td class="text-left">
    	  
    	  <label class="fil_label1"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $price_mmarese; ?>" name="price_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $price_mmicse; ?>" name="price_mmicse" class="fil_control1">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_discount; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  
    	  <label class="fil_label1"><?php echo $masstxt_customer_group; ?> </label>
    	  <span class="fil_right_box1">
    	    <select name="d_cust_group_filter" class="fil_control1">
    	      <option value="any"<?php if ($d_cust_group_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_all; ?></option>
    	      <?php foreach ($customer_groups as $customer_group) { ?>
    	        <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id']==$d_cust_group_filter) { echo ' selected="selected"'; } ?>><?php echo $customer_group['name']; ?></option>
    	      <?php } ?>
    	    </select>
    	  </span>
    	      	  
    	  <label class="fil_label1"><?php echo $masstxt_price_from; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $d_price_mmarese; ?>" name="d_price_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_price_to; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $d_price_mmicse; ?>" name="d_price_mmicse" class="fil_control1">
    	  </span>

    	  <label class="fil_label1"><?php echo $masstxt_date_start; ?> </label>
    	  <span class="fil_right_box1">
    	    <input class="date fil_control1" type="text" value="<?php echo $d_date_start; ?>" name="d_date_start" data-date-format="YYYY-MM-DD">
    	  </span>

    	  <label class="fil_label1"><?php echo $masstxt_date_end; ?> </label>
    	  <span class="fil_right_box1">
    	    <input class="date fil_control1" type="text" value="<?php echo $d_date_end; ?>" name="d_date_end" data-date-format="YYYY-MM-DD">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_special; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  
    	  <label class="fil_label1"><?php echo $masstxt_customer_group; ?> </label>
    	  <span class="fil_right_box1">
    	    <select name="s_cust_group_filter" class="fil_control1">
    	      <option value="any"<?php if ($s_cust_group_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_all; ?></option>
    	      <?php foreach ($customer_groups as $customer_group) { ?>
    	        <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id']==$s_cust_group_filter) { echo ' selected="selected"'; } ?>><?php echo $customer_group['name']; ?></option>
    	      <?php } ?>
    	    </select>
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_price_from; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $s_price_mmarese; ?>" name="s_price_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_price_to; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $s_price_mmicse; ?>" name="s_price_mmicse" class="fil_control1">
    	  </span>
 
    	  <label class="fil_label1"><?php echo $masstxt_date_start; ?> </label>
    	  <span class="fil_right_box1">
    	    <input class="date fil_control1" type="text" value="<?php echo $s_date_start; ?>" name="s_date_start" data-date-format="YYYY-MM-DD">
    	  </span>

    	  <label class="fil_label1"><?php echo $masstxt_date_end; ?> </label>
    	  <span class="fil_right_box1">
    	    <input class="date fil_control1" type="text" value="<?php echo $s_date_end; ?>" name="s_date_end" data-date-format="YYYY-MM-DD">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_reward_points; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  
    	  <label class="fil_label0"><?php echo $masstxt_points_from; ?></label>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_points_help; ?>"></span></label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $points_mmarese; ?>" name="points_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label0"><?php echo $masstxt_points_to; ?></label>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_points_help; ?>"></span></label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $points_mmicse; ?>" name="points_mmicse" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_customer_group; ?> </label>
    	  <span class="fil_right_box1">
    	    <select name="r_p_cust_group_filter" class="fil_control1">
    	      <option value="any"<?php if ($r_p_cust_group_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_all; ?></option>
    	      <?php foreach ($customer_groups as $customer_group) { ?>
    	        <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id']==$r_p_cust_group_filter) { echo ' selected="selected"'; } ?>><?php echo $customer_group['name']; ?></option>
    	      <?php } ?>
    	    </select>
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_r_points_from; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $r_p_mmarese; ?>" name="r_p_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_r_points_to; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $r_p_mmicse; ?>" name="r_p_mmicse" class="fil_control1">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_tax_class; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="tax_class_filter" class="fil_control4">
    	  <option value="any"<?php if ($tax_class_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="0"<?php if ($tax_class_filter=='0') { echo ' selected="selected"'; } ?>> <?php echo $masstxt_none; ?> </option>
    	  <?php foreach ($tax_classes as $tax_class) { ?>
    	  <option value="<?php echo $tax_class['tax_class_id']; ?>"<?php if ($tax_class['tax_class_id']==$tax_class_filter) { echo ' selected="selected"'; } ?>><?php echo $tax_class['title']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>
    	
    	
    	
    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_quantity; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <label class="fil_label1"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $stock_mmarese; ?>" name="stock_mmarese" class="fil_control1">
    	  </span>
    	  
    	  <label class="fil_label1"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $stock_mmicse; ?>" name="stock_mmicse" class="fil_control1">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_minimum_quantity; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <label class="fil_label1"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $min_q_mmarese; ?>" name="min_q_mmarese" class="fil_control1">
    	  </span>

    	  <label class="fil_label1"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box1">
    	    <input type="text" value="<?php echo $min_q_mmicse; ?>" name="min_q_mmicse" class="fil_control1">
    	  </span>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_subtract_stock; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="subtract_filter" class="fil_control4">
    	  <option value="any"<?php if ($subtract_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($subtract_filter=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_yes; ?></option>
    	  <option value="0"<?php if ($subtract_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no; ?></option>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_out_of_stock_status; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="stock_status_filter" class="fil_control4">
    	  <option value="any"<?php if ($stock_status_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($stock_statuses as $stock_status) { ?>
    	  <option value="<?php echo $stock_status['stock_status_id']; ?>"<?php if ($stock_status['stock_status_id']==$stock_status_filter) { echo ' selected="selected"'; } ?>><?php echo $stock_status['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_requires_shipping; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="shipping_filter" class="fil_control4">
    	  <option value="any"<?php if ($shipping_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($shipping_filter=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_yes; ?></option>
    	  <option value="0"<?php if ($shipping_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no; ?></option>
    	  </select>
    	  </td>
    	</tr>



    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_available; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <label class="fil_label2"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="date fil_control2" type="text" value="<?php echo $date_mmarese; ?>" name="date_mmarese" data-date-format="YYYY-MM-DD">
    	  </span>

    	  <label class="fil_label3"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="date fil_control2" type="text" value="<?php echo $date_mmicse; ?>" name="date_mmicse" data-date-format="YYYY-MM-DD">
    	  </span>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_added; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <label class="fil_label2"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="datetime fil_control2" type="text" value="<?php echo $date_added_mmarese; ?>" name="date_added_mmarese" data-date-format="YYYY-MM-DD HH:mm">
    	  </span>

    	  <label class="fil_label3"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="datetime fil_control2" type="text" value="<?php echo $date_added_mmicse; ?>" name="date_added_mmicse" data-date-format="YYYY-MM-DD HH:mm">
    	  </span>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_modified; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <label class="fil_label2"><?php echo $masstxt_greater_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="datetime fil_control2" type="text" value="<?php echo $date_modified_mmarese; ?>" name="date_modified_mmarese" data-date-format="YYYY-MM-DD HH:mm">
    	  </span>

    	  <label class="fil_label3"><?php echo $masstxt_less_than_or_equal; ?> </label>
    	  <span class="fil_right_box2">
    	    <input class="datetime fil_control2" type="text" value="<?php echo $date_modified_mmicse; ?>" name="date_modified_mmicse" data-date-format="YYYY-MM-DD HH:mm">
    	  </span>
    	  </td>
    	</tr>




    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_status; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="prod_status" class="fil_control4">
    	  <option value="any"<?php if ($prod_status=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($prod_status=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_enabled; ?></option>
    	  <option value="0"<?php if ($prod_status=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_disabled; ?></option>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_store; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="store_filter" class="fil_control4">
    	  <option value="any"<?php if ($store_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="0"<?php if ($store_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_default; ?></option>
    	  <?php foreach ($stores as $store) { ?>
    	  <option value="<?php echo $store['store_id']; ?>"<?php if ($store['store_id']==$store_filter) { echo ' selected="selected"'; } ?>><?php echo $store['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_attribute; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="filter_attr" class="fil_control4">
    	  <option value="any"<?php if ($filter_attr=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_attributes as $attrib) { ?>
    	  <option value="<?php echo $attrib['attribute_id']; ?>"<?php if ($attrib['attribute_id']==$filter_attr) { echo ' selected="selected"'; } ?>><?php echo $attrib['attribute_group']." > ".$attrib['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_attribute_value; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <textarea name="filter_attr_val" rows="2" class="fil_control3"><?php echo $filter_attr_val; ?></textarea>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_with_attribute_value_help; ?><br /><br /><?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_this_option; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="filter_opti" class="fil_control4">
    	  <option value="any"<?php if ($filter_opti=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_options as $option) { ?>
    	  <option value="<?php echo $option['option_id']; ?>"<?php if ($option['option_id']==$filter_opti) { echo ' selected="selected"'; } ?>><?php echo $option['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr class="allfilters_row">
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_this_option_value; ?></strong>
    	  </td>
    	  <td class="text-left">
    	  <select name="filter_opti_val" class="fil_control4">
    	  <option value="any"<?php if ($filter_opti_val=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_optval as $optval) { ?>
    	  <option value="<?php echo $optval['option_value_id']; ?>"<?php if ($optval['option_value_id']==$filter_opti_val) { echo ' selected="selected"'; } ?>><?php echo $optval['o_name']." > ".$optval['ov_name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	</tbody>
    	</table> <!-- filters table -->



    	<table class="table table-bordered table-hover"> <!-- filter products table -->
    	<tbody>
    	
    	<tr>
    	  <td class="text-left coloana2">
    	  <br />
    	  <?php echo $masstxt_max_prod_pag1; ?>
    	  <input size="3" type="text" value="<?php echo $max_prod_pag; ?>" name="max_prod_pag"> 
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_max_prod_pag2; ?>"></span></label>
    	  <br />
    	  <?php echo $masstxt_show_page_of1; ?>
    	  <select name="curent_pag" onchange="document.getElementById('fil_prod_btn').click()">
    	  <?php for ($pg=1;$pg<=$total_pag;$pg++) { ?>
    	  <option value="<?php echo $pg; ?>"<?php if ($pg==$curent_pag) { echo ' selected="selected"'; } ?>><?php echo $pg; ?></option>
    	  <?php } ?>
    	  </select>
    	  <?php echo $masstxt_show_page_of2; ?><?php echo $total_pag; ?><br /><br />
    	  <input type="submit" value="<?php echo $masstxt_filter_products_button; ?>" id="fil_prod_btn" name="lista_prod" class="btn btn-primary fil_prod_butt">
    	  <br /><br />
    	  <?php echo $total_prod_filtered; ?><?php echo $masstxt_total_prod_res; ?><br /><br />
    	  <span class="counter" style="font-weight:bold;">0</span><?php echo $masstxt_prod_sel_for_upd; ?><br />
    	  <br />
    	  </td>
    	  <td class="text-left">
    	  <div class="filterd_p_list filteredp_div">
    	  <table class="list1"> <!-- products filtered table -->
          <thead>
            <tr>
              <td class="filtered_table_td1" width="1">
              <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" checked="checked" name="sel_desel_all" />
              </td>
              <td class="filtered_table_td1"><?php echo $masstxt_table_name; ?></td>
              <td class="filtered_table_td1"><?php echo $masstxt_table_model; ?></td>
              <td class="filtered_table_td1 t_a_right"><?php echo $masstxt_table_price; ?></td>
              <td class="filtered_table_td1 t_a_right"><?php echo $masstxt_table_quantity; ?></td>
              <td class="filtered_table_td1"><?php echo $masstxt_table_status; ?></td>
            </tr>
          </thead>
          <tbody class="products_to_upd">
          <?php if ($arr_lista_prod) { ?>
            <?php foreach ($arr_lista_prod as $product) { ?>
            <tr>
              <td class="filtered_table_td2"><input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" /></td>
              <td class="filtered_table_td2"><?php echo $product['name']; ?></td>
              <td class="filtered_table_td2"><?php echo $product['model']; ?></td>
              <td class="filtered_table_td2 t_a_right"><?php echo $product['price']; ?></td>
              <td class="filtered_table_td2 t_a_right"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><?php echo $product['quantity']; ?></span>
                <?php } elseif ($product['quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><?php echo $product['quantity']; ?></span>
                <?php } else { ?>
                <span style="color: #008000;"><?php echo $product['quantity']; ?></span>
                <?php } ?></td>
              <td class="filtered_table_td2"><?php if ($product['status']==1) { ?>
                <span style="color: #008000;"><?php echo $masstxt_enabled; ?></span>
                <?php } else { ?>
                <span style="color: #FF0000;"><?php echo $masstxt_disabled; ?></span>
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="6"> </td>
            </tr>
            <?php } ?>
          </tbody>
          </table> <!-- products filtered table -->
    	  </div>
            <a id="filteredp_more" class="more_less m_l_f_p"><?php echo $masstxt_show_more_r; ?> <i class="fa fa-chevron-down"></i></a> 
            <a id="filteredp_less" class="more_less m_l_f_p"><?php echo $masstxt_show_less_r; ?> <i class="fa fa-chevron-up"></i></a>    	  
    	  </td>
    	</tr>

        </tbody>
        </table> <!-- filter products table -->
      </div>
      </div>
    
    </div> <!-- filters div -->
    <!-- /* ///////////////// PANA AICI CODUL ESTE LA FEL PT TOATE MASS... ///////////////// */ -->
    
    
    
    
    
    
    
    <div class="panel panel-default"> <!-- updates div -->
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $masstxt_p_updates; ?></h3>
      </div>
      
      <div class="panel-body">
      <div class="table-responsive">
    	<table class="table table-bordered table-hover"> <!-- updates table 1 -->
    	<tbody>
 
    	<tr>
    	  <td colspan="2" class="text-left tableh1">
    	  <strong><?php echo $masstxt_upd_discount; ?></strong>
    	  </td>
    	</tr>
    	
    	<tr>
    	  <td class="text-left" style="width:75px;">
    	  <strong><?php echo $masstxt_upd_set_new_discounts; ?></strong>
    	  </td>
    	  <td class="text-left">
          <div class="tab-pane" id="tab-discount">
              <div class="table-responsive">
                <table id="discount" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_customer_group; ?></td>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_quantity; ?></td>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_priority; ?></td>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_price_type; ?><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_upd_help1; ?>"></span></label></td>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_date_start; ?></td>
                      <td class="text-left tableh2"><?php echo $masstxt_upd_date_end; ?></td>
                      <td class=" tableh2"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $discount_row = 0; ?>
                    <?php foreach ($product_discounts as $product_discount) { ?>
                    <tr id="discount-row<?php echo $discount_row; ?>">
                      <td class="text-left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">
                          <?php foreach ($customer_groups as $customer_group) { ?>
                          <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                      <td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                      <td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
                      <td class="text-left">
                        <?php if (!isset($product_discount['price_mode'])) { $product_discount['price_mode']='flat'; } ?>
                	<select name="product_discount[<?php echo $discount_row; ?>][price_mode]" class="pricetype">
    	 	 	<option value="flat"<?php if ($product_discount['price_mode']=='flat') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_flat; ?></option>
    	  		<option value="sub"<?php if ($product_discount['price_mode']=='sub') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_subtraction_price; ?></option>
    	  		<option value="per"<?php if ($product_discount['price_mode']=='per') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_percentage_price; ?></option>
    	  		</select>
                      <input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                      <td class="text-left" style="width: 20%;"><div class="input-group date">
                          <input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span></div></td>
                      <td class="text-left" style="width: 20%;"><div class="input-group date">
                          <input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span></div></td>
                      <td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $discount_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="6"></td>
                      <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_update_mode; ?></strong>
    	  </td>
    	  <td class="text-left radio1">
    	  <input type="radio"<?php if ($upd_mode=='ad') { echo ' checked="checked"'; } ?> value="ad" name="upd_mode" id="rg1">
    	  <label for="rg1"> <?php echo $masstxt_upd_mode_discount_ad; ?></label>
    	  <span style="color:#666666;font-size:11px;">&nbsp;<?php echo $masstxt_upd_mode_discount_ad_help; ?></span>
    	  <br />
    	  <input type="radio"<?php if ($upd_mode=='re') { echo ' checked="checked"'; } ?> value="re" name="upd_mode" id="rg4">
    	  <label for="rg4"> <?php echo $masstxt_upd_mode_discount_re; ?></label>
    	  <span style="color:#666666;font-size:11px;">&nbsp;<?php echo $masstxt_upd_mode_discount_re_help; ?></span>
    	  </td>
    	</tr>

    	</tbody>
    	</table> <!-- updates table 1 -->

    	<table class="table table-bordered table-hover"> <!-- updates table 2 -->
    	<tbody>
    	
    	<tr>
    	  <td colspan="2" class="text-left tableh1">
    	  <strong><?php echo $masstxt_upd_special; ?></strong>
    	  </td>
    	</tr>
    	
    	<tr>
    	  <td class="text-left" style="width:75px;">
    	  <strong><?php echo $masstxt_upd_set_new_special; ?></strong>
    	  </td>
    	  <td class="text-left">
            <div class="tab-pane" id="tab-special">
              <div class="table-responsive">
                <table id="special" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                	<td class="text-left tableh2"><?php echo $masstxt_upd_customer_group; ?></td>
                	<td class="text-left tableh2"><?php echo $masstxt_upd_priority; ?></td>
                	<td class="text-left tableh2"><?php echo $masstxt_upd_price_type; ?><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_upd_help2; ?>"></span></label></td>
                	<td class="text-left tableh2"><?php echo $masstxt_upd_date_start; ?></td>
                	<td class="text-left tableh2"><?php echo $masstxt_upd_date_end; ?></td>
                	<td class="tableh2"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $special_row = 0; ?>
                    <?php foreach ($product_specials as $product_special) { ?>
                    <tr id="special-row<?php echo $special_row; ?>">
                      <td class="text-left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">
                          <?php foreach ($customer_groups as $customer_group) { ?>
                          <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                      <td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                      <td class="text-left">
                        <?php if (!isset($product_special['price_mode'])) { $product_special['price_mode']='flat'; } ?>
                	<select name="product_special[<?php echo $special_row; ?>][price_mode]" class="pricetype">
    	  		<option value="flat"<?php if ($product_special['price_mode']=='flat') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_flat; ?></option>
    	  		<option value="sub"<?php if ($product_special['price_mode']=='sub') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_subtraction_price; ?></option>
    	  		<option value="per"<?php if ($product_special['price_mode']=='per') { echo ' selected="selected"'; } ?>><?php echo $masstxt_upd_percentage_price; ?></option>
    	  		</select>
                      <input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                      <td class="text-left" style="width: 20%;"><div class="input-group date">
                          <input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span></div></td>
                      <td class="text-left" style="width: 20%;"><div class="input-group date">
                          <input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span></div></td>
                      <td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $special_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_update_mode; ?></strong>
    	  </td>
    	  <td class="text-left radio1">
    	  <input type="radio"<?php if ($upd_mode2=='ad') { echo ' checked="checked"'; } ?> value="ad" name="upd_mode2" id="rg12">
    	  <label for="rg12"> <?php echo $masstxt_upd_mode_special_ad; ?></label>
    	  <span style="color:#666666;font-size:11px;">&nbsp;<?php echo $masstxt_upd_mode_special_ad_help; ?></span>
    	  <br />
    	  <input type="radio"<?php if ($upd_mode2=='re') { echo ' checked="checked"'; } ?> value="re" name="upd_mode2" id="rg42">
    	  <label for="rg42"> <?php echo $masstxt_upd_mode_special_re; ?></label>
    	  <span style="color:#666666;font-size:11px;">&nbsp;<?php echo $masstxt_upd_mode_special_re_help; ?></span>
    	  </td>
    	</tr>

    	</tbody>
    	</table> <!-- updates table 2 -->

    	<table class="table table-bordered table-hover"> <!-- updates table 3 -->
    	<tbody>
    	
    	<tr>
    	  <td colspan="2" class="text-center" style="color:#f24545;">
    	  <span class="counter" style="font-weight:bold;">0</span>
    	  <?php echo $masstxt_mass_update_button_top1; ?>
    	  <?php echo $curent_pag; ?>
    	  <?php echo $masstxt_mass_update_button_top2; ?>
    	  <?php echo $total_pag; ?>
    	  <?php echo $masstxt_mass_update_button_top3; ?>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_mass_update_button_help; ?>"></span></label>
    	  <br />
    	  <input type="submit" value="<?php echo $masstxt_mass_update_button; ?>" name="mass_update"  class="btn btn-danger" style="width:222px; font-weight:bold;">
    	  <br />
    	  </td>
    	</tr>

    	</tbody>
    	</table> <!-- updates table 3 -->
      </div>
      </div>

    </div> <!-- updates div -->
    
    <div class="oc-mrk-com">
    Visit <a href="http://opencart-market.com" target="_blank">www.opencart-market.com</a> for more informations and for more useful extensions.
    </div>    
    
    </form>
    
  </div> <!-- continut -->

<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script>


<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	html  = '<tr id="discount-row' + discount_row + '">'; 
    html += '  <td class="text-left"><select name="product_discount[' + discount_row + '][customer_group_id]" class="form-control">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';		
    html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
    html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
	html += '  <td class="text-left">';
	html += '<select name="product_discount[' + discount_row + '][price_mode]" class="pricetype">';
    	html += '<option value="flat"><?php echo $masstxt_upd_flat; ?></option>';
    	html += '<option value="sub"><?php echo $masstxt_upd_subtraction_price; ?></option>';
    	html += '<option value="per"><?php echo $masstxt_upd_percentage_price; ?></option></select>';
	html += '<input type="text" name="product_discount[' + discount_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#discount tbody').append(html);

	$('.date').datetimepicker({
		pickTime: false
	});
	
	discount_row++;
}
//--></script> 
  <script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tr id="special-row' + special_row + '">'; 
    html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';		
    html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
	html += '  <td class="text-left">';
	html += '<select name="product_special[' + special_row + '][price_mode]" class="pricetype">';
    	html += '<option value="flat"><?php echo $masstxt_upd_flat; ?></option>';
    	html += '<option value="sub"><?php echo $masstxt_upd_subtraction_price; ?></option>';
    	html += '<option value="per"><?php echo $masstxt_upd_percentage_price; ?></option></select>';
	html += '  <input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
    html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#special tbody').append(html);

	$('.date').datetimepicker({
		pickTime: false
	});
		
	special_row++;
}
//--></script>

<script type="text/javascript"><!--
$('input[name=\'selected[]\']').click(function(){
var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
});

$('input[name=\'sel_desel_all\']').click(function(){
var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
});

var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
//--></script>




<script type="text/javascript"><!--

$('#allfilters_more').click(function(){
    $('.allfilters_row').show(500);
    $('#allfilters_more').hide(500);
    $('#allfilters_less').show();
    localStorage.setItem('display_allfilters', 'more');
    
});
$('#allfilters_less').click(function(){
    $('.allfilters_row').hide(500);
    $('#allfilters_more').show(500);
    $('#allfilters_less').hide();
    localStorage.setItem('display_allfilters', 'less');
});
if (localStorage.getItem('display_allfilters') == 'less') {
	$('#allfilters_less').trigger('click');
} else {
	$('#allfilters_more').trigger('click');
}

$('#categs_more').click(function(){
    $('.categs_div').animate({height:'427px'}, 500);
    $('#categs_more').hide();
    $('#categs_less').show();
    localStorage.setItem('display_categs', 'more');
    
});
$('#categs_less').click(function(){
    $('.categs_div').animate({height:'66px'}, 500);
    $('#categs_more').show();
    $('#categs_less').hide();
    localStorage.setItem('display_categs', 'less');
});
if (localStorage.getItem('display_categs') == 'more') {
	$('#categs_more').trigger('click');
} else {
	$('#categs_less').trigger('click');
}

$('#manufacts_more').click(function(){
    $('.manufacts_div').animate({height:'427px'}, 500);
    $('#manufacts_more').hide();
    $('#manufacts_less').show();
    localStorage.setItem('display_manufacts', 'more');
    
});
$('#manufacts_less').click(function(){
    $('.manufacts_div').animate({height:'66px'}, 500);
    $('#manufacts_more').show();
    $('#manufacts_less').hide();
    localStorage.setItem('display_manufacts', 'less');
});
if (localStorage.getItem('display_manufacts') == 'more') {
	$('#manufacts_more').trigger('click');
} else {
	$('#manufacts_less').trigger('click');
}

$('#filts_more').click(function(){
    $('.filts_div').animate({height:'427px'}, 500);
    $('#filts_more').hide();
    $('#filts_less').show();
    localStorage.setItem('display_filts', 'more');
    
});
$('#filts_less').click(function(){
    $('.filts_div').animate({height:'66px'}, 500);
    $('#filts_more').show();
    $('#filts_less').hide();
    localStorage.setItem('display_filts', 'less');
});
if (localStorage.getItem('display_filts') == 'more') {
	$('#filts_more').trigger('click');
} else {
	$('#filts_less').trigger('click');
}

$('#filteredp_more').click(function(){
    $('.filteredp_div').animate({height:'653px'}, 500);
    $('#filteredp_more').hide();
    $('#filteredp_less').show();
    localStorage.setItem('display_filteredp', 'more');
    
});
$('#filteredp_less').click(function(){
    $('.filteredp_div').animate({height:'223px'}, 500);
    $('#filteredp_more').show();
    $('#filteredp_less').hide();
    localStorage.setItem('display_filteredp', 'less');
});
if (localStorage.getItem('display_filteredp') == 'more') {
	$('#filteredp_more').trigger('click');
} else {
	$('#filteredp_less').trigger('click');
}

//--></script>



</div> <!-- id content -->
<?php echo $footer; ?>
