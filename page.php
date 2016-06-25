<?php

get_header();

if(have_posts()) : 
    while(have_posts()) : the_post(); ?>
    
    <article class="post page">
        
        <?php 
        
        if (has_children() OR $post->post_parent > 0) { ?>
        
        <nav class="site-subnav children-links clearfix">
            
<!--            <span class="parent-link"><a href="<?php print get_the_permalink(get_top_ancestor_id()); ?>"><?php print get_the_title(get_top_ancestor_id()); ?></a></span>-->
            
            <ul id="positionfix-subnav">
                <?php 
                $args = array(
                    'child_of' => get_top_ancestor_id(),
                    'title_li' => ''
                );
                 wp_list_pages($args); ?>
            </ul>
        </nav>
        <?php } ?>
        <h2><?php the_title(); ?></h2>
        <?php the_post_thumbnail(); ?>
        <?php the_content(); ?>
    </article>

    <?php endwhile;
    else : 
        echo '<p> No content </p>';
    endif;

get_footer();

?>