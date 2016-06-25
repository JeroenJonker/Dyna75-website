<?php

get_header();

if(have_posts()) : 
    while(have_posts()) : the_post(); ?>
        <?php if(in_category('hoofdnieuws')) : ?>
             <!--article class="post hoofdnieuws"--> 
            <article class ="post page ">
                <h2><?php the_title(); ?></h2>
                <small><?php the_time('F jS, Y'); ?></small>
                <?php the_post_thumbnail('banner-image'); ?>
                <?php the_content(); ?>
            </article>
        <?php elseif(in_category('agenda')) : ?>
             <article class="post agenda page">
                 <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                 <?php the_content(''); ?>
            </article>
        <?php else : ?>
            <article class="post nieuws page">
                <h2><?php the_title(); ?></h2>
                <small><?php the_time('F jS, Y'); ?></small>
                <?php the_post_thumbnail('banner-image'); ?>
                <?php the_content(); ?>
            </article>
        <?php endif; ?>

    <?php endwhile;
    else : 
        echo '<p> No content </p>';
    endif;

get_footer();

?>