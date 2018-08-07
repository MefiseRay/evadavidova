<div class="widget-blog blog-layout2 clearfix col-lg-offset-1 col-lg-10">
     <div class="main-heading">
          <div class="heading-title">
               <h2><span><?php echo $module['content']['title']; ?></span></h2>
          </div>
     </div>
     
     <div class="blog-cat">
          <ul class="blog-grid row ">
               <?php foreach($module['content']['articles'] as $article) { ?>
               <li class="blog item  col-xs-12 col-sm-12 col-md-12 col-lg-12 tp-1-col">
                    <div class="main-post clearfix">
                         <h3 class="title-post"><?php echo '<a href="' . $article['href'] . '">' . $article['title'] . '</a>'; ?></h3>
                         <div class="main-post-inner">
                              <span><?php echo date('d-m-Y', strtotime($article['date_published'])) ?> | <?php echo $article['comments_count']; ?> <?php echo $article['comments_text']; ?></span>
                         </div>
                    </div>
               </li>
               <?php } ?>
          </ul>
     </div>
</div>