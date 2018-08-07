<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="attribute_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($attribute_description[$language['language_id']]) ? $attribute_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-attribute-group"><?php echo $entry_attribute_group; ?></label>
            <div class="col-sm-10">
              <select name="attribute_group_id" id="input-attribute-group" class="form-control">
                <option value="0"></option>
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <?php if ($attribute_group['attribute_group_id'] == $attribute_group_id) { ?>
                <option value="<?php echo $attribute_group['attribute_group_id']; ?>" selected="selected"><?php echo $attribute_group['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $attribute_group['attribute_group_id']; ?>"><?php echo $attribute_group['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_attribute_group) { ?>
              <div class="text-danger"><?php echo $error_attribute_group; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

		<?php if ($atpresets_installed==1) { ?>			
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $text_preset_values; ?></label>
            <div class="col-sm-10">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <?php $pcount=0; ?>
				  <?php foreach ($presets as $preset) { ?>
					  <input type="hidden" name="presets[<?php echo $pcount; ?>][preset_id]" value="<?php echo $preset['preset_id']; ?>" />
					  <input type="hidden" name="presets[<?php echo $pcount; ?>]1C_preset_id]" value="<?php echo $preset['1C_preset_id']; ?>" />
					  <input type="hidden" name="presets[<?php echo $pcount; ?>][text]" value="<?php echo $preset['text']; ?>" />
					  <?php if (count($languages)>1) { ?>
					  <div class="panel panel-default" id="preset<?php echo $pcount; ?>">					  
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $pcount; ?>" aria-expanded="true" aria-controls="collapse<?php echo $pcount; ?>">
							<div class="panel-heading " role="tab" id="heading<?php echo $pcount; ?>" style="background-color: #EEE;">
							  <h4 class="panel-title" <?php if (isset($error_presets[$preset['preset_id']])) { ?>style="color:red;"<?php } ?> >
								<?php echo ((utf8_strlen($preset['text'])>50)?substr($preset['text'], 0, 50).'...':$preset['text']); ?>
								<div class="pull-right"><i class="fa fa-trash-o" onclick="$('#preset<?php echo $pcount; ?>').remove();$('input[name^=\'presets[<?php echo $pcount; ?>][text]\']').remove();"></i></div>
							  </h4>							  
							</div>
						</a>
						<div id="collapse<?php echo $pcount; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $pcount; ?>">
						  <div class="panel-body">	
							  <?php foreach ($languages as $language) { ?>
								  <div class="input-group" style="margin-bottom:10px"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
	
								  	<span onclick="copy_values(<?php echo $pcount; ?>,<?php echo $language['language_id']; ?>);" class="input-group-addon" style="cursor:pointer;cursor:hand;" title="<?php echo $text_copy_value; ?>">
										<i class="fa fa-ellipsis-v" style="font-size: large;"></i>
									</span>

									<textarea name="presets[<?php echo $pcount; ?>][descriptions][<?php echo $language['language_id']; ?>]" rows="1" placeholder="<?php echo $entry_value; ?>" class="form-control"><?php echo isset($preset['descriptions'][$language['language_id']]) ? $preset['descriptions'][$language['language_id']] : ''; ?></textarea>
								  </div>
							  <?php } ?>
						  </div>
						</div>
					  </div>
					  <?php } else { ?>
						<div class="panel panel-default" id="preset<?php echo $pcount; ?>">
							  <?php foreach ($languages as $language) { ?>
								  <div class="input-group" style="margin-bottom:10px">
								  <span class="input-group-addon" style="cursor:pointer;cursor:hand;">
									<i class="fa fa-trash-o fa-lg" onclick="$('#preset<?php echo $pcount; ?>').remove();$('input[name^=\'presets[<?php echo $pcount; ?>][text]\']').remove();"></i>
								  </span>										  
								  <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
								  
								  <textarea name="presets[<?php echo $pcount; ?>][descriptions][<?php echo $language['language_id']; ?>]" rows="1" placeholder="<?php echo $entry_value; ?>" class="form-control"><?php echo isset($preset['descriptions'][$language['language_id']]) ? $preset['descriptions'][$language['language_id']] : ''; ?></textarea>
								  </div>
							  <?php } ?>
						  </div>
					  <?php } ?>					  
					  			
					  <?php $pcount++; ?>
				  <?php } ?>
			   </div>
			   <div class="pull-right"><a class="btn btn-primary" onclick="addPreset();"><?php echo $text_add_preset; ?></a></div>			   
			  <?php if (isset($error_presets)) { ?>
				<div class="text-danger"></div>
			  <?php } ?>			   
            </div>
          </div>
		<?php } ?>
				
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript"><!--
var pcount = <?php echo $pcount; ?>;

function addPreset() {
<?php if (count($languages)>1) { ?>
	html  = '	  <input type="hidden" name="presets[' + pcount + '][preset_id]" value="0" />';
	html  = '	  <input type="hidden" name="presets[' + pcount + '][1C_preset_id]" value="" />';
	html += '	  <input type="hidden" name="presets[' + pcount + '][text]" value="New Preset " />';
	html += '	  <div class="panel panel-default" id="preset' + pcount + '">';
	html += '		<a data-toggle="collapse" data-parent="#accordion" href="#collapse' + pcount + '" aria-expanded="true" aria-controls="collapse' + pcount + '">';
	html += '			<div class="panel-heading " role="tab" id="heading' + pcount + '" style="background-color: #EEE;">';
	html += '			  <h4 class="panel-title">';
	html += '				New Preset '+ pcount;
	html += '				<div class="pull-right"><i class="fa fa-trash-o" onclick="$(\'#preset' + pcount + '\').remove();$(\'input[name^=\\\'presets[' + pcount + '][text]\\\']\').remove();"></i></div>';
	html += '			  </h4>';
	html += '			</div>';
	html += '		</a>';
	html += '		<div id="collapse' + pcount + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' + pcount + '">';
	html += '		  <div class="panel-body">	';
	<?php foreach ($languages as $language) { ?>
	html += '				  <div class="input-group" style="margin-bottom:10px"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';

	html += '					<span onclick="copy_values(' + pcount + ',<?php echo $language['language_id']; ?>)" class="input-group-addon" style="cursor:pointer;cursor:hand;" title="<?php echo $text_copy_value; ?>">';
	html += '						<i class="fa fa-ellipsis-v" style="font-size: large;"></i>';
	html += '					</span>';

	html += '					<textarea name="presets[' + pcount + '][descriptions][<?php echo $language['language_id']; ?>]" rows="1" placeholder="<?php echo $entry_value; ?>" class="form-control"></textarea>';
	html += '				  </div>';
	<?php } ?>
	html += '		  </div>';
	html += '		</div>';
	html += '	  </div>';

	$('[id^=\'collapse\']').removeClass("in");
<?php } else {?>
	html  = '	  <input type="hidden" name="presets[' + pcount + '][preset_id]" value="0" />';
	html += '	  <input type="hidden" name="presets[' + pcount + '][text]" value="New Preset " />';
	html += '			<div class="panel panel-default" id="preset' + pcount + '">';
							<?php foreach ($languages as $language) { ?>
	html += '					  <div class="input-group" style="margin-bottom:10px">';
	html += '					  <span class="input-group-addon" style="cursor:pointer;cursor:hand;">';
	html += '						<i class="fa fa-trash-o fa-lg" onclick="$(\'#preset' + pcount + '\').remove();$(\'input[name^=\\\'presets[' + pcount + '][text]\\\']\').remove();"></i>';
	html += '					  </span>';
	html += '					  <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';
	html += '					  ';
	html += '					  <textarea name="presets[' + pcount + '][descriptions][<?php echo $language['language_id']; ?>]" rows="1" placeholder="<?php echo $entry_value; ?>" class="form-control"></textarea>';
	html += '					  </div>';
	html += '				  <?php } ?>';
	html += '			  </div>';
	
<?php } ?>		
	$('#accordion').append(html);
	$('textarea[name=\'presets[' + pcount + '][descriptions][<?php $first=reset($languages); echo $first['language_id']; ?>]\']').focus();
	
	pcount++;
}

function copy_values(preset_count, language_id){
	var new_value = $('textarea[name=\'presets[' + preset_count + '][descriptions][' + language_id + ']\']').val();
	$('textarea[name^=\'presets[' + preset_count + '][descriptions]\']').val(new_value);
}
//--></script>   
				
</div>
<?php echo $footer; ?>
