<?php if($theme_options->get( 'fixed_header' ) == 1) { ?>
<div class="sticky-header is-sticky">
     <div class="wrap">
          <div class="standard-body">
               <div class="full-width">
                    <div class="container"><div style="position: relative">
                         <div class="logo-sticky">
                              <?php if ($logo) { ?>
                              <a href="<?php echo $home; ?>"><span><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></span></a>
                              <?php } ?>
                         </div>
                         
                         <div class="sticky-icon-group">
                              <div class="sticky-search">
                                   <i class="icon-magnifier"></i>
                                   <div class="quick-search">
                                        <div class="form-search">
                                             <input id="search2" type="text" name="q" value="" class="input-text" maxlength="128" placeholder="<?php echo $search; ?>" autocomplete="off">
                                             <button type="submit" title="Search" class="button-search"><span><i aria-hidden="true" class="icon_search"></i></span></button>
                                        </div>
                                        <i aria-hidden="true" class="icon_close"></i>
                                   </div>
                              </div>
                              
                              <div class="sticky-cart">
                                   <?php echo $cart; ?>
                              </div>
                              
                              <div class="settings">
                                    <i class="icon-settings"></i>
                                    <div class="settings-inner">
                                         <div class="setting-content">
                                              <?php if($language != '') { ?>
                                              <div class="setting-language">
                                                   <div class="title"><?php if($theme_options->get( 'select_language_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'select_language_text', $config->get( 'config_language_id' ) )); } else { echo 'Select language'; } ?></div>
                                                   <?php echo $language; ?>
                                              </div>
                                              <?php } ?>
                                              
                                              <?php if($currency != '') { ?>
                                              <div class="setting-currency">
                                                   <div class="title"><?php if($theme_options->get( 'select_currency_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'select_currency_text', $config->get( 'config_language_id' ) )); } else { echo 'Select currency'; } ?></div>
                                                   <?php echo $currency; ?>
                                              </div>
                                              <?php } ?>
                                              
                                              <div class="setting-option">
                                                   <ul>
                                                        <li><a href="<?php echo $login; ?>"><i class="icon-lock-open icons"></i><span><?php echo $text_login; ?> / <?php echo $text_register; ?></span></a></li>
                                                        <li><a href="<?php echo $account; ?>"><i class="icon-user icons"></i><span><?php echo $text_account; ?></span></a></li>
                                                        <li><a href="<?php echo $wishlist; ?>"><i class="icon-heart icons"></i><span><?php echo $text_wishlist; ?></span></a></li>
                                                        <li><a href="<?php echo $shopping_cart; ?>"><i class="icon-handbag icons"></i><span><?php echo $text_shopping_cart; ?></span></a></li>
                                                        <li><a href="<?php echo $checkout; ?>"><i class="icon-note icons"></i><span><?php echo $text_checkout; ?></span></a></li>
                                                   </ul>
                                              </div>
                                         </div>
                                    </div>
                               </div>
                          </div>
                         
                         <div class="main-menu">
                              <?php 
                              $menu = $modules->getModules('menu');
                              if( count($menu) ) {
                              	foreach ($menu as $module) {
                              		echo $module;
                              	}
                              } elseif($categories) {
                              ?>
                              <div class="container-megamenu container horizontal">
                              	<div class="megaMenuToggle">
                              		<div class="megamenuToogle-wrapper">
                              			<div class="megamenuToogle-pattern">
                              				<div class="container">
                              					<div><span></span><span></span><span></span></div>
                              					Navigation
                              				</div>
                              			</div>
                              		</div>
                              	</div>
                              	
                              	<div class="megamenu-wrapper">
                              		<div class="megamenu-pattern">
                              			<div class="container">
                              				<ul class="megamenu shift-up">
                              					<?php foreach ($categories as $category) { ?>
                              					<?php if ($category['children']) { ?>
                              					<li class="with-sub-menu hover"><p class="close-menu"></p><p class="open-menu"></p>
                              						<a href="<?php echo $category['href'];?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
                              					<?php } else { ?>
                              					<li>
                              						<a href="<?php echo $category['href']; ?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
                              					<?php } ?>
                              						<?php if ($category['children']) { ?>
                              						<?php 
                              							$width = '100%';
                              							$row_fluid = 3;
                              							if($category['column'] == 1) { $width = '270px'; $row_fluid = 12; }
                              							if($category['column'] == 2) { $width = '500px'; $row_fluid = 6; }
                              							if($category['column'] == 3) { $width = '700px'; $row_fluid = 4; }
                              						?>
                              						<div class="sub-menu" style="width: <?php echo $width; ?>">
                              							<div class="content">
                              								<p class="arrow"></p>
                              								<div class="row hover-menu">
                              									<?php for ($i = 0; $i < count($category['children']);) { ?>
                              									<div class="col-sm-<?php echo $row_fluid; ?> mobile-enabled">
                              										<div class="menu">
                              											<ul>
                              											  <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
                              											  <?php for (; $i < $j; $i++) { ?>
                              											  <?php if (isset($category['children'][$i])) { ?>
                              											  <li><a href="<?php echo $category['children'][$i]['href']; ?>" onclick="window.location = '<?php echo $category['children'][$i]['href']; ?>';"><?php echo $category['children'][$i]['name']; ?></a></li>
                              											  <?php } ?>
                              											  <?php } ?>
                              											</ul>
                              										</div>
                              									</div>
                              									<?php } ?>
                              								</div>
                              							</div>
                              						</div>
                              						<?php } ?>
                              					</li>
                              					<?php } ?>
                              				</ul>
                              			</div>
                              		</div>
                              	</div>
                              </div>
                              <?php
                              }
                              ?>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<?php } ?>

<!-- HEADER
	================================================== -->
<header class="header">
	<div class="background-header"></div>
	<div class="slider-header">
		<!-- Top Bar -->
		<div id="top-bar" class="<?php if($theme_options->get( 'top_bar_layout' ) == 2) { echo 'fixed'; } else { echo 'full-width'; } ?>">
			<div class="background-top-bar"></div>
			<div class="background">
				<div class="shadow"></div>
				<div class="pattern">
					<div class="container">
						<div class="header-top-inner">
						     <div class="row">
						          <div class="hidden-xs col-xs-12 col-sm-4 col-md-4 col-lg-3">
						               <?php echo $language; ?>
						               <?php if($language != '') { ?><span class="delimiter"></span><?php } ?>
						               <?php echo $currency; ?>
						          </div>
						          
						          <div class="top-bar-wrap hidden-xs col-xs-4 col-sm-5 col-md-4 col-lg-6">
						               <div class="top-bar">
						                    <div class="inner-top-bar">
						                         <?php if ($logged) { ?>
						                         <div class="hidden-xs register-topbar">
						                              <a href="<?php echo $logout; ?>"><span><?php echo $text_logout; ?></span></a>
						                         </div>
						                         <?php } else { ?>
						                         <div class="welcome-user login-topbar hidden-xs hidden-sm hidden-md"><?php if($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) )); } else { echo 'Hi Guest!'; } ?></div>
						                         <div class="hidden-xs login-topbar">
						                              <a href="<?php echo $login; ?>"><span><?php echo $text_login; ?></span></a>
						                         </div>
						                         <div class="hidden-xs register-topbar">
						                              <a href="<?php echo $register; ?>"><span><?php echo $text_register; ?></span></a>
						                         </div>
						                         <?php } ?>
						                    </div>
						               </div>
						          </div>
						          
						          <?php $top_blocks = $modules->getModules('top_block'); ?>
						          <?php  if(count($top_blocks)) { ?>
						               <?php foreach($top_blocks as $module) { ?>
						          	<?php echo $module; ?>
						          	<?php } ?>
						          <?php } ?>
						          
						          <div class="settings-topbar visible-xs-block col-xs-2">
						               <div class="settings">
						                    <i class="icon-settings"></i>
						                    <div class="settings-inner">
						                         <div class="setting-content">
						                              <?php if($language != '') { ?>
						                              <div class="setting-language">
						                                   <div class="title"><?php if($theme_options->get( 'select_language_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'select_language_text', $config->get( 'config_language_id' ) )); } else { echo 'Select language'; } ?></div>
						                                   <?php echo $language; ?>
						                              </div>
						                              <?php } ?>
						                              
						                              <?php if($currency != '') { ?>
						                              <div class="setting-currency">
						                                   <div class="title"><?php if($theme_options->get( 'select_currency_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'select_currency_text', $config->get( 'config_language_id' ) )); } else { echo 'Select currency'; } ?></div>
						                                   <?php echo $currency; ?>
						                              </div>
						                              <?php } ?>
						                              
						                              <div class="setting-option">
						                                   <ul>
						                                        <li><a href="<?php echo $login; ?>"><i class="icon-lock-open icons"></i><span><?php echo $text_login; ?> / <?php echo $text_register; ?></span></a></li>
						                                        <li><a href="<?php echo $account; ?>"><i class="icon-user icons"></i><span><?php echo $text_account; ?></span></a></li>
						                                        <li><a href="<?php echo $wishlist; ?>"><i class="icon-heart icons"></i><span><?php echo $text_wishlist; ?></span></a></li>
						                                        <li><a href="<?php echo $shopping_cart; ?>"><i class="icon-handbag icons"></i><span><?php echo $text_shopping_cart; ?></span></a></li>
						                                        <li><a href="<?php echo $checkout; ?>"><i class="icon-note icons"></i><span><?php echo $text_checkout; ?></span></a></li>
						                                   </ul>
						                              </div>
						                         </div>
						                    </div>
						               </div>
						          </div>
						     </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Top of pages -->
		<div id="top" class="<?php if($theme_options->get( 'header_layout' ) == 2) { echo 'fixed'; } else { echo 'full-width'; } ?>">
			<div class="background-top"></div>
			<div class="background">
				<div class="shadow"></div>
				<div class="pattern">
					<div class="container">
						<div class="header-inner">
						     <div class="row">
						          <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
						               <div class="top-seach">
						                    <div class="quick-search">
						                         <div class="form-search">
						                              <input id="search" type="text" name="search" value="" class="input-text" maxlength="128" placeholder="<?php echo $search; ?>" autocomplete="off">
						                              <button type="submit" title="Search" class="button-search">
						                                   <span><i aria-hidden="true" class="icon_search"></i></span>
						                              </button>
						                         </div>
						                     </div>
						                </div>
						           </div>
						           
						           <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
						                <div class="logo-home">
						                     <?php if ($logo) { ?>
						                     <div class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
						                     <?php } ?>
						                </div>
						           </div>
						           
						           <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
                                             <?php echo $cart; ?>						                
						           </div>
						      </div>
					     </div>
					</div>
					
					<?php 
					$menu = $modules->getModules('menu');
					if( count($menu) ) {
						foreach ($menu as $module) {
							echo $module;
						}
					} elseif($categories) {
					?>
					<div class="container-megamenu container horizontal">
						<div class="megaMenuToggle">
							<div class="megamenuToogle-wrapper">
								<div class="megamenuToogle-pattern">
									<div class="container">
										<div><span></span><span></span><span></span></div>
										<span>Navigation</span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="megamenu-wrapper">
							<div class="megamenu-pattern">
								<div class="container">
									<ul class="megamenu shift-up">
										<?php foreach ($categories as $category) { ?>
										<?php if ($category['children']) { ?>
										<li class="with-sub-menu hover"><p class="close-menu"></p><p class="open-menu"></p>
											<a href="<?php echo $category['href'];?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
										<?php } else { ?>
										<li>
											<a href="<?php echo $category['href']; ?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
										<?php } ?>
											<?php if ($category['children']) { ?>
											<?php 
												$width = '100%';
												$row_fluid = 3;
												if($category['column'] == 1) { $width = '270px'; $row_fluid = 12; }
												if($category['column'] == 2) { $width = '500px'; $row_fluid = 6; }
												if($category['column'] == 3) { $width = '700px'; $row_fluid = 4; }
											?>
											<div class="sub-menu" style="width: <?php echo $width; ?>">
												<div class="content">
													<p class="arrow"></p>
													<div class="row hover-menu">
														<?php for ($i = 0; $i < count($category['children']);) { ?>
														<div class="col-sm-<?php echo $row_fluid; ?> mobile-enabled">
															<div class="menu">
																<ul>
																  <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
																  <?php for (; $i < $j; $i++) { ?>
																  <?php if (isset($category['children'][$i])) { ?>
																  <li><a href="<?php echo $category['children'][$i]['href']; ?>" onclick="window.location = '<?php echo $category['children'][$i]['href']; ?>';"><?php echo $category['children'][$i]['name']; ?></a></li>
																  <?php } ?>
																  <?php } ?>
																</ul>
															</div>
														</div>
														<?php } ?>
													</div>
												</div>
											</div>
											<?php } ?>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	
	<?php $slideshow = $modules->getModules('slideshow'); ?>
	<?php  if(count($slideshow)) { ?>
	<!-- Slider -->
	<div id="slider" class="<?php if($theme_options->get( 'slideshow_layout' ) == 2) { echo 'fixed'; } else { echo 'full-width'; } ?>">
		<div class="background-slider"></div>
		<div class="background">
			<div class="shadow"></div>
			<div class="pattern">
				<?php foreach($slideshow as $module) { ?>
				<?php echo $module; ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
</header>