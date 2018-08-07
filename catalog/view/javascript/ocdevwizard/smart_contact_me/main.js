// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

function sendFeedbackStatic(form_id) {
  $.ajax({
    type: 'post',
    url: 'index.php?route=extension/module/ocdev_smcm_static/save',
    dataType: 'json',
    data: $('#smcm-form-'+form_id).serialize(),
    beforeSend: function() {
      $('#smcm-processing-data'+form_id+' button').button('loading');
    },
    complete: function() {
      $('#smcm-processing-data'+form_id+' button').button('reset');
    },
    success: function(json) {
      $('.alert-success').remove();
      $('.popup-text-danger').remove();
      if (json['error']) {
        if (json['error']['field']) {
          for (i in json['error']['field']) {
            var element = $('#smcm-processing-data'+form_id+' [data-error-name='+i+']');
            element.append('<div class="popup-text-danger">'+json['error']['field'][i]+'</div>');
          }
        }
      } else {
        if (json['output']) {
          $('#smcm-processing-data'+form_id+' button').removeAttr('onclick');
          $('#smcm-form-'+form_id+' .smcm-center-body').prepend('<div class="list-group-item"><div class="alert alert-success smcm-fix-alert"><i class="fa fa-check-circle"></i> '+json['output']+'</div></div>');
        }
      }
    }
  });
}