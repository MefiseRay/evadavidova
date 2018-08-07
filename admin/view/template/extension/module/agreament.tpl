<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<button type="submit" form="form-atpresets" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    </div>
    <?php } ?>	
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-agreament" class="form-horizontal">
		  <fieldset>	
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($agreament_status) { ?>
                    <input type="radio" name="agreament_status" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_status" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$agreament_status) { ?>
                    <input type="radio" name="agreament_status" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_status" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>		
		 <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_feedback; ?></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($agreament_feedback) { ?>
                    <input type="radio" name="agreament_feedback" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_feedback" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$agreament_feedback) { ?>
                    <input type="radio" name="agreament_feedback" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_feedback" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>
          <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_checkout; ?></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($agreament_checkout) { ?>
                    <input type="radio" name="agreament_checkout" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_checkout" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$agreament_checkout) { ?>
                    <input type="radio" name="agreament_checkout" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_checkout" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>
          <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_review; ?></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($agreament_review) { ?>
                    <input type="radio" name="agreament_review" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_review" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$agreament_review) { ?>
                    <input type="radio" name="agreament_review" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="agreament_review" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>							
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_caption; ?></span></label>
            <div class="col-sm-10">
				<div class="list-language">
					<?php foreach($languages as $language) { ?>
						<div class="input-group">
							<?php $language_id = $language['language_id']; ?>
							<span class="input-group-addon"><img src="../image/flags/<?php echo $language['image'] ?>" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /></span>
							<input class="form-control" type="text" name="agreament_caption[<?php echo $language_id; ?>]" <?php if(isset($agreament_caption[$language_id])) { echo 'value="'.$agreament_caption[$language_id].'"'; } ?>>
						</div>
					<?php } ?>
				</div>
		    </div>
          </div>  			  
		</fieldset>	
        </form>	
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
