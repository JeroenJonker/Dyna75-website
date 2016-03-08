<?php
/*
Template Name: Archives
*/
get_header(); ?>
		<article class="post page">
		<h2>Archives by Month:</h2>
            <?php if (is_month()) { echo 'Maand: ' . get_the_date('Y F');} ?>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
            <?php get_search_form(); ?>
            </br>
        </article>
    <?php 
    while(have_posts()) : the_post(); ?>
        <article class="post">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <small><?php the_time('F jS, Y'); ?></small>
            <?php the_excerpt(); ?>
        </article>
    <?php endwhile; ?>
<?php get_footer(); ?>