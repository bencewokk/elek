<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="header-container">
        <div class="header-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" 
                    alt="<?php bloginfo('name'); ?> Logo" 
                    class="site-logo">
            </a>
            <h1 class="site-title">amigeleken.hu</h1>
        </div>

        <div class="auth-container">
            <?php if (is_user_logged_in()): ?>
                <?php $current_user = wp_get_current_user(); ?>
                <span class="user-name">Bejelentkezve: <?php echo esc_html($current_user->display_name); ?></span>
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="login-link">Kijelentkezés</a>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/belepes')); ?>" class="login-link">Bejelentkezés</a>
                <a href="<?php echo esc_url(home_url('/regisztracio')); ?>" class="register-link">Regisztráció</a>
            <?php endif; ?>
        </div>
    </div>
<!--     
    <nav class="lower-nav">
        <div class="nav-container">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?php echo esc_url(home_url('/galeria')); ?>" class="nav-link">Galéria</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo esc_url(home_url('/szponzorok')); ?>" class="nav-link">Szponzorok</a>
                </li>
            </ul>
        </div>
    </nav> -->
</header>

<?php wp_footer(); ?>
</body>
</html>