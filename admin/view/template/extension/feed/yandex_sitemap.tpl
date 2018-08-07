<?php 
$xml_rating = array("0" => $text_disabled, "0.1" => 0.1, "0.2" => 0.2, "0.3" => 0.3, "0.4" => 0.4, "0.5" => 0.5, "0.6" => 0.6, "0.7" => 0.7, "0.8" => 0.8, "0.9" => 0.9, "1.0" => 1.0);
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-yandex-sitemap" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-yandex-sitemap" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="yandex_sitemap_status" id="input-status" class="form-control">
                <?php if ($yandex_sitemap_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_category_priority; ?></label>
            <div class="col-sm-10">
              <select name="yandex_sitemap_category_priority" id="input-category-priority" class="form-control">
               <?php foreach($xml_rating as $key => $val){ ?>
                    <option value="<?php echo $key; ?>"<?php if($yandex_sitemap_category_priority == $key){echo ' selected="selected"';} ?>><?php echo $val; ?></option>
                <?php } ?>   
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_product_priority; ?></label>
            <div class="col-sm-10">
              <select name="yandex_sitemap_product_priority" id="input-product-priority" class="form-control">
                <?php foreach($xml_rating as $key => $val){ ?>
                    <option value="<?php echo $key; ?>"<?php if($yandex_sitemap_product_priority == $key){echo ' selected="selected"';} ?>><?php echo $val; ?></option>
                <?php } ?>   
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_manufacturer_priority; ?></label>
            <div class="col-sm-10">
              <select name="yandex_sitemap_manufacturer_priority" id="input-manufacturer-priority" class="form-control">
                <?php foreach($xml_rating as $key => $val){ ?>
                    <option value="<?php echo $key; ?>"<?php if($yandex_sitemap_manufacturer_priority == $key){echo ' selected="selected"';} ?>><?php echo $val; ?></option>
                <?php } ?>    
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_information_priority; ?></label>
            <div class="col-sm-10">
              <select name="yandex_sitemap_information_priority" id="input-information-priority" class="form-control">
                <?php foreach($xml_rating as $key => $val){ ?>
                    <option value="<?php echo $key; ?>"<?php if($yandex_sitemap_information_priority == $key){echo ' selected="selected"';} ?>><?php echo $val; ?></option>
                <?php } ?>   
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_settings; ?></label>
                <div class="col-sm-10">
                     <div class="checkbox">
                            <label for="yandex_sitemap_homepage"><input type="checkbox" <?php echo ($yandex_sitemap_homepage? ' checked="checked"' : ''); ?> name="yandex_sitemap_homepage" id="yandex_sitemap_homepage" class="" value="1"/> <?php echo $entry_homepage; ?></label>
                    </div>
                    <div class="checkbox">
                        <label for="yandex_sitemap_contacts"><input type="checkbox" <?php echo ($yandex_sitemap_contacts ? ' checked="checked"' : ''); ?> name="yandex_sitemap_contacts" id="yandex_sitemap_contacts" class="" value="1"/> <?php echo $entry_contacts; ?></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_data_feed; ?></label>
                <div class="col-sm-10">
                  <textarea rows="5" readonly id="input-data-feed" class="form-control"><?php echo $data_feed; ?></textarea>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>