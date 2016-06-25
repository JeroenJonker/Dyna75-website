<?php

get_header();

/* Slideshow hoofdnieuws */
$query = new WP_Query( array('category_name' => 'hoofdnieuws', 'posts_per_page' => '5')); 
if ( $query->have_posts()) { ?>
    <article class="carousel post" id="hoofdnieuws">
        <ul class=panes>
            <?php while ( $query->have_posts()) { 
                $query->the_post();
            echo $counter; ?>
                <li>
                    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'hoofdnieuws-image' );?>
                    <div>
                    <a href="<?php the_permalink(); ?>">
<!--<div id="post" class="first-article" style="background-image: url('<?php echo $thumb['0'];?>')">                -->
                    <img src="<?php echo $thumb['0']; ?>"/>

                    <h2 class="testcase"><?php the_title(); ?></h2>
                    <!--?php the_content('Verder lezen &raquo;'); ?-->

                    </div></a>
                </li>
            <?php }  ?>   
        </ul>
    </article>
<?php } else { echo 'error! not enough hoofdnieuws';} 
wp_reset_postdata();
?>
<div class="right-column">
    <!-- Tablet fromaat linkerkant -->
    <div class="right-column-tablet">
            <!-- wedstrijden U18 vrouwen en Rolstoelbasketbal -->
            <article class="post announcement wedstrijd">
                <div class="content">
                <h2>Wedstrijden</h2>
                <p>
                <?
                (int)$no_games = 0;
                    // Vrouwen U18 
                $plg_ID = 11897;  
                $cmp_ID = 1707;  
                $org_ID = 5;  // van NBB
                $wedstrijd = new Wedstrijd( $org_ID, $cmp_ID );
                $wedstrijd->teamid( $plg_ID );
                $wedstrijd->seizoen();  // hoeft niet, als je geen seizoen opgeeft, wordt het het huidig
                $wedstrijd->filter_schema( 7 );
                list($nr, $naam) = $wedstrijd->competitie();

                $overzicht = $wedstrijd->overzicht();

                $wedstrijd_lijst = $wedstrijd->wedstrijden($cmp_ID);
                // alle wedstrijden tonen
                if (count($wedstrijd_lijst) <= 0)
                {
                    $no_games++;
                    //print "geen wedstrijden gepland.";
                }
                else 
                {
                    print "<h2>$naam</h2>\n";
                    foreach ($wedstrijd_lijst as $id => $details ) 
                    {
                        print  $details['thuisclub'] . ' - ' .$details['thuisteamafko']; ?> </br> <?php
                        print  $details['datum'] . '   ' .$details['tijd']; ?> </br> <?php
                        print  $details['locatie']; ?> </br> <?php
                    }
                }
                ?> 
                </p>
                <p>
                <?php    
                // Rolstoel basketbal             
                $plg_ID = 3892;  
                $cmp_ID = 1508;  
                $org_ID = 0;  // van NBB
                $wedstrijd = new Wedstrijd( $org_ID, $cmp_ID );
                $wedstrijd->teamid( $plg_ID );
                $wedstrijd->seizoen();  // hoeft niet, als je geen seizoen opgeeft, wordt het het huidig
                $wedstrijd->filter_schema( 7 );
                list($nr, $naam) = $wedstrijd->competitie();

                $overzicht = $wedstrijd->overzicht();

                $wedstrijd_lijst = $wedstrijd->wedstrijden($cmp_ID);
                // alle wedstrijden tonen
                if (count($wedstrijd_lijst) <= 0)
                {
                    $no_games++;
                    //print "geen wedstrijden gepland.";
                }
                else 
                {
                    print "<h2>$naam</h2>\n";
                    foreach ($wedstrijd_lijst as $id => $details ) 
                    {
                        print  $details['thuisclub'] . ' - ' .$details['thuisteamafko']; ?> </br> <?php
                        print  $details['datum'] . '   ' .$details['tijd']; ?> </br> <?php
                        print  $details['locatie']; ?> </br> <?php
                    }
                }
                if ($no_games == 2)
                {
                    echo nl2br ("Geen wedstrijden gepland voor:\n Vrouwen u18 en Rolstoellers 1");
                }
                ?> 
                </p>
                 </div>
                 <div class="extra">
                    <small>
                        <a href="<?php bloginfo('url'); ?>/wedstrijden">Meer Wedstrijden...</a>
                        <!--?php the_time('F jS, Y'); ?-->
                        &nbsp;
                    </small>
                </div>
            </article> 

<!--sponsoren -->
<article class="carousel sponsor post">
    <ul class="panest">
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor1.jpg" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor2.jpg" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor3.png" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor4.jpg" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor5.jpg" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor6.png" alt="logo" />
        </li>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/IMG/Sponsor7.png" alt="logo" />
        </li>
    </ul>
</article>
</div>

<?php
/* Agenda */
$query = new WP_Query( array('category_name' => 'agenda', 'posts_per_page' => '1')); 
if ( $query->have_posts()) { 
    while ($query->have_posts()) {
        $query->the_post(); ?>
             <article class="post announcement agenda">
                 <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                 <div class="content">
                     <?php the_content(); ?>
                 </div>
                 <div class="extra">
                    <small>
                        <?php the_time('F jS, Y'); ?>
                        &nbsp;
                    </small>
                </div>
            </article> <?php
    }
} else { echo 'error! not enough agenda';} 
wp_reset_postdata();
?> </div> <?php

/* de rest van de posts */
$query = new WP_Query( array('category_name' => 'Uncategorized', 'posts_per_page' => '5'));
if( $query->have_posts()) : ?>
    <?php while($query->have_posts()) {
        $query->the_post(); ?>
        <?php if(!in_category('hoofdnieuws') && !in_category('agenda')) : ?>
            <article class="auto post <?php if(has_post_thumbnail()) { ?> has-thumbnail <?php } ?>">
                <div class="post-thumbnail">
                    <a href= "<?php the_permalink(); ?>"> <?php the_post_thumbnail('banner-image'); ?> </a>
                </div>
                <div class="content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
                <div class="extra">
                    <small>
                        <?php the_time('F j, Y'); ?>
                        &nbsp;
                    </small>
                    <small class="right">
                        <a href="<?php echo get_permalink(); ?>"> Meer lezen...</a>
                    </small>
                </div>
            </article>
        <?php endif; 
} ?>
    <?php else : 
        echo '<p> No content </p>';
    endif;
get_footer();
?>

<!--

//$clb_ID = 132;  // B.A.S. basketball, ISS 3109
//$org_ID = 5;  // rayon oost
//$wedstrijd = new Wedstrijd( $org_ID );
//$wedstrijd->club(5112);   // ISS nr van BAS basketball
//// bovenstaand kan ook met $wedstrijd->clubid( 132 );
//$wedstrijd->alleen_club_gegevens();
//$overzicht = $wedstrijd->overzicht();
//#print_r($overzicht);
//
//print "<TABLE>\n";
//
//foreach ($overzicht as $cmp_ID => $data ) {
//
//    print "<TR><TD colspan='8'>" . $data['nummer'] ." - " . $data['naam'] ."</TD></TR>\n";
//    $wedstrijd_lijst = $data['wedstrijden'];
//
//    foreach ($wedstrijd_lijst as $id => $details ) {
//	    print "<TR>";
//	    print "<TD>" . $details['nummer'] ."</TD>";
//	    print "<TD>" . $details['datum'] ."</TD>";
//	    print "<TD>" . $details['tijd'] ."</TD>";
//	    print "<TD>" . $details['thuisclub'] . ' ' .$details['thuisteamafko'] ."</TD>";
//	    print "<TD>" . $details['uitclub'] . ' ' .$details['uitteamafko'] ."</TD>";
//	    print "<TD>" . $details['scorethuis'] . ' - ' . $details['scoreuit'] ."</TD>";
//	    print "<TD>" . $details['locatie'] ."</TD>";
//	    print "<TD>" . $details['plaats'] ."</TD>";
//	    print "</TR>\n";
//    }
//}
//print "</TABLE>\n\n";


//include("class.team.php");

//$clb_ID = 327;
//$teams = new Team( $clb_ID );
//$lijst = $teams->overzicht();
//#$xml = $teams->xml();
//#print "raw xml:\n$xml\n\n";
//#print_r($lijst);

//foreach ($lijst as $id => $team) {
//    print "scm_ID : $id\n";
//    print "Naam   : " . $team['naam'] ."\n";
//    print "Afkorting: " . $team['afkorting'] ."\n";
//    print "Team id: " . $team['team_id'] ."\n";
//    print "Club id: " . $team['club_id'] ."\n";
//    print "Competitie: " . $team['competitie'] ."\n";
//    print "Competitie id: " . $team['comp_id'] ."\n";
//    print "Competitie nr: " . $team['comp_nr'] ."\n";

//}

//$plg_ID = 11897;  // Wildcats M16 
//$cmp_ID = 1707;  
//$org_ID = 5;  // van NBB
//$wedstrijd = new Wedstrijd( $org_ID, $cmp_ID );
//$wedstrijd->teamid( $plg_ID );
//$wedstrijd->seizoen();  // hoeft niet, als je geen seizoen opgeeft, wordt het het huidig
//
//list($nr, $naam) = $wedstrijd->competitie();
//print "<TABLE>\n";
//print "<TR><TD colspan=6>$nr - $naam</TD></TR>\n";
//$overzicht = $wedstrijd->overzicht();
////print_r($overzicht);
//$wedstrijd_lijst = $wedstrijd->wedstrijden($cmp_ID);
//
//// alle wedstrijden tonen
//foreach ($wedstrijd_lijst as $id => $details ) {
//	print "<TR>";
//	print "<TD>" . $details['nummer'] ."</TD>";
//	print "<TD>" . $details['datum'] ."</TD>";
//	print "<TD>" . $details['tijd'] ."</TD>";
//	print "<TD>" . $details['thuisclub'] . ' ' .$details['thuisteamafko'] ."</TD>";
//	print "<TD>" . $details['uitclub'] . ' ' .$details['uitteamafko'] ."</TD>";
//	print "<TD>" . $details['scorethuis'] . ' - ' . $details['scoreuit'] ."</TD>";
//	print "<TD>Shirts: " . $details['thuisteamshirt'] . ' - ' . $details['uitteamshirt'] ."</TD>";
//	print "<TD>" . $details['loc_id'] ."</TD>";
//	print "<TD>" . $details['locatie'] ."</TD>";
//	print "<TD>" . $details['adres'] ."</TD>";
//	print "<TD>" . $details['postcode'] ."</TD>";
//	print "<TD>" . $details['plaats'] ."</TD>";
//
//	print "</TR>\n";
//}
//
//print "</TABLE>\n\n";


//$cmp_ID = 1707;  // heren promotie divisie B2000
//$org_ID = 5;  // van NBB
//$wedstrijd = new Wedstrijd( $org_ID, $cmp_ID );
//list($nr, $naam) = $wedstrijd->competitie();
//print "<TABLE>\n";
//print "<TR><TD colspan=6>$nr - $naam</TD></TR>\n";
//$overzicht = $wedstrijd->overzicht();
////print_r($overzicht);
//$wedstrijd_lijst = $wedstrijd->wedstrijden($cmp_ID);
//
//// en de hele ranglijst aflopen
//foreach ($wedstrijd_lijst as $id => $details ) {
//	print "<TR>";
//	print "<TD>" . $details['nummer'] ."</TD>";
//	print "<TD>" . $details['datum'] ."</TD>";
//	print "<TD>" . $details['tijd'] ."</TD>";
//	print "<TD>" . $details['thuisclub'] . ' ' .$details['thuisteamafko'] ."</TD>";
//	print "<TD>" . $details['uitclub'] . ' ' .$details['uitteamafko'] ."</TD>";
//	print "<TD>" . $details['scorethuis'] . ' - ' . $details['scoreuit'] ."</TD>";
//
//	print "</TR>\n";
//}

//print "</TABLE>\n\n";
-->
