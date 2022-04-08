<?php
get_header();
?>
<main id="content" class="site-main accueil" role="main">
<div id="archive_content">
<?php

if(have_posts()){
    while(have_posts()){
        the_post();
        $image = get_the_post_thumbnail();
        $title= get_the_title();
        $description = get_the_excerpt();
        $url = get_post_permalink();
        ?>
             <a class="archive_item" href="<?=$url?>">
              <?=$image?> 
             <div>
                <h3><?=$title?></h3>
                <p><?=$description?></p>
             </div> 
            </a>
        <?php
    }
}
?>
</div> 
</main>
<?php
get_footer();