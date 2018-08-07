<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-speedup" data-loading="loading..." data-toggle="tooltip" title="<?php echo $button_save_exit; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="submit" onclick="$('#form-speedup').attr('action','<?php echo $stay_action ?>').submit(); return;" form="form-speedup" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
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
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-speedup" class="form-horizontal">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-compress" data-toggle="tab"><?php echo $tab_compress; ?></a></li>
                <li><a href="#tab-database" data-toggle="tab"><?php echo $tab_database; ?></a></li>
                <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                <li><a href="#tab-speed-test" data-toggle="tab"><?php echo $tab_speed_test; ?></a></li>
                <li><a href="#tab-cache" data-toggle="tab"><?php echo $tab_cache; ?></a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="speedup_status" id="input-status" class="form-control">
                    <?php if ($speedup_status) { ?>
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
                <label class="col-sm-2 control-label" for="speedup_timezone"><?php echo $entry_default_time_zone; ?></label>
                <div class="col-sm-10">
                  <select name="speedup_timezone" id="speedup_timezone" class="form-control">
                    <?php foreach ($timezones as $timezone) { ?>
                    <?php if ($timezone == $speedup_timezone) { ?>
                    <option value="<?php echo $timezone; ?>" selected="selected"><?php echo $timezone; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $timezone; ?>"><?php echo $timezone; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_notfound_page; ?></label>
                <div class="col-sm-10">
                  <select name="speedup_notfound_page" id="input-status" class="form-control">
                    <?php if ($speedup_notfound_page) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-compress">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-minify_css"><?php echo $entry_minify_css; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_minify_css" id="input-minify_css" class="form-control">
                        <?php if ($speedup_minify_css) { ?>
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
                    <label class="col-sm-2 control-label" for="input-minify_js"><?php echo $entry_minify_js; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_minify_js" id="input-minify_js" class="form-control">
                        <?php if ($speedup_minify_js) { ?>
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
                    <label class="col-sm-2 control-label" for="input-minify_html"><?php echo $entry_minify_html; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_minify_html" id="input-minify_html" class="form-control">
                        <?php if ($speedup_minify_html) { ?>
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
                    <label class="col-sm-2 control-label" for="input-defer"><?php echo $entry_defer; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_defer" id="input-defer" class="form-control">
                        <?php if ($speedup_defer) { ?>
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
                      <label class="col-sm-2 control-label" for="input-compression"><?php echo $entry_compression; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="speedup_compression" value="<?php echo $speedup_compression; ?>" placeholder="Output Compression Level" id="input-compression" class="form-control" />
                      </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="optimize_css_js"><?php echo $entry_compress_css_js; ?></label>
                    <div class="col-sm-10">
                      <button type="button" id="optimize_css_js" data-loading="loading..." data-toggle="tooltip" title="<?php echo $entry_compress_css_js; ?>" class="btn btn-success"><i class="fa fa-dashboard"></i></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="clear_cache"><?php echo $entry_clear_cache; ?></label>
                    <div class="col-sm-10">
                      <button id="clear_cache" data-loading="loading..." data-toggle="tooltip" title="<?php echo $entry_clear_cache_tip; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
            </div>
            <div class="tab-pane" id="tab-image">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-image_dimensions"><?php echo $entry_image_dimensions; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_image_dimensions" id="input-image_dimensions" class="form-control">
                        <?php if ($speedup_image_dimensions) { ?>
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
                    <label class="col-sm-2 control-label" for="input-image_lazyload"><?php echo $entry_image_lazyload; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_image_lazyload" id="input-image_lazyload" class="form-control">
                        <?php if ($speedup_image_lazyload) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <fieldset>
                <legend><?php echo $image_crusher_title; ?></legend>
                <div class="form-group col-sm-12">
                    <p><?php echo $image_crusher_image_manager_text; ?></p>
                    <p><?php echo $image_crusher_excluded_filetypes; ?></p>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $image_crusher_switch_title; ?></label>
                        <div class="col-sm-10">
                          <select name="speedup_image_optimise_on" id="image_crusher_image_optimise_on" class="form-control">
                            <option value="off" <?php echo $image_crusher_switch_setting_off; ?>><?php echo $text_off; ?></option>
                            <option value="on" <?php echo $image_crusher_switch_setting_on; ?>><?php echo $text_on; ?></option>
                          </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $image_crusher_compression_level_title; ?></label>
                        <div class="col-sm-10">
                            <input type="range" id="image_crusher_compression_level" class="image_crusher_compression_level" name="speedup_compression_level" min="1" max="10" value="<?php echo $image_crusher_default_compression_level; ?>" step="1" onchange="showValue(this.value, 'new-image-range')">
                            <div class="levellabel">
                            <?php echo $image_crusher_compression_level_label; ?><span id="new-image-range"><?php echo $image_crusher_default_compression_level; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                </fieldset>
                <fieldset>
                <legend><?php echo $image_crusher_existing_images_title; ?></legend>
                <div class="form-group col-sm-12">
                    <p><?php echo $image_crusher_existing_images_text; ?></p>
                    <div class="warning">
                      <p><strong><?php echo $image_crusher_existing_images_warning_title; ?></strong></p>
                      <p><?php echo $image_crusher_existing_images_warning_text; ?></p>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $image_crusher_compression_level_title; ?></label>
                        <div class="col-sm-10">
                            <input type="range" class="image_crusher_compression_level" id="image_crusher_existing_image_compression_level" name="speedup_existing_image_compression_level" min="1" max="10" value="<?php echo $image_crusher_existing_image_compression_level; ?>" step="1" onchange="showValue(this.value, 'existing-image-range')">
                            <div class="levellabel">
                            <?php echo $image_crusher_compression_level_label; ?> <span id="existing-image-range"><?php echo $image_crusher_existing_image_compression_level; ?></span>
                            </div>
                            <div><?php echo $image_crusher_compression_level_text; ?></div>
                        </div>
                    </div> 
                    <div class="existing-images-input-box">
                      <p><?php echo $image_crusher_existing_images_image_folder_text; ?> </p>
                      <div class="input-group">
  						<input type="text" name="speedup_existing_images_folder" id="image_crusher_existing_images_folder" placeholder="<?php echo $image_crusher_existing_images_image_folder_placeholder_text; ?> " value="" class="form-control">
  					    <a href="" data-toggle="folder" style="float: right;position: absolute;"><span class="input-group-addon" ><i class="glyphicon glyphicon-pencil" style="font-size: 16px;"></i></span></a>
  					  </div>
                      <div class="label label-danger" id="error_crush_folder"></div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-success btn-lg" id="existing-images-submit"><?php echo $image_crusher_existing_images_submit_button; ?></button>
                    <div id="existing-images-dialog-confirm" title="Crush Existing Images?">
                      <p><?php echo $image_crusher_existing_images_popup_text_1; ?></p>
                      <p><?php echo $image_crusher_existing_images_popup_text_2; ?></p>
                    </div>
                </div>
                </fieldset>
            </div>
            <div class="tab-pane" id="tab-database">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-url_alias_cache"><?php echo $entry_url_alias_cache; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_url_alias_cache" id="input-url_alias_cache" class="form-control">
                        <?php if ($speedup_url_alias_cache) { ?>
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
                    <label class="col-sm-2 control-label" for="input-product_count"><?php echo $entry_product_count; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_product_count" id="input-product_count" class="form-control">
                        <?php if ($speedup_product_count) { ?>
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
                    <label class="col-sm-2 control-label" for="optimize_table"><?php echo $entry_optimize_table; ?></label>
                    <div class="col-sm-10">
                      <button id="optimize_table" data-loading="loading..." data-toggle="tooltip" title="<?php echo $entry_optimize_table; ?>" class="btn btn-success"><i class="fa fa-dashboard"></i></button>
                    </div>
                  </div>
            </div>
            <div class="tab-pane" id="tab-speed-test">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-api-key"><?php echo $text_api_key; ?></label>
                    <div class="col-sm-5">
                      <input type="text" name="speedup_test_api_key" value="<?php echo $speedup_test_api_key; ?>" placeholder="<?php echo $text_api_key; ?>" id="input-api-key" class="form-control" />
                      <?php if ($error_api_key) { ?>
                      <div class="text-danger"><?php echo $error_api_key; ?></div>
                      <?php } ?>
                    </div>
                    <label class="col-sm-5 text-left"><?php echo $note_api_key; ?></label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-url"><?php echo $text_url; ?></label>
                    <div class="col-sm-5">
                      <input type="text" name="speedup_test_url" value="<?php echo $speedup_test_url; ?>" placeholder="<?php echo $text_url; ?>" id="input-url" class="form-control" />
                      <?php if ($error_url) { ?>
                      <div class="text-danger"><?php echo $error_url; ?></div>
                      <?php } ?>
                    </div>
                    <label class="col-sm-5 text-left"><?php echo $note_url; ?></label>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label" for="input-resources"><?php echo $text_filter_third_party_resource; ?></label>
                    <div class="col-sm-5">
                        <select name="speedup_test_resources" id="input-resources" class="form-control">
                        <?php if (isset($speedup_test_resources)) { ?>
                        <option value="true" <?php if($speedup_test_resources == 'true') { ?> selected="selected" <?php } ?>><?php echo $text_true; ?></option>
                        <option value="false" <?php if($speedup_test_resources == 'false') { ?> selected="selected" <?php } ?>><?php echo $text_false; ?></option>
                        <?php } else { ?>
                        <option value="true" selected="selected"><?php echo $text_true; ?></option>
                        <option value="false"><?php echo $text_false; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                <label class="col-sm-5 text-left"><?php echo $note_filter_third_party_resource; ?></label>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label" for="input-screenshot"><?php echo $text_screenshot; ?></label>
                    <div class="col-sm-5">
                        <select name="speedup_test_screenshot" id="input-screenshot" class="form-control">
                        <?php if (isset($speedup_test_screenshot)) { ?>
                        <option value="true" <?php if($speedup_test_screenshot == 'true') { ?> selected="selected" <?php } ?>><?php echo $text_true; ?></option>
                        <option value="false" <?php if($speedup_test_screenshot == 'false') { ?> selected="selected" <?php } ?>><?php echo $text_false; ?></option>
                        <?php } else { ?>
                        <option value="true" selected="selected"><?php echo $text_true; ?></option>
                        <option value="false"><?php echo $text_false; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                <label class="col-sm-5 text-left"><?php echo $note_screenshot; ?></label>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label" for="input-strategy"><?php echo $text_strategy; ?></label>
                    <div class="col-sm-5">
                        <select name="speedup_test_strategy" id="input-strategy" class="form-control">
                        <?php if ($speedup_test_strategy) { ?>
                        <option value="desktop" <?php if($speedup_test_strategy == 'desktop') { ?> selected="selected" <?php } ?>><?php echo $text_desktop; ?></option>
                        <option value="mobile" <?php if($speedup_test_strategy == 'mobile') { ?> selected="selected" <?php } ?>><?php echo $text_mobile; ?></option>
                        <?php } else { ?>
                        <option value="desktop" selected="selected"><?php echo $text_desktop; ?></option>
                        <option value="mobile"><?php echo $text_mobile; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                <label class="col-sm-5 text-left"><?php echo $note_strategy; ?></label>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5">
                      <button type="button" name="execute" id="execute" class="btn btn-success form-control"><?php echo $btn_execute; ?></button>
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </div>
            <div class="tab-pane" id="tab-cache">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-db_cache"><?php echo $entry_db_cache; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_db_cache" id="input-db_cache" class="form-control">
                        <?php if ($speedup_db_cache) { ?>
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
                  <label class="col-sm-2 control-label" for="input-page_cache_expire_time"><?php echo $entry_page_cache_expire_time; ?></label>
                  <div class="col-sm-10">
                    <input type="number" name="speedup_cache_expire_time" value="<?php echo $speedup_cache_expire_time; ?>" placeholder="Cache Expire Time (Seconds)" id="input-page_cache_expire_time" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-page_cache"><?php echo $entry_page_cache; ?></label>
                    <div class="col-sm-10">
                      <select name="speedup_page_cache" id="input-page_cache" class="form-control">
                        <?php if ($speedup_page_cache) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="col-md-12" id="show-page-cache" style="display: none;">
                    <fieldset>
                        <div class="form-group col-sm-12">
                            <legend><h2><?php print $speedup_cache_header_cachestat;?></h2></legend>
                            <table class='table'>
                              <thead>
                              <tr>
                                <td class='left'><?php print $speedup_cache_td_cf;?></td>
                                <td class='left'><?php print $speedup_cache_td_total;?></td>
                                <td class='left'><?php print $speedup_cache_td_space;?></td>
                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                <td class='left'><?php print $speedup_cache_td_valid;?></td>
                                <td class='left' id="totalfv"><?php print $speedup_cache_wait;?></td>
                                <td class='left'><span id='totalbv'><?php print $speedup_cache_wait;?></span> MB</td>
                              </tr>
                              <tr>
                                <td class='left'><?php print $speedup_cache_td_expired;?></td>
                                <td class='left' id="totalfe"><?php print $speedup_cache_wait;?></td>
                                <td class='left'><span id='totalbe'><?php print $speedup_cache_wait;?></span> MB</td>
                              <tr>
                                <td class='left'><?php print $speedup_cache_td_total;?></td>
                                <td class='left' style='font-weight:bold;' id="totalf"><?php print $speedup_cache_wait;?></td>
                                <td class='left'><span id='totalb'><?php print $speedup_cache_wait;?></span> MB</td>
                              </tr>
                              </tbody>
                            </table>
                            <a id="refreshstats" class="btn btn-primary" style="margin: 2pt;">
                              <?php print $speedup_cache_btn_refresh;?>
                            </a>
                            <a id="purgeall" class="btn btn-primary" style="margin: 2pt;">
                              <?php print $speedup_cache_btn_purge;?>
                            </a>
                            <a id="purgeexpired" class="btn btn-primary" style="margin: 2pt;">
                              <?php print $speedup_cache_btn_purgeexp;?>
                            </a>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group col-sm-12 text-capitalize">
                            <legend><h2><?php print $speedup_cache_header_settings;?></h2></legend>
                            <span><?php print $speedup_cache_settings_note;?></span>
                            <table class='table'>
                              <thead>
                              <tr>
                                <td class='left'><?php print $speedup_cache_td_setting;?></td>
                                <td class='left'><?php print $speedup_cache_td_value;?></td>
                                <td class='left'><?php print $speedup_cache_td_detail;?></td>
                              </tr>
                              </thead>
                              <tbody>
                              <td class='left'>cachefolder</td><td class='left'><?php echo $cachefolder;?></td>
                                <td class='left'><?php print $speedup_cache_cachefolder_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>expire</td><td class='left'><?php echo $expire;?></td>
                                <td class='left'><?php print $speedup_cache_expire_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>lang</td><td class='left'><?php echo $lang;?></td>
                                <td class='left'><?php print $speedup_cache_lang_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>currency</td><td class='left'><?php echo $currency;?></td>
                                <td class='left'><?php print $speedup_cache_currency_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>addcomment</td><td class='left'><?php echo $addcomment;?></td>
                                <td class='left'><?php print $speedup_cache_addcomment_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>wrapcomment</td><td class='left'><?php echo $wrapcomment;?></td>
                                <td class='left'><?php print $speedup_cache_wrapcomment_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>end_flush</td><td class='left'><?php echo $end_flush;?></td>
                                <td class='left'><?php print $speedup_cache_end_flush_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>cachebydevice</td><td class='left'><?php echo $cachebydevice;?></td>
                                <td class='left'><?php print $speedup_cache_cachebydevice_note;?></td>
                              </tr>
                              <tr>
                                <td class='left'>skip_urls</td>
                                <td class='left'><?php echo join('<br>',$skip_urls);?></td>
                                <td class='left'><?php print $speedup_cache_skipurls_note;?></td>
                              </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div id="image-crush-results"></div>
  </div>
</div>
<div class="optimize_table modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Database Table Optimize Result..!</h4>
      </div>
      <div class="modal-body">
        <center><p>Msg "<b>OK</b>" means table has just been optimized. Otherwise Table is up to date..!</p>
        <p><b>Note: </b>Please Regularly Optimize Your Database</p></center>
        <table class="optimize_msg_table table table-bordered table-hover"></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" role="dialog" id="crush_results">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crush Images Result..!</h4>
      </div>
      <div class="modal-body" id="crush-results">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" role="dialog" id="compress_results">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Compress File Result..!</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="page-speed-test">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $text_result_text; ?></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="optimize_css_js modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">CSS Or JS Listing</h4>
      </div>
      <div class="modal-body" id="crush-results">
      <?php displaysub($cssjs); ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit-css-js" class="btn btn-success">Choose</button>
      </div>
    </div>
  </div>
</div>
<?php $i = 0;
  function displaysub($sub = array()){ global $i; ?>
    <ul class="directory-ul">
    <?php foreach ($sub as $name => $file) { ?>
      <?php if(is_numeric($name)){ ?>
        <li>
            <label for="<?php echo $i ?>">
              <input type="checkbox" id="<?php echo $i++ ?>" value="<?php echo $file ?>" name="compressfile[]" class="compressfiles" />
              <span><?php echo basename($file) ?></span>
            </label>
        </li>
      <?php }else if(is_array($file) && $file){ ?>
        <li>
            <div class="colleps open">-</div>
            <label for="<?php echo $i ?>" class="folder">
            <span><?php echo $name ?></span>
            </label>        
            <?php displaysub($file); ?>
        </li>
      <?php } ?>
    <?php } ?>
    </ul>
<?php } ?>
<style type="text/css">
#file-listing{border: 1px solid red;}
.note{font-size: 85%;color: #999;}
.section-wrap {background-color: #F8F8F8;border-radius: 8px;padding: 1em;border: 1px solid #E0E0E0;margin: 1em 0 1em 0;}
.image_crusher_compression_level {width: 40%;}
#form-image_crusher input[type='range'] {width: 40%;}
.levellabel {text-align: center;font-size: 20px;margin-top: 10px;margin-left: -110px;}
.title {padding-top: 30px;text-transform: uppercase;color: #ffa500;font-weight: bold;}
.warning {background-color: #f38733;border-radius: 4px;padding: 1em;width: 100%;color: #FFFFFF;font-weight: 500;}
.existing-images-input-box {margin-top: 2em;}
#existing-images-dialog-confirm {display:none;margin-bottom: 2em;overflow: visible;}
#image-crush-results {margin-top: 0.8em;position: fixed;top: 45%;left: 45%;border-radius: 60px;}
#image-crush-results .error {color: #f00;}
.checkmark {display:inline-block;width: 60px;transform: rotate(45deg);}
ul{list-style: none;}
.folder span{  position: relative;padding: 15px;top: -3px;}
.folder{position: relative;}
.folder:before{content: '';position: absolute;height: 15px;background: url(/index.php?img=pngFolder) 0 0 no-repeat;width: 15px;
  left: 20px;}
.colleps{height: 15px;padding: 0;display: inline-block;width: 15px;line-height: 15px;font-size: 17px;cursor: pointer;text-align: center;vertical-align: middle;position: relative;top: -4px;left:0;box-shadow: 0 0 1px #aaa;background-color: #E5E5E5;border: 1px solid #A7A7A7;border-radius: 2px;}
.optimize_css_js .modal-body,#compress_results .modal-body,#crush-results{max-height: 600px;overflow: auto;}
.directory-ul li .folder{margin-left: -10px;}
</style>
<script type="text/javascript">
// Speed Test
$('#execute').on('click', function() {
    var api = $('input[name=\'speedup_test_api_key\']').val();
    var url = $('input[name=\'speedup_test_url\']').val();
    var resources = $('select[name=\'speedup_test_resources\']').val();
    var screenshot = $('select[name=\'speedup_test_screenshot\']').val();
    var strategy = $('select[name=\'speedup_test_strategy\']').val();
    $.ajax({
        url: 'index.php?route=extension/module/speedup/test_results',
        data: 'api=' + api + '&url=' + url + '&resources=' + resources + '&screenshot=' + screenshot + '&strategy=' + strategy + '&token='+getURLVar('token'), 
        type: 'get',
        dataType: 'html',
        beforeSend: function() {
            $('#execute').button('loading');
        },
        success: function(html) {
            $('#page-speed-test .modal-body').html(html);
            $("#page-speed-test").modal();
        },
        complete: function() {
            $('#execute').button('reset');
        },
    });
});

// Folder Collapse
$('.colleps').click(function(){
    var open = $(this).hasClass('open');
    var li = $(this).parent('li');
    if(open){
      $(li).children('ul').hide();
      $(this).html('+');
      $(this).removeClass('open');
    }else{
      $(li).children('ul').show();
      $(this).html('-');
      $(this).addClass('open');
    }
    return false;
});

// CSS JS Compress Ajax
$('#optimize_css_js').click(function(){
    $('.optimize_css_js').modal('show');
});
$('#submit-css-js').click(function(){
  var compressfile = $('input[type=checkbox]').serialize();
  if(compressfile == ''){
    alert("Select CSS Or JS Files..!");
    return false;
  }
  if(!confirm('Are You Sure to Optimize CSS Or JS Files, Click OK And Optimize CSS Or JS Files For Fast loading Site.')) return false;
  var _t = $(this);
  $(_t).button('loading');
  $.ajax({
    url:"<?php echo html_entity_decode($compress_css_js) ?>",
    type:"POST",
    data:compressfile,
    dataType:"json",
    success:function(json){
      if(json.files){
        $('.optimize_css_js').modal('hide');
        $('#compress_results .modal-body').html(json.files);
      	$('.optimize_css_js input[type=checkbox]').prop('checked',false);
      	$('#compress_results').modal('show');
      }
      $(_t).button('reset');
    }
  });
  return false;
});

$('[form="form-speedup"]').click(function(){
  $(this).button('loading');
});
$('#clear_cache').click(function(){
  if(!confirm("Are You Sure to Clear Cache..?")) return false;
  var _t = $(this);
  $(_t).button('loading');
  $.ajax({
    url:"<?php echo html_entity_decode($clear_cache) ?>",
    success:function(){
      $(_t).button('reset');
    }
  });
  return false;
});
$('#optimize_table').click(function(){
  if(!confirm('Are You Sure to <?php echo strip_tags($entry_optimize_table) ?>..?')) return false;
  var _t = $(this);
  $(_t).button('loading');
  $.ajax({
    url:"<?php echo html_entity_decode($optimize_table) ?>",
    success:function(d){
      console.log(d);
      if(d && typeof d.tables != 'undefined'){
        var txt = "<tr><th>Table Name</th><th>Msg</th></tr>";
        $.each(d.tables,function(i,v){
          txt += "<tr><td>"+i+"</td><td>"+v+"</td></tr>";
        });
        $('.optimize_msg_table').html(txt);
        $('.optimize_table').modal('show');
      }
      $(_t).button('reset');
    }
  });
  return false;
});

$("#existing-images-submit").click(function() {
    var imageFolder = $("input[name=speedup_existing_images_folder]").val();

    if (imageFolder === '') {
        $( "#error_crush_folder" ).empty().append('<span class="error">Please enter a folder</span>');
        return;
    }else{
        $( "#error_crush_folder" ).empty();
    }
    if(!confirm('Once this process is started, all the images in the specified folder will be crushed. This action cannot be paused or reversed. Are you sure?')) return false;
    var existingImageSlider = $("#image_crusher_existing_image_compression_level").val();  
      $.ajax({ url: 'index.php?route=extension/module/speedup/imagescompress&token=<?php echo $token; ?>', 
          data: {
            function: "compressImages", 
            imageFolder: imageFolder, 
            existingImageSlider: existingImageSlider
          },
          type: 'post',
          dataType: 'json',
          beforeSend: function() {
            $('#image-crush-results').html('<img src="../image/processing.gif" width="150px" />');
          },
          success: function(json) {
            $('#image-crush-results').empty();
            //var content = output;
            $('#crush_results').modal('show');
            //$('#crush-results').html(content);
            if(typeof json.files != 'undefined'){
              var html = '<ul style="list-style-type:none;">';
              $.each(json.files,function(i,v){
                html += '<li>'+v+'</li>';
              })
              html += '</ul>';
              console.log(html);
            $('#crush-results').empty().append( html );
            }
          },
          error: function(output) {
            $('#image-crush-results').empty();
            $( "#image-crush-results" ).empty().append('<span class="error">The specified image folder does not exist!</span>');
          }
      });
      return false;
});

$(document).delegate('a[data-toggle=\'folder\']', 'click', function(e) {
	e.preventDefault();

	$('.popover').popover('hide', function() {
		$('.popover').remove();
	});

	var element = this;

	$(element).popover({
		html: true,
		placement: 'right',
		trigger: 'manual',
		content: function() {
			return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button>';
		}
	});

	$(element).popover('show');

	$('#button-image').on('click', function() {
		$('#modal-image').remove();

		$.ajax({
			url: 'index.php?route=common/folder_manager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
			dataType: 'html',
			beforeSend: function() {
				$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-image').prop('disabled', true);
			},
			complete: function() {
				$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
				$('#button-image').prop('disabled', false);
			},
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

				$('#modal-image').modal('show');
			}
		});

		$(element).popover('hide', function() {
			$('.popover').remove();
		});
	});

	$('#button-clear').on('click', function() {
		$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

		$(element).parent().find('input').attr('value', '');

		$(element).popover('hide', function() {
			$('.popover').remove();
		});
	});
});

// tooltips on hover
$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

// Makes tooltips work on ajax generated content
$(document).ajaxStop(function() {
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
});

// https://github.com/opencart/opencart/issues/2595
$.event.special.remove = {
	remove: function(o) {
		if (o.handler) {
			o.handler.apply(this, arguments);
		}
	}
}

$('[data-toggle=\'tooltip\']').on('remove', function() {
	$(this).tooltip('destroy');
});

$(document).delegate('#save_path', 'click', function() {
	var path = $('input[name=path]:checked').val();
	if(path){
		$('#image_crusher_existing_images_folder').val(path);
		$("#folder_manager .close").trigger('click');
	}else{
		alert('Select Any Directory!!');
		return false;
	}
});


// Speedup Page Cache Functions
$(document).ready(function(){
    if($('#input-page_cache').val() == 1){
        enablemod();
        $('#show-page-cache').css('display','block');
    }else{
        disablemod();
        $('#show-page-cache').css('display','none');
    }
});
$('#input-page_cache').change(function(){
    var val = $(this).val();
    if(val == 1){
        enablemod();
        $('#show-page-cache').css('display','block');
    }else{
        disablemod();
        $('#show-page-cache').css('display','none');
    }
});
function showstatus() {
 $(document).ready(function() {
      $.ajax({
          url: 'index.php?route=extension/module/speedup/jsonstatusindexphp'+
               '&token=<?php echo $token; ?>',
                type: 'get',
                dataType: 'json',
                success: function(json) {
                   $('#changestatus').fadeOut;
                   $('#changestatus').unbind( "click" );
                   if (json['status'] == 'enabled') {
                      $('#changestatus').text('<?php print $speedup_cache_btn_disable;?>');
                   } else if (json['status']=='disabled') {
                      $('#changestatus').text('<?php print $speedup_cache_btn_enable;?>');
                      $('#changestatus').prop('disabled',false);
                   } else {
                      /*alert(json['status']);*/
                      $('#changestatus').prop('disabled',true);
                   }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 200 ok, with ajax error probably expired admin session
                    if (xhr.status == 200) {
                        alert('admin session expired? reloading page');
                        location.reload();
                    } else {
                        alert('ajax load error: ' + xhr.status +
                              'error [' + thrownError + ']');
                    }
                }

      });
  });
}
function enablemod() {
  $(document).ready(function() {
      $.ajax({
          url: 'index.php?route=extension/module/speedup/enable'+
               '&token=<?php echo $token; ?>',
                type: 'get',
                dataType: 'json',
                beforeSend: function(){
                    $('#changestatus').prop('disabled',true);
                    $('#changestatus').fadeTo("slow",0.5);
                },
                success: function(json) {
                    if (json['error']) {
                        // alert(json['error']);
                    }
                    $('#changestatus').prop('disabled',false);
                    $('#changestatus').fadeTo("fast",1.0);
                    showstatus();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 200 ok, with ajax error probably expired admin session
                    if (xhr.status == 200) {
                        alert('admin session expired? reloading page');
                        location.reload();
                    } else {
                        alert('ajax load error: ' + xhr.status +
                              'error [' + thrownError + ']');
                    }
                }
      });
  });
}
function disablemod() {
  $(document).ready(function() {
      $.ajax({
          url: 'index.php?route=extension/module/speedup/disable'+
               '&token=<?php echo $token; ?>',
                type: 'get',
                dataType: 'json',
                beforeSend: function(){
                    $('#changestatus').prop('disabled',true);
                    $('#changestatus').fadeTo("slow",0.5);
                },
                success: function(json) {
                    if (json['error']) {
                        /*alert(json['error']);*/
                    }
                    $('#changestatus').prop('disabled',false);
                    $('#changestatus').fadeTo("fast",1.0);
                    showstatus();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 200 ok, with ajax error probably expired admin session
                    if (xhr.status == 200) {
                        alert('admin session expired? reloading page');
                        location.reload();
                    } else {
                        alert('ajax load error: ' + xhr.status +
                              'error [' + thrownError + ']');
                    }
                }

      });
  });
}
function fillstats() {
  $(document).ready(function() {
      $.ajax({
            url: 'index.php?route=extension/module/speedup/stats'+
                '&token=<?php echo $token; ?>',
            type: 'get',
            dataType: 'json',
            success: function(json) {
                var items=[ 'totalfv','totalbv', 'totalfe',
                'totalbe', 'totalf','totalb'];
                for (var i=0;i<items.length;i++) {
                    var item=items[i];
                    $('#'+item).fadeOut();
                    $('#'+item).html(json[item]);
                    $('#'+item).fadeIn();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 200 ok, with ajax error probably expired admin session
                if (xhr.status == 200) {
                    alert('admin session expired? reloading page');
                    location.reload();
                } else {
                    alert('ajax load error: ' + xhr.status +
                          'error [' + thrownError + ']');
                }
            }
        });
  });
}
function purge(which) {
    $(document).ready(function() {
        $.ajax({
            url: 'index.php?route=extension/module/speedup/purge'+
               '&which='+which+
               '&token=<?php echo $token; ?>',
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#purgeall').prop('disabled',true);
                $('#purgeexpired').prop('disabled',true);
                $('#purgeall').fadeTo('slow',0.5);
                $('#purgeexpired').fadeTo('slow',0.5);
            },
            complete: function() {
                $('#purgeall').prop('disabled',false);
                $('#purgeexpired').prop('disabled',false);
                $('#purgeall').fadeTo('fast',1);
                $('#purgeexpired').fadeTo('fast',1);
            },
            success: function(json) {
              alert(json['success']);
              fillstats();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // 200 ok, with ajax error probably expired admin session
                if (xhr.status == 200) {
                    alert('admin session expired? reloading page');
                    location.reload();
                } else {
                    alert('ajax load error: ' + xhr.status +
                          'error [' + thrownError + ']');
                }
            }

      });
  });
}
$(document).ready(function() {
    $( "#purgeall" ).click(function() {
        purge('all');
    });
    $( "#purgeexpired" ).click(function() {
        purge('expired');
    });
    $( "#refreshstats" ).click(function() {
        $('#refreshstats').prop('disabled',true);
        $('#refreshstats').fadeTo("slow",0.5);
        fillstats();
        $('#refreshstats').prop('disabled',false);
        $('#refreshstats').fadeTo("fast",1);
    });
    showstatus();
    fillstats();
});
</script>
<?php echo $footer; ?>
