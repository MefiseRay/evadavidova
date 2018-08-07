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
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_heading; ?></label>
            <div class="col-sm-10">
              <ul class="nav nav-tabs" id="heading">
                <?php foreach ($languages as $language) { ?>
                  <li>
                    <a href="#tab-heading-language-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                  </li>
                <?php } ?>
              </ul>
              <div class="tab-content">
              <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="tab-heading-language-<?php echo $language['language_id']; ?>">
                  <input
                    type="text"
                    name="heading[<?php echo $language['language_id']; ?>]"
                    value="<?php echo (!empty($heading[$language['language_id']])) ? $heading[$language['language_id']] : $default_heading; ?>"
                    class="form-control"
                  />
                  <?php if (isset($error_heading[$language['language_id']])) { ?>
                    <div style="margin-bottom: 0px;margin-top: 10px;" class="alert alert-danger text-danger"><?php echo $error_heading[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-form"><?php echo $entry_form; ?></label>
            <div class="col-sm-10">
              <select name="form_id" id="input-form" class="form-control">
                <?php foreach ($forms as $form) { ?>
                <option value="<?php echo $form['form_id']; ?>" <?php echo ($form['form_id'] == $form_id) ? "selected='selected'" : "" ; ?>><?php echo $form['heading_module']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <option value="1" <?php echo ($status == 1) ? "selected='selected'" : "" ; ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php echo ($status == 0) ? "selected='selected'" : "" ; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#heading a:first').tab('show');
//--></script>
</div>
<?php echo $footer; ?>
