<?php echo $header; ?>
<?php echo $column_left; ?>

<!-- 
@category  : OpenCart
@module    : Smart Contact Me
@author    : OCdevWizard <ocdevwizard@gmail.com> 
@copyright : Copyright (c) 2015, OCdevWizard
@license   : http://license.ocdevwizard.com/Licensing_Policy.pdf
-->

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" formaction="<?php echo $action; ?>" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <?php if ($action_plus_status) { ?>
          <button type="submit" formaction="<?php echo $action_plus; ?>" form="form" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" id="setting-tabs">
            <li class="active dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo $tab_control_panel; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#general-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general_setting; ?></a></li>
                <li><a href="#fields-block" data-toggle="tab"><i class="fa fa-bars"></i> <?php echo $tab_fields_setting; ?></a></li>
                <li><a href="#popup-block" data-toggle="tab"><i class="fa fa-desktop"></i> <?php echo $tab_popup_setting; ?></a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-language"></i> <?php echo $tab_language_setting; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#language-block" data-toggle="tab"><i class="fa fa-flag-o"></i> <?php echo $tab_basic_language_setting; ?></a></li>
              </ul>
            </li>
          </ul>
          <div class="tab-content">
            <!-- TAB General setting -->
            <div class="tab-pane active" id="general-block">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $text_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
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
                <label class="col-sm-2 control-label" for="input-allow_admin_notify"><?php echo $text_allow_admin_notify; ?></label>
                <div class="col-sm-10">
                  <select name="allow_admin_notify" id="input-allow_admin_notify" class="form-control">
                    <?php if ($allow_admin_notify) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-admin_email_for_notifications"><?php echo $text_admin_email_for_notifications; ?></label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input value="<?php echo $admin_email_for_notifications; ?>" type="text" name="admin_email_for_notifications" class="form-control" id="input-admin_email_for_notifications" />
                  </div>
                  <?php if ($error_admin_email_for_notifications) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_admin_email_for_notifications; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_show_in_stores; ?></label>
                <div class="col-sm-10">
                  <?php $row_height = 55; $row = 0; foreach ($stores as $store) { ?>
                  <?php if ($row < 5) { $row_height = $row_height*1.26; } $row++; ?>
                  <?php } ?>
                  <div class="well well-sm" style="height: <?php echo $row_height; ?>px; overflow: auto;">
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $feedback_store)) { ?>
                        <input type="checkbox" name="feedback_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="feedback_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php $row++; ?>
                    <?php } ?>
                  </div>
                  <a class="btn btn-primary btn-sm" onclick="$(this).parent().find('input[type=checkbox]').attr('checked', true);"><?php echo $text_select_all; ?></a>
                  <a class="btn btn-warning btn-sm" onclick="$(this).parent().find(':checkbox').removeAttr('checked');"><?php echo $text_unselect_all; ?></a>
                  <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_show_in_stores_faq; ?></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_show_in_customer_groups; ?></label>
                <div class="col-sm-10">
                  <?php $row_height = 55; $row = 0; foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($row < 5) { $row_height = $row_height*1.26; } $row++; ?>
                  <?php } ?>
                  <div class="well well-sm" style="height: <?php echo $row_height; ?>px; overflow: auto;">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($customer_group['customer_group_id'], $feedback_customer_groups)) { ?>
                        <input type="checkbox" name="feedback_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                        <?php echo $customer_group['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="feedback_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                        <?php echo $customer_group['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php $row++; ?>
                    <?php } ?>
                  </div>
                  <a class="btn btn-primary btn-sm" onclick="$(this).parent().find('input[type=checkbox]').attr('checked', true);"><?php echo $text_select_all; ?></a>
                  <a class="btn btn-warning btn-sm" onclick="$(this).parent().find(':checkbox').removeAttr('checked');"><?php echo $text_unselect_all; ?></a>
                  <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_show_in_customer_groups_faq; ?></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_display_type; ?></label>
                <div class="col-sm-10">
                  <select name="display_type" class="form-control">
                    <?php if ($display_type == 2) { ?>
                      <option value="1"><?php echo $text_in_popup; ?></option>
                      <option value="2" selected="selected"><?php echo $text_in_static; ?></option>
                    <?php } else { ?>
                      <option value="1" selected="selected"><?php echo $text_in_popup; ?></option>
                      <option value="2"><?php echo $text_in_static; ?></option>
                    <?php } ?>
                  </select>
                  <?php if ($error_display_type) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_display_type; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required" style="<?php echo ($display_type == 1 && isset($this->request->get['form_id'])) ? '' : 'display:none;'; ?>" id="display-type-1">
                <label class="col-sm-2 control-label" for="input-add_id_selector"><?php echo $text_add_id_selector; ?></label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon">#</span>
                    <input value="<?php echo $add_id_selector; ?>" type="text" name="add_id_selector" class="form-control" placeholder="<?php echo $text_add_id_selector_ph; ?>" id="add_id_selector" />
                  </div>
                  <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_add_id_selector_faq; ?></div>
                  <?php if ($error_add_id_selector) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_add_id_selector; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group" style="<?php echo ($display_type == 1 && isset($this->request->get['form_id'])) ? '' : 'display:none;'; ?>" id="display-type-2">
                <label class="col-sm-2 control-label"><?php echo $text_location; ?></label>
                <div class="col-sm-10">
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success <?php echo $location == 1 ? 'active' : ''; ?>">
                      <input type="radio" 
                        name="location" 
                        value="1" 
                        autocomplete="off" 
                        <?php echo $location == 1 ? 'checked="checked"' : ''; ?> 
                      /><?php echo $text_outside_before; ?>
                    </label>
                    <label class="btn btn-success <?php echo $location == 2 ? 'active' : ''; ?>">
                      <input type="radio" 
                        name="location" 
                        value="2" 
                        autocomplete="off" 
                        <?php echo $location == 2 ? 'checked="checked"' : ''; ?> 
                      /><?php echo $text_inside_left; ?>
                    </label>
                    <label class="btn btn-success <?php echo $location == 3 ? 'active' : ''; ?>">
                      <input type="radio" 
                        name="location" 
                        value="3" 
                        autocomplete="off" 
                        <?php echo $location == 3 ? 'checked="checked"' : ''; ?> 
                      /><?php echo $text_inside_right; ?>
                    </label>
                    <label class="btn btn-success <?php echo $location == 4 ? 'active' : ''; ?>">
                      <input type="radio" 
                        name="location" 
                        value="4" 
                        autocomplete="off" 
                        <?php echo $location == 4 ? 'checked="checked"' : ''; ?> 
                      /><?php echo $text_outside_after; ?>
                    </label>
                  </div>
                  <?php if ($error_location) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_location; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <!-- TAB Language setting -->
            <div class="tab-pane" id="language-block">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_module_heading; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][heading_module]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['heading_module'] : ''; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_heading_module[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_heading_module[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_call_button_heading; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][call_button]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['call_button'] : ''; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_call_button[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_call_button[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_send_button_heading; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][send_button]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['send_button'] : ''; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_send_button[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_send_button[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_close_button_heading; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][close_button]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['close_button'] : ''; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_close_button[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_close_button[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_success_message; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <textarea name="form_description[<?php echo $language['language_id']; ?>][success_message]" placeholder="<?php echo $text_success_message; ?>" id="success_message<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['success_message'] : ''; ?></textarea>
                  </div>
                  <?php if (isset($error_success_message[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_success_message[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </div>
            <!-- TAB Configure fields set -->
            <div class="tab-pane" id="fields-block">
              <div class="row">
                <div class="col-sm-2">
                  <ul class="nav nav-pills nav-stacked" id="module">
                    <?php $field_row = 1; ?>
                    <?php foreach ($field_data as $field) { ?>
                    <li>
                      <input type="hidden" style="display:none;" name="field_data[<?php echo $field_row; ?>][sort_order]" />
                      <input type="hidden" style="display:none;" name="field_data[<?php echo $field_row; ?>][name]" value="field_<?php echo $field_row; ?>" />
                      <a href="#tab-module<?php echo $field_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-module<?php echo $field_row; ?>\']').parent().remove(); $('#tab-module<?php echo $field_row; ?>').remove(); $('#module a:first').tab('show');"></i> <?php echo $text_tab_field; ?> <?php echo '№'. $field_row; ?>
                      <span class="field_title">(<?php echo (isset($field['title'][$language['language_id']])) ? $field['title'][$language['language_id']] : ''; ?>)</span>
                      </a>
                    </li>
                    <?php $field_row++; ?>
                    <?php } ?>
                    <li id="module-add">
                      <a onclick="addField();" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo $button_add_field; ?></a>
                    </li>
                  </ul>
                </div>
                <div class="col-sm-10">
                  <div class="tab-content">
                    <?php $field_row = 1; ?>
                    <?php foreach ($field_data as $field) { ?>
                      <div class="tab-pane" id="tab-module<?php echo $field_row; ?>">
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-activate<?php echo $field_row; ?>"><?php echo $text_activate_field; ?></label>
                          <div class="col-sm-10">
                            <select name="field_data[<?php echo $field_row; ?>][activate]" class="form-control" id="input-activate<?php echo $field_row; ?>">
                              <?php if ($field['activate'] == 1) { ?>
                                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                <option value="0"><?php echo $text_no; ?></option>
                              <?php } else { ?>
                                <option value="1"><?php echo $text_yes; ?></option>
                                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-title<?php echo $field_row; ?>"><?php echo $text_heading_field; ?></label>
                          <div class="col-sm-10">
                            <?php foreach ($languages as $language) { ?>
                            <div class="input-group" style="margin-bottom: 5px;">
                              <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                              <input type="text" name="field_data[<?php echo $field_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo (isset($field['title'][$language['language_id']])) ? $field['title'][$language['language_id']] : ''; ?>" class="form-control" id="input-title<?php echo $field_row; ?>" />
                            </div>
                            <?php if (isset($error_data_fields[$field_row]['title'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_data_fields[$field_row]['title'][$language['language_id']]; ?></div>
                            <?php } ?>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-view<?php echo $field_row; ?>"><?php echo $text_assign_functionality; ?></label>
                          <div class="col-sm-10">
                            <select name="field_data[<?php echo $field_row; ?>][view]" class="form-control" id="input-view<?php echo $field_row; ?>">
                              <option value="0"><?php echo $text_make_a_choice; ?></option>
                              <?php foreach ($field_view_data as $key => $view) { ?>
                              <option value="<?php echo $key; ?>" <?php echo ($field['view'] == $key) ? 'selected="selected"' : ''; ?> ><?php echo $view; ?></option>
                              <?php } ?>
                            </select>
                            <div class="row" style="<?php echo ($field['view'] == "radio" || $field['view'] == "checkbox" || $field['view'] == "select") ? 'display:block;margin-top:15px;' : 'display:none;margin-top:15px;'; ?>">
                              <div class="col-sm-12">
                                <?php foreach ($languages as $language) { ?>
                                <div class="input-group" style="margin-bottom: 5px;">
                                  <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                                  <input type="text" name="field_data[<?php echo $field_row; ?>][view_fields][<?php echo $language['language_id']; ?>]" value="<?php echo (isset($field['view_fields'][$language['language_id']])) ? $field['view_fields'][$language['language_id']] : ''; ?>" class="form-control" />
                                </div>
                                <?php } ?>
                                <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_assign_functionality_faq; ?></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-check<?php echo $field_row; ?>"><?php echo $text_check_type; ?></label>
                          <div class="col-sm-10">
                            <select name="field_data[<?php echo $field_row; ?>][check]" class="form-control" id="input-check<?php echo $field_row; ?>">
                              <option value="0" <?php echo $field['check'] == 0 ? 'selected="selected"' : ''; ?> ><?php echo $text_validation_type_1; ?></option>
                              <option value="1" <?php echo $field['check'] == 1 ? 'selected="selected"' : ''; ?> ><?php echo $text_validation_type_2; ?></option>
                              <option value="2" <?php echo $field['check'] == 2 ? 'selected="selected"' : ''; ?> ><?php echo $text_validation_type_3; ?></option>
                              <option value="3" <?php echo $field['check'] == 3 ? 'selected="selected"' : ''; ?> ><?php echo $text_validation_type_4; ?></option>
                            </select>
                            <div class="input-group" style="<?php echo $field['check'] == 2 ? 'display:table;margin-top:15px;' : 'display:none;margin-top:15px;'; ?>">
                              <span class="input-group-addon"><i class="fa fa-filter"></i></span>
                              <input type="text" placeholder="<?php echo $text_validation_type_3_ph; ?>" name="field_data[<?php echo $field_row; ?>][check_rule]" value="<?php echo $field['check_rule']; ?>" class="form-control" />
                            </div>
                            <div class="input-group" style="<?php echo $field['check'] == 3 ? 'display:table;margin-top:15px;' : 'display:none;margin-top:15px;'; ?>">
                              <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                              <input type="text" placeholder="<?php echo $text_validation_type_4_1_ph; ?>" name="field_data[<?php echo $field_row; ?>][check_min]" value="<?php echo $field['check_min']; ?>" class="form-control" />
                            </div>
                            <div class="input-group" style="<?php echo $field['check'] == 3 ? 'display:table;margin-top:15px;' : 'display:none;margin-top:15px;'; ?>">
                              <span class="input-group-addon"><i class="fa fa-chevron-left"></i></span>
                              <input type="text" placeholder="<?php echo $text_validation_type_4_2_ph; ?>" name="field_data[<?php echo $field_row; ?>][check_max]" value="<?php echo $field['check_max']; ?>" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-mask<?php echo $field_row; ?>"><?php echo $text_mask; ?></label>
                          <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                              <input value="<?php echo $field['mask']; ?>" type="text" name="field_data[<?php echo $field_row; ?>][mask]" class="form-control" placeholder="<?php echo $text_mask_ph; ?>" id="input-mask<?php echo $field_row; ?>" />
                            </div>
                            <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_mask_faq; ?></div>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-error_text<?php echo $field_row; ?>"><?php echo $text_error_text; ?></label>
                          <div class="col-sm-10">
                            <?php foreach ($languages as $language) { ?>
                            <div class="input-group" style="margin-bottom: 5px;">
                              <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                              <input type="text" name="field_data[<?php echo $field_row; ?>][error_text][<?php echo $language['language_id']; ?>]" value="<?php echo (isset($field['error_text'][$language['language_id']])) ? $field['error_text'][$language['language_id']] : ''; ?>" class="form-control" id="input-error_text<?php echo $field_row; ?>" />
                            </div>
                            <?php if (isset($error_data_fields[$field_row]['error_text'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_data_fields[$field_row]['error_text'][$language['language_id']]; ?></div>
                            <?php } ?>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-css_id<?php echo $field_row; ?>"><?php echo $text_css_id; ?></label>
                          <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon">#</span>
                              <input value="<?php echo $field['css_id']; ?>" type="text" name="field_data[<?php echo $field_row; ?>][css_id]" class="form-control" placeholder="<?php echo $text_css_id_ph; ?>" id="input-css_id<?php echo $field_row; ?>" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-css_class<?php echo $field_row; ?>"><?php echo $text_css_class; ?></label>
                          <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon">&#8226;</span>
                              <input value="<?php echo $field['css_class']; ?>" type="text" name="field_data[<?php echo $field_row; ?>][css_class]" class="form-control" placeholder="<?php echo $text_css_class_ph; ?>" id="input-css_class<?php echo $field_row; ?>" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group position_field" style="<?php echo ($display_type == 1 && !empty($display_type)) ? 'display:block;' : 'display:none;'; ?>">
                          <label class="col-sm-2 control-label"><?php echo $text_position; ?></label>
                          <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn btn-success <?php echo $field['position'] == 1 ? 'active' : ''; ?>">
                                <input type="radio" 
                                  name="field_data[<?php echo $field_row; ?>][position]" 
                                  value="1" 
                                  autocomplete="off" 
                                  <?php echo $field['position'] == 1 ? 'checked="checked"' : ''; ?> 
                                /><?php echo $text_left_side; ?>
                              </label>
                              <label class="btn btn-success <?php echo $field['position'] == 3 ? 'active' : ''; ?>">
                                <input type="radio" 
                                  name="field_data[<?php echo $field_row; ?>][position]" 
                                  value="3" 
                                  autocomplete="off" 
                                  <?php echo $field['position'] == 3 ? 'checked="checked"' : ''; ?> 
                                /><?php echo $text_center; ?>
                              </label>
                              <label class="btn btn-success <?php echo $field['position'] == 2 ? 'active' : ''; ?>">
                                <input type="radio" 
                                  name="field_data[<?php echo $field_row; ?>][position]" 
                                  value="2" 
                                  autocomplete="off" 
                                  <?php echo $field['position'] == 2 ? 'checked="checked"' : ''; ?> 
                                /><?php echo $text_right_side; ?>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php $field_row++; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
             <!-- TAB Popup settings -->
            <div class="tab-pane" id="popup-block">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_background_images; ?></label>
                <div class="col-sm-10">
                  <div class="input-group div_background_images">
                    <?php if ($backgrounds) { ?>
                    <?php $key = 1; foreach ($backgrounds as $bg) { ?>
                    <input type="radio" name="background" id="label_img_<?php echo $key; ?>" value="<?php echo $bg['name']; ?>" <?php echo (!empty($background) && $background == $bg['name']) ? 'checked' : ''; ?> />
                    <label class="background_for_label" for="label_img_<?php echo $key; ?>" style="background:url(<?php echo $bg['src']; ?>);"></label>
                    <?php $key++; } ?>
                  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_background_opacity; ?></label>
                <div class="col-xs-10 col-sm-3 col-md-2 col-lg-2">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="button" onclick="if(parseInt($(this).parent().next().val())>=1){$(this).parent().next().val(~~$(this).parent().next().val()-1)}">-</button>
                    </span>
                    <input type="text" value="<?php echo (!empty($background_opacity)) ? $background_opacity : 0; ?>" name="background_opacity" class="form-control" />
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="button" onclick="if(parseInt($(this).parent().prev().val())<=9){$(this).parent().prev().val(~~$(this).parent().prev().val()+1)}">+</button>
                    </span>
                  </div>
                  <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_background_opacity_faq; ?></div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript"><!--
  var field_row = <?php echo $field_row; ?>;

  function addField() {
    html  = '<div class="tab-pane" id="tab-module' + field_row + '">';
    html += '   <input type="hidden" style="display:none;" name="field_data[' + field_row + '][sort_order]" />';
    html += '   <input type="hidden" style="display:none;" name="field_data[' + field_row + '][name]" value="field_' + field_row + '" />';
    html += '   <div class="form-group">';
    html += '     <label class="col-sm-2 control-label" for="input-activate' + field_row + '"><?php echo $text_activate_field; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <select name="field_data[' + field_row + '][activate]" class="form-control" id="input-activate' + field_row + '">';
    html += '         <option value="1"><?php echo $text_yes; ?></option><option value="0" selected="selected"><?php echo $text_no; ?></option>';
    html += '       </select>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group required">';
    html += '     <label class="col-sm-2 control-label" for="input-title' + field_row + '"><?php echo $text_heading_field; ?></label>';
    html += '     <div class="col-sm-10">';
                  <?php foreach ($languages as $language) { ?>
    html += '       <div class="input-group" style="margin-bottom: 5px;">';
    html += '         <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';
    html += '         <input type="text" name="field_data[' + field_row + '][title][<?php echo $language['language_id']; ?>]" value="" class="form-control" id="input-title' + field_row + '" />';
    html += '       </div>';
                  <?php if (isset($error_data_fields[$field_row]['title'][$language['language_id']])) { ?>
    html += '       <div class="text-danger"><?php echo $error_data_fields[' + field_row + ']['title'][$language['language_id']]; ?></div>';
                  <?php } ?>
                  <?php } ?>
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group required">';
    html += '     <label class="col-sm-2 control-label" for="input-view' + field_row + '"><?php echo $text_assign_functionality; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <select name="field_data[' + field_row + '][view]" class="form-control" id="input-view' + field_row + '">';
    html += '         <option value="0"><?php echo $text_make_a_choice; ?></option>';
                      <?php foreach ($field_view_data as $key => $view) { ?>
    html += '         <option value="<?php echo $key; ?>"><?php echo $view; ?></option>';
                      <?php } ?>
    html += '       </select>';
    html += '       <div class="row" style="display:none;margin-top:15px;">';
    html += '         <div class="col-sm-12">';
                        <?php foreach ($languages as $language) { ?>
    html += '             <div class="input-group" style="margin-bottom: 5px;">';
    html += '               <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';
    html += '               <input type="text" name="field_data[' + field_row + '][view_fields][<?php echo $language['language_id']; ?>]" value="" class="form-control" />';
    html += '             </div>';
                        <?php } ?>
    html += '           <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_assign_functionality_faq; ?></div>';
    html += '         </div>';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group">';
    html += '     <label class="col-sm-2 control-label" for="input-check' + field_row + '"><?php echo $text_check_type; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <select name="field_data[' + field_row + '][check]" class="form-control" id="input-check' + field_row + '">';
    html += '         <option value="0"><?php echo $text_validation_type_1; ?></option>';
    html += '         <option value="1"><?php echo $text_validation_type_2; ?></option>';
    html += '         <option value="2"><?php echo $text_validation_type_3; ?></option>';
    html += '         <option value="3"><?php echo $text_validation_type_4; ?></option>';
    html += '       </select>';
    html += '       <div class="input-group" style="display:none;margin-top:15px;">';
    html += '         <span class="input-group-addon"><i class="fa fa-filter"></i></span>';
    html += '         <input type="text" placeholder="" name="field_data[' + field_row + '][check_rule]" value="" class="form-control" />';
    html += '       </div>';
    html += '       <div class="input-group" style="display:none;margin-top:15px;">';
    html += '         <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>';
    html += '         <input type="text" placeholder="<?php echo $text_validation_type_4_1_ph; ?>" name="field_data[' + field_row + '][check_min]" value="" class="form-control" />';
    html += '       </div>';
    html += '       <div class="input-group" style="display:none;margin-top:15px;">';
    html += '         <span class="input-group-addon"><i class="fa fa-chevron-left"></i></span>';
    html += '         <input type="text" placeholder="<?php echo $text_validation_type_4_2_ph; ?>" name="field_data[' + field_row + '][check_max]" value="" class="form-control" />';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group">';
    html += '     <label class="col-sm-2 control-label" for="input-mask' + field_row + '"><?php echo $text_mask; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <div class="input-group">';
    html += '         <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>';
    html += '         <input value="" type="text" name="field_data[' + field_row + '][mask]" class="form-control" placeholder="<?php echo $text_mask_ph; ?>" id="input-mask' + field_row + '" />';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group required">';
    html += '     <label class="col-sm-2 control-label" for="input-error_text' + field_row + '"><?php echo $text_error_text; ?></label>';
    html += '     <div class="col-sm-10">';
                  <?php foreach ($languages as $language) { ?>
    html += '       <div class="input-group" style="margin-bottom: 5px;">';
    html += '         <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';
    html += '         <input type="text" name="field_data[' + field_row + '][error_text][<?php echo $language['language_id']; ?>]" value="<?php echo $error_for_all_field; ?>" class="form-control" id="input-error_text' + field_row + '" />';
    html += '       </div>';
                  <?php if (isset($error_data_fields[$field_row]['error_text'][$language['language_id']])) { ?>
    html += '       <div class="text-danger"><?php echo $error_data_fields[' + field_row + ']['error_text'][$language['language_id']]; ?></div>';
                  <?php } ?>
                  <?php } ?>
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group">';
    html += '     <label class="col-sm-2 control-label" for="input-css_id' + field_row + '"><?php echo $text_css_id; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <div class="input-group">';
    html += '         <span class="input-group-addon">#</span>';
    html += '         <input value="" type="text" name="field_data[' + field_row + '][css_id]" class="form-control" placeholder="<?php echo $text_css_id_ph; ?>" id="input-css_id' + field_row + '" />';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group">';
    html += '     <label class="col-sm-2 control-label" for="input-css_class' + field_row + '"><?php echo $text_css_class; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <div class="input-group">';
    html += '         <span class="input-group-addon">&#8226;</span>';
    html += '         <input value="" type="text" name="field_data[' + field_row + '][css_class]" class="form-control" placeholder="<?php echo $text_css_class_ph; ?>" id="input-css_class' + field_row + '" />';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';
    html += '   <div class="form-group position_field">';
    html += '     <label class="col-sm-2 control-label"><?php echo $text_position; ?></label>';
    html += '     <div class="col-sm-10">';
    html += '       <div class="btn-group" data-toggle="buttons">';
    html += '         <label class="btn btn-success">';
    html += '           <input type="radio" name="field_data[' + field_row + '][position]" value="1" autocomplete="off" /><?php echo $text_left_side; ?>';
    html += '         </label>';
    html += '         <label class="btn btn-success active">';
    html += '           <input type="radio" name="field_data[' + field_row + '][position]" value="3" autocomplete="off" checked="checked" /><?php echo $text_center; ?>';
    html += '         </label>';
    html += '         <label class="btn btn-success">';
    html += '           <input type="radio" name="field_data[' + field_row + '][position]" value="2" autocomplete="off" /><?php echo $text_right_side; ?>';
    html += '         </label>';
    html += '       </div>';
    html += '     </div>';
    html += '   </div>';

    $('#fields-block .tab-content:first-child').append(html);

    $('#module-add').before('<li class="no_field_title"><a href="#tab-module' + field_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-module' + field_row + '\\\']\').parent().remove(); $(\'#tab-module' + field_row + '\').remove(); $(\'#module a:first\').tab(\'show\');"></i> <?php echo $text_tab_field; ?> №' + field_row + '</a></li>');
    $('#module a[href=\'#tab-module' + field_row + '\']').tab('show');
    $('#module a[href=\'#tab-module2' + field_row + '\']').tab('show');
  
    $('select[name*=check]').change(function() {
      var val = $(this).val();
      if (val == 2) {
        $(this).next().show();
        $(this).next().next().hide();
        $(this).next().next().next().hide();
      } else if(val == 3) {
        $(this).next().hide();
        $(this).next().next().show();
        $(this).next().next().next().show();
      } else {
        $(this).next().hide();
        $(this).next().next().hide();
        $(this).next().next().next().hide();
      }
    });

    $('select[name*=display_type]').change(function() {
      var val = $(this).val();

      if (val == 1) {
        $('#display-type-1').show();
        $('#display-type-2').show();
        $('.position_field').show();
      } else if(val == 2) {
        $('#display-type-1').hide();
        $('#display-type-2').hide();
        $('.position_field').hide();
      } else {
        $('#display-type-1').show();
        $('#display-type-2').show();
        $('.position_field').show();
      }
    });

    if ($('select[name*=display_type]').val() != "1") {
      $('.position_field').hide();
    }

    $('select[name*=view]').change(function() {
      var val = $(this).val();

      if (val == "radio" || val == "checkbox" || val == "select") {
        $(this).next().show();
      } else {
        $(this).next().hide();
      }
    });

    field_row++;
  }

$('select[name*=check]').change(function() {
  var val = $(this).val();

   if (val == 2) {
    $(this).next().show();
    $(this).next().next().hide();
    $(this).next().next().next().hide();
   } else if(val == 3) {
    $(this).next().hide();
    $(this).next().next().show();
    $(this).next().next().next().show();
   } else {
    $(this).next().hide();
    $(this).next().next().hide();
    $(this).next().next().next().hide();
   }
});

$('select[name*=view]').change(function() {
  var val = $(this).val();

  if (val == "radio" || val == "checkbox" || val == "select") {
    $(this).next().show();
  } else {
    $(this).next().hide();
  }
});

$('select[name*=display_type]').change(function() {
  var val = $(this).val();

  if (val == 1) {
    $('#display-type-1').show();
    $('#display-type-2').show();
    $('.position_field').show();
  } else if(val == 2) {
    $('#display-type-1').hide();
    $('#display-type-2').hide();
    $('.position_field').hide();
  } else {
    $('#display-type-1').show();
    $('#display-type-2').show();
    $('.position_field').show();
  }
});

<?php foreach ($languages as $language) { ?>
$('#success_message<?php echo $language['language_id']; ?>').summernote({
  height: 100
});
<?php } ?>

$('#module li:first-child a').tab('show');

$('#fields-block .nav-pills').sortable({
  forcePlaceholderSize: true,
  items: '> li:not(#module-add)',
  cursor: "move",
  axis: "y",
  placeholder: 'tab-placeholder',
});

if (window.localStorage && window.localStorage['last_active_tab']) {
  $('#setting-tabs a[href=' + window.localStorage['last_active_tab'] + ']').trigger('click');
}
$('#setting-tabs a[data-toggle="tab"]').click(function() {
  if (window.localStorage) {
    window.localStorage['last_active_tab'] = $(this).attr('href');
  }
});
//--></script> 
</div>
<?php echo $footer; ?>