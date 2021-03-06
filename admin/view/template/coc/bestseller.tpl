<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-heading-title<?php echo $language['language_id']; ?>"><?php echo $entry_heading_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="coc_bestseller_description[<?php echo $language['language_id']; ?>][heading_title]" value="<?php echo isset($coc_bestseller_description[$language['language_id']]) ? $coc_bestseller_description[$language['language_id']]['heading_title'] : ''; ?>" placeholder="<?php echo $entry_heading_title; ?>" id="input-heading-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_heading_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_heading_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="coc_bestseller_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($coc_bestseller_description[$language['language_id']]) ? $coc_bestseller_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="coc_bestseller_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($coc_bestseller_description[$language['language_id']]) ? $coc_bestseller_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="coc_bestseller_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($coc_bestseller_description[$language['language_id']]) ? $coc_bestseller_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            
            <div class="tab-pane" id="tab-data">
            
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-coc-bestseller-seo-keyword"><span data-toggle="tooltip" title="<?php echo $help_seo_keyword; ?>"><?php echo $entry_seo_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="coc_bestseller_seo_keyword" value="<?php echo $coc_bestseller_seo_keyword; ?>" placeholder="<?php echo $entry_seo_keyword; ?>" id="input-coc-bestseller-seo-keyword" class="form-control" />
                  <?php if ($error_seo_keyword) { ?>
                  <div class="text-danger"><?php echo $error_seo_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-coc-bestseller-quantity"><span data-toggle="tooltip" title="<?php echo $help_quantity; ?>"><?php echo $entry_quantity; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="coc_bestseller_quantity" value="<?php echo $coc_bestseller_quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-coc-bestseller-quantity" class="form-control" />
                  
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="coc_bestseller_status" id="input-status" class="form-control">
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
              
                        
            </div>
            
            
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>