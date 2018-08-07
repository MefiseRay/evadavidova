<div class="sunglasses-posts clearfix">
     <div class="blog-heading">
          <h2><?php echo $module['content']['title']; ?></h2>
     </div>
     
     <div class="blog-items clearfix">
               <?php foreach($module['content']['articles'] as $article) { ?>
               <div class="item">
                    <div class="blog-item clearfix">
                         <div class="content-blog">
                              <div class="blog-top">
                                   <h3><?php echo '<a href="' . $article['href'] . '">' . $article['title'] . '</a>'; ?></h3>
                                   <p class="blog_author">
                                        <span class="date"><?php echo date('M d Y', strtotime($article['date_published'])) ?><span class="holizol">/</span></span>
                                        <a href="<?php echo $article['href']; ?>"><i class="fa fa-comments-o"></i> <?php echo $article['comments_count']; ?></a>
                                   </p>
                              </div>
                              
                              <div class="short-des">
                                   <?php if($article['thumb']):?>
                                   <div  class="image">
                                       <img alt="" src="<?php echo $article['thumb'] ?>">
                                   </div>
                                   <?php endif; ?>
                              </div>
                         </div>
                    </div>
               </div>
               <?php } ?>
     </div>
</div>