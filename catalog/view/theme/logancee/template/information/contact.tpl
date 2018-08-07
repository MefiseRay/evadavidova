<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/' . $config->get($config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>

<div class="contact-page">
        <?php if($description_above) { ?>
            <div class="description-above"><?php echo $description_above; ?></div>
        <?php } ?>
        
        <?php if ($locations) { ?>
            <div class="panel-group">
              <?php if ($map_type == 0) { ?> 
                  <?php if ($map_status) { ?>
                        <div class="map" id="map" style="width: 100%; height: 450px;"></div>
                        <script type="text/javascript"> 
                                function ShowPositon (x, y, map1) {
                                    var mapOptions = {
                                        center: new google.maps.LatLng(x, y),
                                        zoomControl: true,
                                        zoom: 15,
                                        scrollwheel: <?php echo $map_scroll; ?>
                                    };
                                    map = new google.maps.Map(document.getElementById("map"), mapOptions);
                                    <?php foreach ($locations as $location) { ?>
                                        var LatLng<?php echo $location['location_id']; ?> = new google.maps.LatLng(<?php echo $location['geocode'] ?>);
                                        var contentString<?php echo $location['location_id']; ?> = '<?php echo $location["name"]; ?><br><?php echo ($location["postcode"] ? $location["postcode"].', ' : ''); echo ($location["city"] ? $location["city"].', ' : ''); echo $location["address"]; ?>';
                                        var infowindow<?php echo $location['location_id']; ?> = new google.maps.InfoWindow({
                                                content: contentString<?php echo $location['location_id']; ?>
                                            });
                                        var	beachMarker<?php echo $location['location_id']; ?> = new google.maps.Marker({
                                            position: LatLng<?php echo $location['location_id']; ?>,
                                            map: map,
                                            title: "<?php echo $location['name']; ?>"
                                        });	
                                        google.maps.event.addListener(beachMarker<?php echo $location['location_id']; ?>, 'click', function() {
                                            infowindow<?php echo $location['location_id']; ?>.open(map,beachMarker<?php echo $location['location_id']; ?>);
                                        });             
                                    <?php } ?>  
                                }

                            $(document).ready(function() {
                                function initialize() {
                                    var mapOptions = {
                                        zoom: <?php echo $map_zoom; ?>,
                                        center: new google.maps.LatLng(<?php echo $geocode; ?>),
                                        zoomControl: true,
                                        scrollwheel: <?php echo $map_scroll; ?>,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };

                                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

                                    <?php foreach ($locations as $location) { ?>
                                        var LatLng<?php echo $location['location_id']; ?>= new google.maps.LatLng(<?php echo $location['geocode'] ?>);
                                        var contentString<?php echo $location['location_id']; ?> = '<?php echo $location["name"]; ?><br><?php echo ($location["postcode"] ? $location["postcode"].', ' : ''); echo ($location["city"] ? $location["city"].', ' : ''); echo $location["address"]; ?>';
                                        var infowindow<?php echo $location['location_id']; ?> = new google.maps.InfoWindow({
                                                content: contentString<?php echo $location['location_id']; ?>
                                            });
                                        var	beachMarker<?php echo $location['location_id']; ?> = new google.maps.Marker({
                                            position: LatLng<?php echo $location['location_id']; ?>,
                                            map: map,
                                            title: "<?php echo $location['name']; ?>"
                                        });	
                                        google.maps.event.addListener(beachMarker<?php echo $location['location_id']; ?>, 'click', function() {
                                            infowindow<?php echo $location['location_id']; ?>.open(map,beachMarker<?php echo $location['location_id']; ?>);
                                        });
                                    <?php } ?>
                               }

                                google.maps.event.addDomListener(window, 'load', initialize);	

                            });      
                        </script>   
                        <?php foreach ($locations as $location) { ?>
                           <div class="organization" itemscope itemtype="http://schema.org/Organization">
                                <div class="organization-heading">
                                  <h3 class="organization-title" onclick="ShowPositon(<?php echo $location['geocode'] ?>)" itemprop="name"><?php echo $location['name']; ?></h3>
                                </div>
                                <div class="organization-contacts">
                                    <div class="organization-body">
                                      <?php if ($location['image']) { ?>
                                      <div><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                                      <?php } ?>
                                      <p><strong><?php echo $text_address; ?></strong>
                                        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                            <?php if ($location['postcode']) { ?>
                                                <span itemprop="postalCode"><?php echo $location['postcode']; ?></span>, 
                                            <?php } ?>
                                            <?php if ($location['city']) { ?>
                                                <span itemprop="addressLocality"><?php echo $location['city']; ?></span>, 
                                            <?php } ?>
                                            <span itemprop="streetAddress"><?php echo $location['address']; ?></span>
                                        </span>
                                       </p>
                                       <p><strong><?php echo $text_telephone; ?></strong> <span itemprop="telephone"><?php echo $location['telephone']; ?></span></p>
                                       <?php if ($location['email']) { ?>
                                           <p><strong><?php echo $text_email; ?></strong>  <a href="mailto:<?php echo $location['email']; ?>"><span itemprop="email"><?php echo $location['email']; ?></span></a></p>
                                        <?php } ?>
                                        <?php if ($location['fax']) { ?>
                                            <p><strong><?php echo $text_fax; ?></strong> <span itemprop="faxNumber"><?php echo $location['fax']; ?></span></p>
                                        <?php } ?>
                                        <?php if ($location['open']) { ?>
                                            <p><strong><?php echo $text_open; ?></strong> <?php echo $location['open']; ?></p>
                                        <?php } ?>
                                        <?php if ($location['comment']) { ?>
                                            <div><?php echo $location['comment']; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> 
                        <?php } ?>     
                   <?php } ?>
              <?php } else { ?>
                  <?php foreach ($locations as $location) { ?>
                  <div class="organization" itemscope itemtype="http://schema.org/Organization">
                    <div class="organization-heading">
                      <h3 class="organization-title" itemprop="name"><?php echo $location['name']; ?></h3>
                    </div>
                   <div class="organization-contacts">
                      <div class="organization-body">
                            <?php if ($location['image']) { ?>
                                <div><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                            <?php } ?>
                            <p><strong><?php echo $text_address; ?></strong>
                                <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <?php if ($location['postcode']) { ?>
                                        <span itemprop="postalCode"><?php echo $location['postcode']; ?></span>, 
                                    <?php } ?>
                                    <?php if ($location['city']) { ?>
                                        <span itemprop="addressLocality"><?php echo $location['city']; ?></span>, 
                                    <?php } ?>
                                    <span itemprop="streetAddress"><?php echo $location['address']; ?></span>
                                </span>
                            </p>
                            <p><strong><?php echo $text_telephone; ?></strong> <span itemprop="telephone"><?php echo $location['telephone']; ?></span></p>
                            <?php if ($location['email']) { ?>
                                <p><strong><?php echo $text_email; ?></strong> <a href="mailto:<?php echo $location['email']; ?>"><span itemprop="email"><?php echo $location['email']; ?></span></a></p>
                            <?php } ?>
                            <?php if ($location['fax']) { ?>
                                <p><strong><?php echo $text_fax; ?></strong> <span itemprop="faxNumber"><?php echo $location['fax']; ?></span></p>
                            <?php } ?>
                            <?php if ($location['open']) { ?>
                                <p><strong><?php echo $text_open; ?></strong> <?php echo $location['open']; ?></p>
                            <?php } ?>
                            <?php if ($location['comment']) { ?>
                                <div><?php echo $location['comment']; ?></div>
                            <?php } ?>  
                            <?php if ($map_status) { ?>
                               <?php if ($location['geocode']) { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="map" id="map<?php echo $location['location_id']; ?>" style="width: 100%; height: 480px;"></div>
                                            <?php $geocodes = explode(',',$location['geocode']); ?>
                                             <script type="text/javascript"> 
                                              $(document).ready(function() {
                                                  var lat = {lat: <?php echo $geocodes[0]; ?>, lng: <?php echo $geocodes[1]; ?>}; 
                                                  var myOptions = {  
                                                     zoom: <?php echo $map_zoom; ?>,
                                                     center: lat,
                                                     mapTypeId: google.maps.MapTypeId.ROADMAP,
                                                     disableDefaultUI: true,
                                                     zoomControl: true,
                                                     scrollwheel: <?php echo $map_scroll; ?>
                                                  }; 
                                                  var map = new google.maps.Map(document.getElementById("map<?php echo $location['location_id']; ?>"), myOptions);   
                                                  var marker = new google.maps.Marker({
                                                    map: map,
                                                    // Define the place with a location, and a query string.
                                                    place: {
                                                      location: lat,
                                                      query: '<?php echo ($location['postcode'] ? $location['postcode'].', ' : ''); echo ($location['city'] ? $location['city'].', ' : ''); echo $location['address']; ?>'

                                                    },
                                                    // Attributions help users find your site again.
                                                    attribution: {
                                                      source: 'Google Maps JavaScript API',
                                                      webUrl: 'https://developers.google.com/maps/'
                                                    }
                                                  });

                                                  // Construct a new InfoWindow.
                                                  var infoWindow = new google.maps.InfoWindow({
                                                    content: '<?php echo $location['name']; ?><br><?php echo ($location['postcode'] ? $location['postcode'].', ' : ''); echo ($location['city'] ? $location['city'].', ' : ''); echo $location['address']; ?>'
                                                  });
                                                    infoWindow.open(map, marker);
                                                  // Opens the InfoWindow when marker is clicked.
                                                  marker.addListener('click', function() {
                                                    infoWindow.open(map, marker);
                                                  }); 
                                                });      
                                           </script>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
              <?php } ?>
            </div>
        <?php } ?>
        
        <?php if($description) { ?>
            <div class="description"><?php echo $description; ?></div>
        <?php } ?>
     
</div>
  
<?php include('catalog/view/theme/' . $config->get($config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>
