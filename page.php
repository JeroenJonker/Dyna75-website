<?php

get_header();

if(have_posts()) : 
    while(have_posts()) : the_post(); ?>
    
    <article class="post page">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    </article>

    <?php endwhile;
    else : 
        echo '<p> No content </p>';
    endif;

get_footer();

?>