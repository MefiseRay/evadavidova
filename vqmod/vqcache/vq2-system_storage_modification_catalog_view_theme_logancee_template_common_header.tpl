<?php 
if($registry->has('theme_options') == false) { 
	header("location: themeinstall/index.php"); 
	exit; 
} 

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );

require_once( DIR_TEMPLATE.$config->get($config->get('config_theme') . '_directory')."/lib/module.php" );
$modules = new Modules($registry);
?>
<!DOCTYPE html>
<!--[if IE 7]> <html lang="<?php echo $lang; ?>" class="ie7 <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 3000) { echo 'home-bags'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2900) { echo 'home-sidebar-various'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2800) { echo 'home-jewelry'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2700) { echo 'home-interior'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2600) { echo 'home-parallax'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2500) { echo 'home-fluid-width'; } ?> <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive<?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>> <![endif]-->  
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8 <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 3000) { echo 'home-bags'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2900) { echo 'home-sidebar-various'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2800) { echo 'home-jewelry'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2700) { echo 'home-interior'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2600) { echo 'home-parallax'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2500) { echo 'home-fluid-width'; } ?> <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive<?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>> <![endif]-->  
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9 <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 3000) { echo 'home-bags'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2900) { echo 'home-sidebar-various'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2800) { echo 'home-jewelry'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2700) { echo 'home-interior'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2600) { echo 'home-parallax'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2500) { echo 'home-fluid-width'; } ?> <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive<?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>> <![endif]-->  
<!--[if !IE]><!--> <html lang="<?php echo $lang; ?>" class="<?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 3000) { echo 'home-bags'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2900) { echo 'home-sidebar-various'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2800) { echo 'home-jewelry'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2700) { echo 'home-interior'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2600) { echo 'home-parallax'; } ?> <?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) == 2500) { echo 'home-fluid-width'; } ?> <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive<?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>> <!--<![endif]-->  
<head>
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php if($theme_options->get( 'responsive_design' ) != '0') { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php } ?>
	<?php if ($description) { ?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>
	
	<!-- Google Fonts -->
	<link href="//fonts.googleapis.com/css?family=Lato:800,700,600,500,400,300" rel="stylesheet" type="text/css">
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<?php 
	if( $theme_options->get( 'font_status' ) == '1' ) {
		$lista_fontow = array();
		if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' && $theme_options->get( 'body_font' ) != 'Arial' && $theme_options->get( 'body_font' ) != 'Georgia' && $theme_options->get( 'body_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'body_font' );
			$lista_fontow[$font] = $font;
		}
		
		if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' && $theme_options->get( 'categories_bar' ) != 'Arial' && $theme_options->get( 'categories_bar' ) != 'Georgia' && $theme_options->get( 'categories_bar' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'categories_bar' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' && $theme_options->get( 'headlines' ) != 'Arial' && $theme_options->get( 'headlines' ) != 'Georgia' && $theme_options->get( 'headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard'  && $theme_options->get( 'footer_headlines' ) != 'Arial' && $theme_options->get( 'footer_headlines' ) != 'Georgia' && $theme_options->get( 'footer_headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'footer_headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' && $theme_options->get( 'page_name' ) != 'Arial' && $theme_options->get( 'page_name' ) != 'Georgia' && $theme_options->get( 'page_name' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'page_name' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' && $theme_options->get( 'button_font' ) != 'Arial' && $theme_options->get( 'button_font' ) != 'Georgia' && $theme_options->get( 'button_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'button_font' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' && $theme_options->get( 'custom_price' ) != 'Arial' && $theme_options->get( 'custom_price' ) != 'Georgia' && $theme_options->get( 'custom_price' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'custom_price' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		foreach($lista_fontow as $font) {
			echo '<link href="//fonts.googleapis.com/css?family=' . urlencode($font) . ':800,700,600,500,400,300" rel="stylesheet" type="text/css">';
			echo "\n";
		}
	}
	?>
	
	<?php $lista_plikow = array(
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/animate.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/eleganticons.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/simple-line-icons.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/stylesheet.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/responsive.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/menu.css',
            '/catalog/view/javascript/multilevel_menu/css/default.css',
			'/catalog/view/javascript/multilevel_menu/css/component.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/owl.carousel.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/owl.theme.default.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/font-awesome.min.css'
	); 
	
	//RTL
	if($page_direction[$config->get( 'config_language_id' )] == 'RTL'){
	    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/rtl.css';
	    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap_rtl.css';
	}
	
	// Full screen background slider
	if($config->get( 'full_screen_background_slider_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/jquery.vegas.css';
	
	// Category wall
	if($config->get( 'category_wall_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/category_wall.css';
	
	// Filter product
	$lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/filter_product.css';

	// Carousel brands
	if($config->get( 'carousel_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/carousel.css';
	
	// Wide width		
	if($theme_options->get( 'page_width' ) == 1) $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/wide-grid.css';
	
	// Normal width
	if($theme_options->get( 'page_width' ) == 3) $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/standard-grid.css';

	echo $theme_options->compressorCodeCss( $config->get($config->get('config_theme') . '_directory'), $lista_plikow, $theme_options->get( 'compressor_code_status' ), HTTP_SERVER ); 
	
	// Custom colors, fonts and backgrounds
	include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/custom_colors.php'); ?>
	
	<?php if($theme_options->get( 'custom_code_css_status' ) == 1) { ?>
	<link rel="stylesheet" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/css/custom_code.css">
	<?php } ?>
	
	<?php foreach ($styles as $style) { ?>
		<?php if(strpos($style['href'], "mf/jquery-ui.min.css") == true) { ?>
			<link rel="<?php echo $style['rel']; ?>" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/jquery-ui.min.css" media="<?php echo $style['media']; ?>" />
		<?php } elseif(strpos($style['href'], "mf/style.css") == true) { ?>
			<link rel="<?php echo $style['rel']; ?>" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/mega_filter.css" media="<?php echo $style['media']; ?>" />
		<?php } elseif(strpos($style['href'], "blog-news") == true) { ?>
			<link rel="<?php echo $style['rel']; ?>" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/blog.css" media="<?php echo $style['media']; ?>" />
		<?php } elseif($style['href'] != 'catalog/view/javascript/jquery/owl-carousel/owl.carousel.css') { ?>
			<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
	<?php } ?>
	
	<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/magnific/magnific-popup.css" media="screen" />
	
	<?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) > 900) { ?>
	<style type="text/css">
		.standard-body .full-width .container {
			max-width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php } ?>
		}
		
		     .standard-body .full-width .container .container {
		          max-width: none;
		     }

		.standard-body .fixed .background,
		.main-fixed {
			max-width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php } ?>
		}
	</style>
	<?php } ?>
	    
    <?php $lista_plikow = array(); 
    
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-2.1.1.min.js';
    if(file_exists('catalog/view/javascript/mf/jquery-ui.min.js')) $lista_plikow[] = 'catalog/view/javascript/mf/jquery-ui.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-migrate-1.2.1.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.easing.1.3.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/bootstrap.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/twitter-bootstrap-hover-dropdown.js';
    if($theme_options->get( 'lazy_loading_images' ) != '0') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/echo.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/common.js';
    $lista_plikow[] = '/catalog/view/javascript/multilevel_menu/js/modernizr.custom.js';
    $lista_plikow[] = '/catalog/view/javascript/multilevel_menu/js/jquery.dlmenu.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/tweetfeed.min.js';
    $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/bootstrap-notify.min.js';
    
    // Specials countdown
    if($theme_options->get( 'display_specials_countdown' ) == '1') {
         $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.plugin.min.js';
         $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.countdown.min.js';
    }
    
    // Carousel brands
    if($config->get( 'carousel_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.jcarousel.min.js';
    
    // Banner module
    if($config->get( 'banner_module' ) != '') $lista_plikow[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.cycle2.min.js';
    
    echo $theme_options->compressorCodeJs( $config->get($config->get('config_theme') . '_directory'), $lista_plikow, $theme_options->get( 'compressor_code_status' ), HTTPS_SERVER ); ?>
    
    <?php // Full screen background slider
    if($config->get( 'full_screen_background_slider_module' ) != '') { ?>
        <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/jquery.vegas.min.js"></script>
    <?php } ?>
    
    <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/owl.carousel2.thumbs.js"></script>
    
    <?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
    	<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/jquery-ui-1.10.4.custom.min.js"></script>
    <?php } ?>
    
    <script type="text/javascript" src="catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js"></script>
	
	<script type="text/javascript">
		var responsive_design = '<?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no'; } else { echo 'yes'; } ?>';
	</script>
	
	<?php foreach ($scripts as $script) { ?>
		<?php if($script != 'catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js') { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
		<?php if(strpos($script, "mega_filter.js") == true) { ?>
			<script type="text/javascript">
				function display_MFP(view) {
				     <?php if($theme_options->get( 'quick_view' ) == 1) { ?>
				     $('.quickview a').magnificPopup({
				          preloader: true,
				          tLoading: '',
				          type: 'iframe',
				          mainClass: 'quickview',
				          removalDelay: 200,
				          gallery: {
				           enabled: true
				          }
				     });
				     <?php } ?>
				     
					if (localStorage.getItem('display') == 'list') {
						display('list');
					} else {
						display('grid');
					}
				}
			</script>
		<?php } ?>
	<?php } ?>
	
	<?php if($theme_options->get( 'custom_code_javascript_status' ) == 1) { ?>
		<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/js/custom_code.js"></script>
	<?php } ?>
	
	<?php foreach ($analytics as $analytic) { ?>
	<?php echo $analytic; ?>
	<?php } ?>
	<!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/respond.min.js"></script>
	<![endif]-->

        <?php if ($smcm_status == 1) { ?>
        <!-- <?php echo $smcm_form_data['front_module_name'].':'.$smcm_form_data['front_module_version']; ?> -->
        <script src="catalog/view/javascript/ocdevwizard/smart_contact_me/jquery.magnific-popup.min.js?v=<?php echo $smcm_form_data['front_module_version']; ?>" type="text/javascript"></script>
        <link href="catalog/view/javascript/ocdevwizard/smart_contact_me/magnific-popup.css?v=<?php echo $smcm_form_data['front_module_version']; ?>" rel="stylesheet" media="screen" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ocdevwizard/smart_contact_me/stylesheet.css?v=<?php echo $smcm_form_data['front_module_version']; ?>"/>
        <script type="text/javascript" src="catalog/view/javascript/ocdevwizard/smart_contact_me/inputmask.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/ocdevwizard/smart_contact_me/main.js"></script>
        <!-- <?php echo $smcm_form_data['front_module_name'].':'.$smcm_form_data['front_module_version']; ?> -->
        <?php } ?>
      

				<?php if( ! empty( $mfp_robots_value ) ) { ?><meta name="robots" content="<?php echo $mfp_robots_value; ?>" /><?php } ?>

			
			<?php // << Product Option Image PRO ?>
			
			<?php if ( !empty($poip_installed) ) { ?>
				<script  type = "text/javascript" ><!--
					function poip_show_thumb(elem) {
						
						if ($(elem).attr('data-thumb') && $(elem).attr('data-image_id')) {
										
							var main_img = $('img[data-poip_id="image_'+$(elem).attr('data-image_id')+'"]');
							if (main_img.length == 0) {
								main_img = $('img[data-poip_id="'+$(elem).attr('data-image_id')+'"]');
							}
							
							var prev_img = main_img.attr('src'); // journal2 compatibility
							main_img.attr('src', $(elem).attr('data-thumb'));
							main_img.closest('a').attr('href', $(elem).attr('href'));
							
							// moment theme compatibility (second image)
							if ( main_img.parent().parent().is('div.product-thumb__primary') ) {
								main_img.parent().parent().siblings('div.product-thumb__secondary').find('a').attr('href', $(elem).attr('href'));
							}
							
							// journal2 compatibility
							if (main_img.parent().hasClass('has-second-image')) {
								main_img.parent().attr('style', main_img.parent().attr('style').replace(prev_img, $(elem).attr('data-thumb')) );
							}
							
						}
					}
				//--></script>
			<?php } ?>
					
			<?php
			
				if ( !empty($poip_installed) ) {
					if ( !empty($poip_inclide_file_name_custom) ) {
					
						// for poip_list (for common/header script) default should be loaded only if custom exists
						if ( !empty($poip_inclide_file_name_default) ) {
							if (class_exists('VQMod')) {
								include( VQMod::modCheck( modification($poip_inclide_file_name_default) ) );
							} else {
								include( modification($poip_inclide_file_name_default) );
							}
						}
					
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($poip_inclide_file_name_custom) ) );
						} else {
							include( modification($poip_inclide_file_name_custom) );
						}
						
					}
					
					if (isset($poip_theme_name) && $poip_theme_name=='cosyone') {
						set_include_path(get_include_path() . PATH_SEPARATOR . DIR_APPLICATION.'/view/theme/cosyone/template/common');
					}
				}
			?>
			<?php // >> Product Option Image PRO ?>
			

			
			<?php // << Product Option Image PRO ?>
			
			<?php if ( !empty($poip_installed) ) { ?>
				<script  type = "text/javascript" ><!--
					function poip_show_thumb(elem) {
						
						if ($(elem).attr('data-thumb') && $(elem).attr('data-image_id')) {
										
							var main_img = $('img[data-poip_id="image_'+$(elem).attr('data-image_id')+'"]');
							if (main_img.length == 0) {
								main_img = $('img[data-poip_id="'+$(elem).attr('data-image_id')+'"]');
							}
							
							var prev_img = main_img.attr('src'); // journal2 compatibility
							main_img.attr('src', $(elem).attr('data-thumb'));
							main_img.closest('a').attr('href', $(elem).attr('href'));
							
							// moment theme compatibility (second image)
							if ( main_img.parent().parent().is('div.product-thumb__primary') ) {
								main_img.parent().parent().siblings('div.product-thumb__secondary').find('a').attr('href', $(elem).attr('href'));
							}
							
							// journal2 compatibility
							if (main_img.parent().hasClass('has-second-image')) {
								main_img.parent().attr('style', main_img.parent().attr('style').replace(prev_img, $(elem).attr('data-thumb')) );
							}
							
						}
					}
				//--></script>
			<?php } ?>
					
			<?php
			
				if ( !empty($poip_installed) ) {
					if ( !empty($poip_inclide_file_name_custom) ) {
					
						// for poip_list (for common/header script) default should be loaded only if custom exists
						if ( !empty($poip_inclide_file_name_default) ) {
							if (class_exists('VQMod')) {
								include( VQMod::modCheck( modification($poip_inclide_file_name_default) ) );
							} else {
								include( modification($poip_inclide_file_name_default) );
							}
						}
					
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($poip_inclide_file_name_custom) ) );
						} else {
							include( modification($poip_inclide_file_name_custom) );
						}
						
					}
					
					if (isset($poip_theme_name) && $poip_theme_name=='cosyone') {
						set_include_path(get_include_path() . PATH_SEPARATOR . DIR_APPLICATION.'/view/theme/cosyone/template/common');
					}
				}
			?>
			<?php // >> Product Option Image PRO ?>
			
				</head>
				
<body class="<?php echo $class; ?> header-type-<?php echo $theme_options->get( 'header_type' ); ?>">

                <?php echo $quicksignup; ?>

	
	<div id="notification-popupmaster" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $titulo ; ?></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
			<center>
			<div style="float:right">
                <button type="button" style="margin-top:10px;" class="btn btn-default" data-dismiss="modal"><?php echo $continuar ; ?> <i class="fa fa-check"></i></button>
				<a href="/cart/" style="margin-top:3px;" class="btn btn-warning"><?php echo $carrinho ; ?> <i class="fa fa-shopping-cart"></i></a>
                <a onclick="yaCounter48659294.reachGoal('checkout');" href="<?php echo $checkout;?>" style="margin-top:3px;" class="btn btn-success"><?php echo $comprar ; ?> <i class="fa fa-credit-card"></i></a>
				</div>
				</center>
            </div>
        </div>
    </div>
</div> <!-- https://www.opencartmaster.com.br Desenvolvido por Denis Cunha -->
	
<?php if($theme_options->get( 'widget_facebook_status' ) == 1) { ?>
<div class="facebook_<?php if($theme_options->get( 'widget_facebook_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="facebook-icon"></div>
	<div class="facebook-content">
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<div class="fb-like-box fb_iframe_widget" profile_id="<?php echo $theme_options->get( 'widget_facebook_id' ); ?>" data-colorscheme="light" data-height="370" data-connections="16" fb-xfbml-state="rendered"></div>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".facebook_right").hover(function() {            
			$(".facebook_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_right").stop(true, false).animate({right: "-308"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".facebook_left").hover(function() {            
			$(".facebook_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_left").stop(true, false).animate({left: "-308"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_twitter_status' ) == 1) { ?>
<div class="twitter_<?php if($theme_options->get( 'widget_twitter_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="twitter-icon"></div>
	<div class="twitter-content">
		<a class="twitter-timeline"  href="https://twitter.com/@<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?>" data-chrome="noborders" data-tweet-limit="<?php echo $theme_options->get( 'widget_twitter_limit' ); ?>"  data-widget-id="<?php echo $theme_options->get( 'widget_twitter_id' ); ?>" data-theme="light" data-related="twitterapi,twitter" data-aria-polite="assertive">Tweets by @<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?></a>
	</div>
	
	<script type="text/javascript">    
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	$(function() {  
		$(".twitter_right").hover(function() {            
			$(".twitter_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".twitter_left").hover(function() {            
			$(".twitter_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_custom_status' ) == 1) { ?>
<div class="custom_<?php if($theme_options->get( 'widget_custom_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="custom-icon"></div>
	<div class="custom-content">
		<?php $lang_id = $config->get( 'config_language_id' ); ?>
		<?php $custom_content = $theme_options->get( 'widget_custom_content' ); ?>
		<?php if(isset($custom_content[$lang_id])) echo html_entity_decode($custom_content[$lang_id]); ?>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".custom_right").hover(function() {            
			$(".custom_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".custom_left").hover(function() {            
			$(".custom_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
	
</div>
<?php } ?>

<?php if($theme_options->get( 'quick_view' ) == 1) { ?>
<script type="text/javascript">
$(window).load(function(){
     $('.quickview a').magnificPopup({
          preloader: true,
          tLoading: '',
          type: 'iframe',
          mainClass: 'quickview',
          removalDelay: 200,
          gallery: {
           enabled: true
          }
     });
});
</script>
<?php } ?>

<?php 
$popup = $modules->getModules('popup');
if( count($popup) ) { 
	foreach ($popup as $module) {
		echo $module;
	}
} ?>

<?php 
$header_notice = $modules->getModules('header_notice');
if( count($header_notice) ) { 
	foreach ($header_notice as $module) {
		echo $module;
	}
} ?>

<?php 
$cookie = $modules->getModules('cookie');
if( count($cookie) ) { 
 foreach ($cookie as $module) {
  echo $module;
 }
} ?>

<div class="<?php if($theme_options->get( 'main_layout' ) == 2) { echo 'fixed-body'; } else { echo 'standard-body'; } ?>">
	<div id="main" class="<?php if($theme_options->get( 'main_layout' ) == 2) { echo 'main-fixed'; } ?>">
		<?php 
		if($theme_options->get( 'header_type' ) == 2) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_02.tpl'); 
		} elseif($theme_options->get( 'header_type' ) == 3) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_03.tpl');
		} elseif($theme_options->get( 'header_type' ) == 4) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_04.tpl');
		} elseif($theme_options->get( 'header_type' ) == 5) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_05.tpl');
		} elseif($theme_options->get( 'header_type' ) == 6) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_06.tpl');
		} elseif($theme_options->get( 'header_type' ) == 7) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_07.tpl');
		} elseif($theme_options->get( 'header_type' ) == 8) {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_08.tpl');
		} else {
			include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/common/header/header_01.tpl');
		}	
		?>