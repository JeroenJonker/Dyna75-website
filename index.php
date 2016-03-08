<?php

get_header();

if(have_posts()) : 
    while(have_posts()) : the_post(); ?>
        <?php if(in_category('hoofdnieuws')) : ?>
             <!--article class="post hoofdnieuws"--> 
            <article id="hoofdnieuws">
                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'banner-image' );?>
                <a href="<?php the_permalink(); ?>"><div id="post" class="your-class" style="background-image: url('<?php echo $thumb['0'];?>')">
                <h2><?php the_title(); ?></h2>
                 <?php the_content(''); ?>
                    </div></a>
            </article>
        <?php elseif(in_category('agenda')) : ?>
             <article class="post agenda">
                 <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                 <?php the_content(''); ?>
            </article>
        <?php else : ?>
            <article class="post <?php if(has_post_thumbnail()) { ?> has-thumbnail <?php } ?>">
                <div class="post-thumbnail">
                    <a href= "<?php the_permalink(); ?>"> <?php the_post_thumbnail('small-thumbnail'); ?> </a>
                </div>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <small><?php the_time('F jS, Y'); ?></small>
                <?php the_content('Verder lezen &raquo;'); ?>
            </article>
        <?php endif; ?>

    <?php endwhile;
    else : 
        echo '<p> No content </p>';
    endif;

get_footer();

?>