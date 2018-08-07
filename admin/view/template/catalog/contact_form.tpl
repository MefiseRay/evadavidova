<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-contact" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-contact" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-map" data-toggle="tab"><?php echo $tab_map; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="contact_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description-above<?php echo $language['language_id']; ?>"><?php echo $entry_description_above; ?></label>
                    <div class="col-sm-10">
                      <textarea name="contact_description[<?php echo $language['language_id']; ?>][description_above]" placeholder="<?php echo $entry_description_above; ?>" id="input-description-above<?php echo $language['language_id']; ?>" class="summernote form-control"><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['description_above'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="contact_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="summernote form-control"><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="contact_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="contact_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-h1<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="contact_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="contact_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>                
              </div>
            </div>
            <div class="tab-pane" id="tab-map">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="contact_page_map_status" id="input-status" class="form-control">
                        <?php if ($contact_page_map_status) { ?>
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
                    <label class="col-sm-2 control-label" for="input-type"><?php echo $entry_type; ?></label>
                    <div class="col-sm-10">
                      <select name="contact_page_map_type" id="input-type" class="form-control">
                        <?php if ($contact_page_map_type) { ?>
                        <option value="1" selected="selected"><?php echo $text_type_one; ?></option>
                        <option value="0"><?php echo $text_type_all; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_type_one; ?></option>
                        <option value="0" selected="selected"><?php echo $text_type_all; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-scroll"><?php echo $entry_scroll; ?></label>
                    <div class="col-sm-10">
                      <select name="contact_page_map_scroll" id="input-scroll" class="form-control">
                        <?php if ($contact_page_map_scroll) { ?>
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
                    <label class="col-sm-2 control-label" for="input-zoom"><?php echo $entry_zoom; ?></label>
                    <div class="col-sm-10">
                      <select name="contact_page_map_zoom" id="input-zoom" class="form-control">
                       <option value="5"<?php if($contact_page_map_zoom =='5'){echo ' selected="selected"';} ?>>5</option>
                       <option value="6"<?php if($contact_page_map_zoom =='6'){echo ' selected="selected"';} ?>>6</option>
                        <option value="7"<?php if($contact_page_map_zoom =='7'){echo ' selected="selected"';} ?>>7</option>
				        <option value="8"<?php if($contact_page_map_zoom =='8'){echo ' selected="selected"';} ?>>8</option>
				        <option value="9"<?php if($contact_page_map_zoom =='9'){echo ' selected="selected"';} ?>>9</option>
                        <option value="10"<?php if($contact_page_map_zoom =='10'){echo ' selected="selected"';} ?>>10</option>
				        <option value="11"<?php if($contact_page_map_zoom =='11'){echo ' selected="selected"';} ?>>11</option>
                        <option value="12"<?php if($contact_page_map_zoom =='12'){echo ' selected="selected"';} ?>>12</option> 
                        <option value="13"<?php if($contact_page_map_zoom =='13'){echo ' selected="selected"';} ?>>13</option>
                        <option value="14"<?php if($contact_page_map_zoom =='14'){echo ' selected="selected"';} ?>>14</option>
                        <option value="15"<?php if($contact_page_map_zoom =='15'){echo ' selected="selected"';} ?>>15</option> 
                        <option value="16"<?php if($contact_page_map_zoom =='16'){echo ' selected="selected"';} ?>>16</option>
                        <option value="17"<?php if($contact_page_map_zoom =='17'){echo ' selected="selected"';} ?>>17</option>       
                      </select>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-sm-2 control-label" for="input-geocode"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_map_geocode; ?>"><?php echo $entry_map_geocode; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="contact_page_map_geocode" value="<?php echo isset($contact_page_map_geocode) ? $contact_page_map_geocode : ''; ?>" placeholder="<?php echo $entry_map_geocode; ?>" id="input-geocode" class="form-control" />
                    </div>
                </div>
            </div> 
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
  <?php if ($ckeditor) { ?>
    <?php foreach ($languages as $language) { ?>
        ckeditorInit('input-description<?php echo $language['language_id']; ?>', getURLVar('token'));
    <?php } ?>
  <?php } ?>
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>
