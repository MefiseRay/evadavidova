<?php 
if($registry->has('theme_options') == false) { 
	header("location: themeinstall/index.php"); 
	exit; 
} 

$theme_options = $registry->get('theme_options'); ?>

<div class="box box-with-categories" style="margin-top:15px;">
  <div class="box-content box-category">
    <ul class="accordion" id="accordion-category">
	  <?php foreach ($pages_top as $page_top) { ?>
		<li class="panel"><a href="<?php echo $page_top['href']; ?>"<?php echo ($page_top['active'] ? ' class="active"' : ''); ?>><span><?php echo $page_top['name']; ?></span></a></li>
	  <?php } ?>
      <?php $i = 0; foreach ($categories as $category) { $i++; ?>
      <li class="panel">
        <?php if ($category['category_id'] == $category_id) { ?>
        <a href="<?php echo $category['href']; ?>" class="active"><span><?php echo $category['name']; ?></span></a>
        <?php } else { ?>
        <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
        <?php } ?>
        <?php $categories_2 = $theme_options->getCategories($category['category_id']); ?>
        <?php if ($categories_2) { ?>
        <span class="head"><a style="float:right;padding-right:5px" class="accordion-toggle<?php if ($category['category_id'] != $category_id) { echo ' collapsed'; } ?>" data-toggle="collapse" data-parent="#accordion-category" href="#category<?php echo $i; ?>"><span class="plus">+</span><span class="minus">-</span></a></span>
        <?php if(!empty($categories_2)) { ?>
        <div id="category<?php echo $i; ?>" class="panel-collapse collapse <?php if ($category['category_id'] == $category_id) { echo 'in'; } ?>" style="clear:both">
        	<ul>
		       <?php foreach ($categories_2 as $child) { ?>
		        <li>
		         <?php if ($child['category_id'] == $child_id) { ?>
		         <a href="<?php echo $child['href']; ?>" class="active"><span><?php echo $child['name']; ?></span></a>
		         <?php } else { ?>
		         <a href="<?php echo $child['href']; ?>"><span><?php echo $child['name']; ?></span></a>
		         <?php } ?>
		        </li>
		       <?php } ?>
	        </ul>
        </div>
        <?php } ?>
        <?php } ?>
      </li>   
      <?php } ?>
      <?php foreach ($pages_bottom as $page_bottom) { ?>
		<li class="panel"><a href="<?php echo $page_bottom['href']; ?>"<?php echo ($page_bottom['active'] ? ' class="active"' : ''); ?>><span><?php echo $page_bottom['name']; ?></span></a></li>
	  <?php } ?>
    </ul>
  </div>
</div>
