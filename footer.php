        </div>
        <footer class="site-footer">
            <div class="footer-box">
                <nav class="site-nav">
                    <?php
                    	$args = array(
                        'theme_location' => 'footer');
                    ?>
                    <?php wp_nav_menu( $args ); ?>
                </nav>
            </div>
            <div class="footer-box">
            </div>
            <div class="footer-box">
            </div>
            <p><?php bloginfo('name'); ?> - &copy; <?php echo date('Y'); ?></p>
        </footer>

        <?php wp_footer(); ?>

    </body>
</html>