        </div>
        <footer class="site-footer">
            <div class="footer-box">
                <h3>Links</h3>
                <nav>
                    <?php
                    	$args = array(
                        'theme_location' => 'footer');
                    ?>
                    <?php wp_nav_menu( $args ); ?>
                </nav>
            </div>
            <div class="footer-box">
                <h3>Lid Worden?</h3>
                <P>Zin in basketball? Je kunt gratis 3x proeftrainen.</P>
                <p>Klik <a href=" http://www.dyna75.nl/contributie-dyna-75/">hier</a> om je aan te melden voor het proeftrainen.</p>
            </div>
            <div class="footer-box">
                <h3>Contact</h3>
                <p>Secretariaat Dyna75</p>
                <p>E-mail: secretariaat@Dyna75.nl</p>
            </div>
        </footer>
        <div id="websiteInfo">
        <small>Made by J. Jonker, <?php bloginfo('name'); ?> -  &copy; <?php echo date('Y'); ?></small>
                <?php wp_footer(); ?>
        </div>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/javascript.js"></script>
    </body>
</html>