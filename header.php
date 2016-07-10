<!DOCTYPE html>
<?php 
include("class.nbb.php");
include("class.competitie.php");
include("class.wedstrijd.php");
include("class.team.php");
?>
<html <?php language_attributes() ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <title> <?php bloginfo('name'); ?></title>
        <?php wp_head() ?>
    </head>
    <link href='https://fonts.googleapis.com/css?family=Hind:600' rel='stylesheet' type='text/css'>
    <body <?php body_class(); ?>>
        <div class="white-block">     
            <div class="social-buttons">
                <!-- twitter -->
                <a href="https://twitter.com/bvdyna" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow                         @bvdyna</a>
                <script>
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id))                      {js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}
                    (document,'script','twitter-wjs');
                </script>

                <!-- facebook -->
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.5";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                </script>
                <div class="fb-follow" data-href="https://www.facebook.com/BasketbalverenigingDyna75" data-layout="button" data-show-faces="true">                      </div>
            </div>
        </div>

            <header class="site-header">
                <!--<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
                <h5><?php bloginfo('description'); ?></h5>-->
                
                <nav class="site-nav">
                    <!-- logo -->
                    <a href="<?php echo get_option('home'); ?>"> 
                        <img class="logo" src="<?php bloginfo('template_directory'); ?>/IMG/Logo.png" alt="logo" />
                    </a>
                    <?php
                    $args = array(
                        'theme_location' => 'primary');
                    ?>
                    <?php wp_nav_menu( $args ); ?>
                    <div id="menu-mobile">
                        <!-- -->
                        <!--a href="#menu" class="box-shadow-menu">
                           
                        </a--> 
                        <li id="menu"><a href="#">Menu</a></li>
                        </div>
                        <?php wp_nav_menu( array( 'theme_location' => 'primary mobile', 'menu_class' => 'nav-menu','container_id' => 'cssmenu' ) ); ?>

                </nav>
                
            </header>
      
        <div class="container">
