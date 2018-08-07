<!-- 
@category  : OpenCart
@module    : Smart Contact Me
@author    : OCdevWizard <ocdevwizard@gmail.com> 
@copyright : Copyright (c) 2015, OCdevWizard
@license   : http://license.ocdevwizard.com/Licensing_Policy.pdf
-->
<script type="text/javascript" src="catalog/view/javascript/ocdevwizard/smart_contact_me/main.js"></script>
<div class="panel panel-default" id="smcm-processing-data<?php echo $form_id ?>">
  <div class="panel-heading"><?php echo $heading_title; ?></div>
  <?php if ($fields_data) { ?>
    <div class="list-group">
      <!-- FIELDS DATA -->
      <form id="smcm-form-<?php echo $form_id ?>">
      <input name="form_id" type="hidden" value="<?php echo $form_id ?>" />
        <div class="smcm-center-body">
          <?php foreach ($fields_data as $field) { ?>
            <div class="list-group-item">
              <h4 class="list-group-item-heading"><label><b><?php echo $field['title']; ?></b></label></h4>
              <?php if ($field['type'] == 'textarea') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> class="form-group <?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <textarea name="<?php echo $field['name']; ?>" placeholder="<?php echo $field['title']; ?>" class="form-control"></textarea>
                </div>
              <?php } elseif ($field['type'] == 'radio') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <?php if ($field['view_fields']) { ?>
                    <?php foreach ($field['view_fields'] as $value) { ?>
                      <div class="radio">
                        <label>
                          <input name="<?php echo $field['name']; ?>" type="<?php echo $field['type']; ?>" value="<?php echo $value; ?>" />
                          <?php echo $value; ?>
                        </label>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } elseif ($field['type'] == 'checkbox') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <?php if ($field['view_fields']) { ?>
                    <?php foreach ($field['view_fields'] as $value) { ?>
                      <div class="checkbox">
                        <label>
                          <input name="<?php echo $field['name']; ?>[]" type="<?php echo $field['type']; ?>" value="<?php echo $value; ?>" />
                          <?php echo $value; ?>
                        </label>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } elseif ($field['type'] == 'select') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <select name="<?php echo $field['name']; ?>" class="form-control">
                    <option value=""><?php echo $text_make_a_choice; ?></option>
                    <?php if ($field['view_fields']) { ?>
                      <?php foreach ($field['view_fields'] as $value) { ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              <?php } else { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="<?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <input name="<?php echo $field['name']; ?>" type="<?php echo $field['type']; ?>" placeholder="<?php echo $field['title']; ?>" class="form-control" />
                </div>
              <?php } ?>
              <?php if ($field['mask']) { ?>
                <script type="text/javascript">
                  $("#smcm-form-<?php echo $form_id ?> [name='<?php echo $field['name']; ?>']").inputmask('<?php echo $field['mask']; ?>');
                </script>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </form>
    </div>
    <!-- SEND BUTTON -->
    <div class="panel-footer text-right">
      <button type="button" onclick="sendFeedbackStatic('<?php echo $form_id ?>');" class="btn btn-primary"><?php echo $button_send_order; ?></button>
    </div>
  <?php } else { ?>
    <div class="panel-body"><?php echo $text_empty_form; ?></div>
  <?php } ?>
</div>