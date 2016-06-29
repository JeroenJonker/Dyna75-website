<?php
/*
Template Name: Wedstrijden
*/
get_header(); ?>
<article class="post page"> <?php
if(have_posts()) : 
    while(have_posts()) : the_post(); ?>
        
        <?php 
        
        if (has_children() OR $post->post_parent > 0) { ?>
        
        <nav class="site-subnav children-links clearfix">
            
            <span class="parent-link"><a href="<?php print get_the_permalink(get_top_ancestor_id()); ?>"><?php print get_the_title(get_top_ancestor_id()); ?></a></span>
            
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
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>

    <?php endwhile;
    else : 
        echo '<p> No content </p>';
    endif;

$clb_ID = 132;  // B.A.S. basketball, ISS 3109
$org_ID = 5;  // rayon oost
$wedstrijd = new Wedstrijd( $org_ID );
$wedstrijd->club(5112);   // ISS nr van BAS basketball
// bovenstaand kan ook met $wedstrijd->clubid( 132 );
$wedstrijd->alleen_club_gegevens();
$overzicht = $wedstrijd->overzicht();
#print_r($overzicht);

print "<TABLE>\n";

foreach ($overzicht as $cmp_ID => $data ) {

    print "<TR><TD colspan='8' class='table-header'>". $data['naam'] ."</TD></TR>\n";
    $wedstrijd_lijst = $data['wedstrijden'];

    foreach ($wedstrijd_lijst as $id => $details ) {
	    print "<TR class='redstuffall'>";
	    //print "<TD>" . $details['nummer'] ."</TD>";
	    print "<TD>" . $details['datum'] ."</TD>";
	    print "<TD>" . $details['tijd'] ."</TD>";
	    print "<TD>" . $details['thuisclub'] . ' ' .$details['thuisteamafko'] ."</TD>";
	    print "<TD>" . $details['uitclub'] . ' ' .$details['uitteamafko'] ."</TD>";
	    print "<TD>" . $details['scorethuis'] . ' - ' . $details['scoreuit'] ."</TD>";
	    print "<TD>" . $details['locatie'] ."</TD>";
	    print "<TD>" . $details['plaats'] ."</TD>";
	    print "</TR>\n";
    }
    print "<tr class='blank_row'><td colspan='3'></td></tr>";

}
print "</TABLE>\n\n";
?> </div> <?php

get_footer();

?>