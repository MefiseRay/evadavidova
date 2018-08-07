
            <?php if (isset ($ya_metrika_active) && $ya_metrika_active){ ?>
                <?php echo $yandex_metrika; ?>
                <script type="text/javascript">
                    var old_addCart = cart.add;
                    cart.add = function (product_id, quantity)
                    {
                        var params_cart = new Array();
                        params_cart['name'] = 'product id = '+product_id;
                        params_cart['quantity'] = quantity;
                        params_cart['price'] = 0;
                        old_addCart(product_id, quantity);
                        metrikaReach('metrikaCart', params_cart);
                    }
    
                    $('#button-cart').on('click', function() {
                        var params_cart = new Array();
                        params_cart['name'] = 'product id = '+ $('#product input[name="product_id"]').val();
                        params_cart['quantity'] = $('#product input[name="quantity"]').val();
                        params_cart['price'] = 0;
                        metrikaReach('metrikaCart', params_cart);
                    });
    
                    function metrikaReach(goal_name, params) {
                    for (var i in window) {
                        if (/^yaCounter\d+/.test(i)) {
                            window[i].reachGoal(goal_name, params);
                        }
                    }
                }
                </script>
            <?php } ?>
<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
    </div>
    <hr>
    <p><?php echo $powered; ?></p>

            <?php if ($yandex_money_kassa_show_in_footer) : ?>
            <p><a href="https://kassa.yandex.ru/?_openstat=promo;merchants;opencart2">Работает Яндекс.Касса</a></p>
            <?php endif; ?>
            
  </div>
</footer>

        <?php if (isset($smca_status) || isset($smac_status)) { ?>
          <!-- start: OCdevWizard Setting -->
          <script type="text/javascript">     
            var ocdev_modules = [];
                  
            <?php if (isset($smca_status) && $smca_status == 1) { ?>
              ocdev_modules.push({
                src:  'index.php?route=ocdevwizard/smart_cart',
                type:'ajax'
              });
            <?php } ?>
            <?php if (isset($smac_status) && $smac_status == 1 && $smart_abandoned_cart == 1) { ?>
              ocdev_modules.push({
                src:  'index.php?route=ocdevwizard/smart_abandoned_cart',
                type:'ajax'
              });
            <?php } ?>
          </script>
          <!-- end: OCdevWizard Setting -->
        <?php } ?>
      

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->


        <?php if ($smcm_status == 1) { ?>
        <!-- <?php echo $smcm_form_data['front_module_name'].':'.$smcm_form_data['front_module_version']; ?> -->
        <script type="text/javascript">
          $(function() {
            $.ajax({
              type: 'post',
              url: 'index.php?route=ocdevwizard/smart_contact_me/getForms',
              dataType: 'json',
              success: function(json) {
                $.each(json['forms'], function(i,value) {
                  $.each(value['add_id_selector'], function(i,i_selector) {
                    if (value['location'] == 1) {
                      $(i_selector).before("<button class='smcm_call_button' onclick='getOCwizardModal_smcm(" + value['form_id'] + ")'>" + value['call_button'] + "</button>");
                    } else if (value['location'] == 2) {
                      $(i_selector).prepend("<button class='smcm_call_button' onclick='getOCwizardModal_smcm(" + value['form_id'] + ")'>" + value['call_button'] + "</button>");
                    } else if (value['location'] == 3) {
                      $(i_selector).append("<button class='smcm_call_button' onclick='getOCwizardModal_smcm(" + value['form_id'] + ")'>" + value['call_button'] + "</button>");
                    } else {
                      $(i_selector).after("<button class='smcm_call_button' onclick='getOCwizardModal_smcm(" + value['form_id'] + ")'>" + value['call_button'] + "</button>");
                    }
                  });
                });
              }
            });
          });

          function getOCwizardModal_smcm(form_id) {
            $.magnificPopup.open({
              tLoading: '<img src="catalog/view/theme/default/stylesheet/ocdevwizard/smart_contact_me/loading.svg" alt="" />',
              items: {
                src: 'index.php?route=ocdevwizard/smart_contact_me&form_id=' + form_id,
                type: 'ajax'
              },
              showCloseBtn: false
            });
          }
        </script>
        <!-- <?php echo $smcm_form_data['front_module_name'].':'.$smcm_form_data['front_module_version']; ?> -->
        <?php } ?>
      
</body></html>