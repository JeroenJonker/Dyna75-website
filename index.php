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
                    <a href="<?php the_permalink(); ?>">
                    <div>
                    <h2> <?php the_title(); ?></h2>
<!--<div id="post" class="first-article" style="background-image: url('<?php echo $thumb['0'];?>')">                -->
                    <img src="<?php echo $thumb['0']; ?>"/>

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
        <?php
        $query = new WP_Query( array('category_name' => 'sponsoren', 'posts_per_page' => '1')); ?>
        <article class="carousel sponsor post">
            <ul class="panest">
                <?php
                    if ( $query->have_posts()) { 
                while ($query->have_posts()) {
                    $query->the_post(); ?>
                             <?php $images = get_attached_media('image', $post->ID);
                    foreach($images as $image)
                    {
                        $imagesrc = wp_get_attachment_image_src( $image->ID,'full'); // returns an array
                        echo '<li><img class="sponsorlogo" src="' . $imagesrc[0] . '" /></li>';
                    }   
                }
            } else { echo 'error! not enough sponsoren';} ?>
            </ul>
        </article>
    </div> <?php wp_reset_postdata(); ?>


<?php
/* Agenda */
$posts = get_posts(array(
    'category_name' => 'agenda',
//	'post_type'	=> 'post',
	'meta_key'	=> 'datum',
	'orderby'	=> 'meta_value_num',
	'order'		=> 'ASC'
));

$thisday = mysql2date("Ymd", $post->post_date_gmt); 
$bool = true; ?>
<article class="post announcement agenda">
    <h2> Agenda </h2>
    <div class="content"> <?php
if( $posts ) {
	
	foreach( $posts as $post ) {
		
		setup_postdata( $post );

		$enddate = get_field('datum', false, false);
        if ($enddate >= $thisday)
        {
            if ($bool)
            {
                $bool = false;
                echo '<ul class="agendaPunt">';
            }
            $enddate = new DateTime($enddate);

            ?> <li> <?php echo $enddate->format('j M');?>: <?php the_title(); ?></li> <?php
        }

	}
	wp_reset_postdata();
} 
    if (!$bool)
    {
        echo '</ul>';
    }?>
    </div>
    <div class="extra">
        <small>
            <?php echo date_i18n('j F Y', time()); ?>
            &nbsp;
        </small>
    </div>
</article>

<!--Twitterfeed-->
<article class="post announcement agenda" id="twitterfeed">
            <a class="twitter-timeline"  href="https://twitter.com/bvdyna" data-widget-id="353499231585193984">Tweets door @bvdyna</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </article>  
</div> <?php

/* de rest van de posts */
$counter = 0;
$query = new WP_Query( array('category_name' => 'Uncategorized', 'posts_per_page' => '5'));
if( $query->have_posts()) : ?>
    <?php while($query->have_posts()) {
        $query->the_post(); ?>
        <?php if(!in_category('hoofdnieuws') && !in_category('agenda') && !in_category('sponsoren'))
        { ?>
            <article class="auto post <?php if(has_post_thumbnail()) { ?> has-thumbnail <?php } ?>">
                <div class="post-thumbnail">
                    <a href= "<?php the_permalink(); ?>"> <?php the_post_thumbnail('banner-image'); ?> </a>
                </div>
                <div class="content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
                <div class="extra">
                    <small>
                        <?php the_time('j F, Y'); ?>
                        &nbsp;
                    </small>
                    <small class="right">
                        <a href="<?php echo get_permalink(); ?>"> Meer lezen...</a>
                    </small>
                </div>
            </article>
        <?php $counter++; 
        if($counter == 2)
        {
            $pizza = new WP_Query( array('category_name' => 'video', 'posts_per_page' => '2')); 
            if ( $pizza->have_posts())
            {
                ?><article class="verzinmaarwat"><?php
                while ($pizza->have_posts()) 
                {
                    $pizza->the_post(); 
                    the_content();
                }
                ?></article><?php
            }
        } ?>
        <?php }; 
} 
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
