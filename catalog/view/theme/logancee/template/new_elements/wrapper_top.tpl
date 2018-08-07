<?php $grid_center = 12; 
if($column_left != '') $grid_center = $grid_center-3; 
if($column_right != '') $grid_center = $grid_center-3; 
$modules_old_opencart = new Modules($registry); 


if($theme_options->get( 'home_text', $config->get( 'config_language_id' ) ) != '') {
     $breadcrumbs_home = $theme_options->get( 'home_text', $config->get( 'config_language_id' ) ); 
} else { 
    $breadcrumbs_home = 'Home'; 
}

$breadcrumbs_line = '';
$i = 0;
$n = count($breadcrumbs) - 1;
foreach ($breadcrumbs as $breadcrumb) {
    $breadcrumbs_line .= '<li>';
    if ($i != $n) {
		$breadcrumbs_line .= '<a href="'. $breadcrumb['href']. '">';
	}
	if ($i == 0) {
		$breadcrumbs_line .= $breadcrumbs_home;
	} else {
		$breadcrumbs_line .= $breadcrumb['text'];
	}
	if ($i != $n) {
		$breadcrumbs_line .= '</a> ';
	}
	$breadcrumbs_line .= '</li> ';

	$i++;
}
?>

<!-- BREADCRUMB
	================================================== -->
<div class="breadcrumb <?php if($theme_options->get( 'breadcrumb_layout' ) == 2) { echo 'fixed'; } else { echo 'full-width'; } ?>">
	<div class="background-breadcrumb"></div>
	<div class="background<?php $breadcrumb = $modules_old_opencart->getModules('breadcrumb'); if( count($breadcrumb) ) { foreach ($breadcrumb as $module) { echo $module; } } ?>">
		<div class="shadow"></div>
		<div class="pattern">
			<div class="container">
				<div class="clearfix">
					<ul>
						<?php echo $breadcrumbs_line; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [	  
		<?php $i = 0; 
			$k = count($breadcrumbs);
			foreach( $breadcrumbs as $breadcrumb ) { $i++; ?>
				{ 
					"@type": "ListItem",
					"position": <?php echo $i; ?>,
					"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					 <?php if ($i == 1) { ?>
						"name": "Главная"
					<?php } else { ?>
						"name": "<?php echo $breadcrumb['text']; ?>"
					<?php } ?>
				}
			}
			<?php	if($i != $k) { echo ','; } ?>
		<?php } ?>
		]
	}
</script>

<!-- MAIN CONTENT
	================================================== -->
<div class="main-content <?php if($theme_options->get( 'content_layout' ) == 2) { echo 'fixed'; } else { echo 'full-width'; } ?> inner-page">
	<div class="background-content"></div>
	<div class="background">
		<div class="shadow"></div>
		<div class="pattern">
			<div class="container">
				<?php 
				$preface_left = $modules_old_opencart->getModules('preface_left');
				$preface_right = $modules_old_opencart->getModules('preface_right');
				?>
				<?php if( count($preface_left) || count($preface_right) ) { ?>
				<div class="row">
					<div class="col-sm-9">
						<?php
						if( count($preface_left) ) {
							foreach ($preface_left as $module) {
								echo $module;
							}
						} ?>
					</div>
					
					<div class="col-sm-3">
						<?php
						if( count($preface_right) ) {
							foreach ($preface_right as $module) {
								echo $module;
							}
						} ?>
					</div>
				</div>
				<?php } ?>
				
				<?php 
				$preface_fullwidth = $modules_old_opencart->getModules('preface_fullwidth');
				if( count($preface_fullwidth) ) {
					echo '<div class="row"><div class="col-sm-12">';
					foreach ($preface_fullwidth as $module) {
						echo $module;
					}
					echo '</div></div>';
				} ?>
				
				<div class="row">
					<?php 
					$columnleft = $modules_old_opencart->getModules('column_left');
					if( count($columnleft) ) { ?>
					<div class="col-md-3" id="column-left">
						<?php
						foreach ($columnleft as $module) {
							echo $module;
						}
						?>
					</div>
					<?php } ?>
					
					<?php $grid_center = 12; if( count($columnleft) ) { $grid_center = 9; } ?>
					<div class="col-md-<?php echo $grid_center; ?>">
						<?php 
						$content_big_column = $modules_old_opencart->getModules('content_big_column');
						if( count($content_big_column) ) { 
							foreach ($content_big_column as $module) {
								echo $module;
							}
						} ?>
						
						<?php 
						$content_top = $modules_old_opencart->getModules('content_top');
						if( count($content_top) ) { 
							foreach ($content_top as $module) {
								echo $module;
							}
						} ?>
						
						<div class="row">
							<?php 
							$grid_content_top = 12; 
							$grid_content_right = 3;
							$column_right = $modules_old_opencart->getModules('column_right'); 
							if( count($column_right) ) {
								if($grid_center == 9) {
									$grid_content_top = 8;
									$grid_content_right = 4;
								} else {
									$grid_content_top = 9;
									$grid_content_right = 3;
								}
							}
							?>
							<div class="col-md-<?php echo $grid_content_top; ?> center-column" id="content">

								<?php if (isset($error_warning)) { ?>
									<?php if ($error_warning) { ?>
									<div class="warning">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?php echo $error_warning; ?>
									</div>
									<?php } ?>
								<?php } ?>
								
								<?php if (isset($success)) { ?>
									<?php if ($success) { ?>
									<div class="success">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?php echo $success; ?>
									</div>
									<?php } ?>
								<?php } ?>
								
                                <?php if (!isset($product_id)) { ?>
                                    <h1 id="title-page"><?php echo $heading_title; ?>
                                        <?php if(isset($weight)) { if ($weight) { ?>
                                            &nbsp;(<?php echo $weight; ?>)
                                        <?php } } ?>
                                    </h1>
                                <?php } ?>