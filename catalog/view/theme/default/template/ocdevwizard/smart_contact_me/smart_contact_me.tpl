<div id="smcm-modal-body">
  <!-- 
  @category  : OpenCart
  @module    : Smart Contact Me
  @author    : OCdevWizard <ocdevwizard@gmail.com> 
  @copyright : Copyright (c) 2015, OCdevWizard
  @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf
  -->

  <div class="modal-heading">
    <?php echo $heading_title; ?>
    <span class="modal-close" onclick="$.magnificPopup.close();"></span>
  </div>
  <div id="check-data" >
    <div id="smcm-modal-data" class="modal-body">
      <form id="smcm-form-<?php echo $form_id ?>">
        <input name="form_id" type="hidden" value="<?php echo $form_id ?>" />
        <?php if ($fields_data) { ?>
        <!-- FIELDS DATA -->
          <div class="ocdev_smart_feedback_fields">
            <?php foreach ($fields_data as $field) { ?>
              <?php if($field['type'] == 'textarea') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo $field['position'].' '; echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <div class="field-heading control-label"><?php echo $field['title']; ?></div>
                  <textarea name="<?php echo $field['name']; ?>" placeholder="<?php echo $field['title']; ?>"></textarea>
                </div>
              <?php } elseif ($field['type'] == 'radio') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo $field['position'].' '; echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <div class="field-heading control-label"><?php echo $field['title']; ?></div>
                  <?php if ($field['view_fields']) { ?>
                    <?php foreach ($field['view_fields'] as $value) { ?>
                      <div class="field_radio">
                        <label>
                          <input name="<?php echo $field['name']; ?>" type="<?php echo $field['type']; ?>" value="<?php echo $value; ?>" /> <span style="display:inline-block;"><?php echo $value; ?></span>
                        </label>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } elseif ($field['type'] == 'checkbox') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo $field['position'].' '; echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <div class="field-heading control-label"><?php echo $field['title']; ?></div>
                  <?php if ($field['view_fields']) { ?>
                    <?php foreach ($field['view_fields'] as $value) { ?>
                      <div class="field_checkbox">
                        <label>
                          <input name="<?php echo $field['name']; ?>[]" type="<?php echo $field['type']; ?>" value="<?php echo $value; ?>" /> <span style="display:inline-block;"><?php echo $value; ?></span>
                        </label>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } elseif ($field['type'] == 'select') { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo $field['position'].' '; echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <div class="field-heading control-label"><?php echo $field['title']; ?></div>
                  <select name="<?php echo $field['name']; ?>">
                    <option value=""><?php echo $text_make_a_choice; ?></option>
                    <?php if ($field['view_fields']) { ?>
                      <?php foreach ($field['view_fields'] as $value) { ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              <?php } else { ?>
                <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> data-error-name="<?php echo $field['name']; ?>" class="form-group <?php echo $field['position'].' '; echo ($field['css_class']) ? $field['css_class'] : "" ; ?>">
                  <div class="field-heading control-label"><?php echo $field['title']; ?></div>
                  <input name="<?php echo $field['name']; ?>" type="<?php echo $field['type']; ?>" placeholder="<?php echo $field['title']; ?>" />
                </div>
              <?php } ?>
              <?php if ($field['mask']) { ?>
                <script type="text/javascript">
                  $("#smcm-modal-body [name='<?php echo $field['name']; ?>']").inputmask('<?php echo $field['mask']; ?>');
                </script>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
      </form>
    </div>
  </div>
  <!-- BUTTONS -->
  <div class="modal-footer buttons text-center">
    <?php /* <input type="button" onclick="$.magnificPopup.close();" value="<?php echo $button_close; ?>" class="close_button_bottom" /> */ ?>
    <input type="button" onclick="sendFeedbackPopup('<?php echo $form_id ?>');" value="<?php echo $button_send_order; ?>" class="btn btn-primary" />
  </div>
  <script type="text/javascript">
    $('.mfp-bg').css({
      'background': 'url(image/ocdevwizard/smart_contact_me/background/<?php echo $style_background; ?>)',
      'opacity': '<?php echo ($background_opacity == 0) ? $background_opacity : $background_opacity/10; ?>'
    });

    // loadmask function
    function maskElement(element, status) {
      if (status == true) {
        $('<div/>')
        .attr('class', 'smcm-modal-loadmask')
        .prependTo(element);
        $('<div class="smcm-modal-loadmask-loading" />').insertAfter($('.smcm-modal-loadmask'));
      } else {
        $('.smcm-modal-loadmask').remove();
        $('.smcm-modal-loadmask-loading').remove();
      }
    }

    // send data to processing
    function sendFeedbackPopup(form_id) {
      var $button_send = $('#smcm-modal-body .modal-footer > .send-button-data');
      $button_send.attr("disabled", true);
      maskElement('#check-data', true);
      $.ajax({
        type: 'post',
        url: 'index.php?route=ocdevwizard/smart_contact_me/save',
        dataType: 'json',
        data: $('#check-data #smcm-form-'+form_id).serialize(),
        success: function(json) {
          $('.alert-success').remove();
          $('.popup-text-danger').remove();
          $('.modal-footer.buttons .btn.btn-primary').remove();
          if (json['error']) {
            if (json['error']['field']) {
              maskElement('#check-data', false);
              for (i in json['error']['field']) {
                var element = $('#check-data #smcm-form-'+form_id+' [data-error-name='+i+']');
                element.append('<div class="popup-text-danger">'+json['error']['field'][i]+'</div>');
              }
            }
            $button_send.attr("disabled", false);
          } else {
            if (json['output']) {
              maskElement('#check-data', false);
              $('.send-button-data').remove();
              $('#smcm-modal-data').html(json['output']);
            }
          }
        }
      });
    }
  </script>
</div>