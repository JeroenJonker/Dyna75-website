        </div>
        <footer class="site-footer">
            <div class="footer-box">
                <h3>Links</h3>
                <nav class="site-nav">
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
                <p>Ga naar de volgende documenten om aan te melden <a href=" http://www.dyna75.nl/contributie-dyna-75/">hier</a>.</p>
            </div>
            <div class="footer-box">
                <h3>Contact</h3>
                <p>Secetariaat Dyna75</p>
                <p>E-mail: secetariaat@Dyna75.nl</p>
            </div>
        </footer>
<p id="websiteInfo">Made by J. Jonker, <?php bloginfo('name'); ?> -  &copy; <?php echo date('Y'); ?></p>
        <?php wp_footer(); ?>

    </body>
</html>