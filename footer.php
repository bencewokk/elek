<footer class="site-footer">
        <div class="footer-container">
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'textdomain'); ?>
                </p>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>