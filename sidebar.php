<aside class="sidebar">
    <?php if (is_active_sidebar('primary-sidebar')) : ?>
        <?php dynamic_sidebar('primary-sidebar'); ?>
    <?php else : ?>
        <!-- Default sidebar content -->
        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e('Categories', 'textdomain'); ?></h3>
            <ul>
                <?php wp_list_categories(array(
                    'title_li' => '',
                    'show_count' => true
                )); ?>
            </ul>
        </div>

        <!-- Pizza Ad -->
        <div class="widget ad-widget">
            <a href="https://www.avaspizza.hu/rendeles?gad_source=1&gclid=Cj0KCQiAwtu9BhC8ARIsAI9JHalHC93ztSbc5IVpq-cN4a1Tj0xkTYeAqUDOg7LsCZmDcgAPtmOiL08aArb5EALw_wcB" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pizza.png" alt="Avás Pizza" class="sidebar-ad">
            </a>
        </div>

        <!-- Tippmix Ad -->
        <div class="widget ad-widget">
            <a href="https://www.tippmixpro.hu/hu/partnerhalozat/20250210/amigelek?btag=83555084_426853" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tippmix.png" alt="Tippmix" class="sidebar-ad">
            </a>
        </div>

        <!-- Calendar Widget -->
        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e('Calendar', 'textdomain'); ?></h3>
            <?php get_calendar(); ?>
        </div>
    <?php endif; ?>
</aside>