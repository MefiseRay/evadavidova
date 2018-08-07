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
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_messages_info; ?></h3>
      </div>
      <div class="panel-body">
          <div class="tab-content">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td><?php echo $column_record_id; ?></td>
                  <td><?php echo $column_ip; ?></td>
                  <td><?php echo $column_referer; ?></td>
                  <td><?php echo $column_user_agent; ?></td>
                  <td><?php echo $column_acept_language; ?></td>
                  <td><?php echo $column_date_added; ?></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($messages as $message) { ?>
                <tr>
                  <td><?php echo $message['record_id']; ?></td>
                  <td><?php echo $message['ip']; ?></td>
                  <td><?php echo $message['referer']; ?></td>
                  <td><?php echo $message['user_agent']; ?></td>
                  <td><?php echo $message['accept_language']; ?></td>
                  <td><?php echo $message['date_added']; ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td class="col-sm-3"><?php echo $column_heading; ?></td>
                  <td class="col-sm-9"><?php echo $column_value; ?></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($messages as $message) { ?>
                <?php foreach ($message['field_data'] as $field) { ?>
                  <tr>
                    <td><?php echo $field['title']; ?></td>
                    <?php if (is_array($field['value'])) { ?>
                      <td>
                        <?php foreach ($field['value'] as $value) { ?>
                          <?php echo $value; ?><br/> 
                        <?php } ?>
                      </td>
                    <?php } else { ?>
                      <td><?php echo $field['value']; ?></td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>