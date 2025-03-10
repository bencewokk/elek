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
            <a href="<?php echo wp_logout_url(home_url()); ?>" class="login-link">Kijelentkezés</a>
        <?php else: ?>
            <a href="<?php echo esc_url(home_url('/belepes')); ?>" class="login-link">Bejelentkezés</a>
            <a href="<?php echo esc_url(home_url('/regisztracio')); ?>" class="register-link">Regisztráció</a>
        <?php endif; ?>
    </div>
</header>