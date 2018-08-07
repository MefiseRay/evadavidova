<div class="home03-posts">
     <h2 class="title"><span><?php echo $module['content']['title']; ?></span></h2>
     <ul>
          <?php foreach($module['content']['articles'] as $article) { ?>
          <li class="news-item">
               <div class="blog-title h4"><?php echo '<a href="' . $article['href'] . '">' . $article['title'] . '</a>'; ?></div>
               <div class="blog-info"><span><?php echo date('d-m-Y', strtotime($article['date_published'])) ?> | <?php echo $article['comments_count']; ?> <?php echo $article['comments_text']; ?></span></div>
          </li>
          <?php } ?>
     </ul>
</div>