<?php
// Enqueue stylesheets and scripts
function elek_enqueue_styles() {
    wp_enqueue_style( 'elek-layout', get_template_directory_uri() . '/assets/css/layout.css' );
    wp_enqueue_style( 'elek-link', get_template_directory_uri() . '/assets/css/links.css' );

    wp_enqueue_style( 'elek-auth', get_template_directory_uri() . '/assets/css/auth.css' );


    wp_enqueue_style( 'elek-style', get_stylesheet_uri() );
    wp_enqueue_style( 'elek-footer', get_template_directory_uri() . '/assets/css/footer.css' );
    
    wp_enqueue_style( 'elek-header', get_template_directory_uri() . '/assets/css/header.css' );
    wp_enqueue_style( 'elek-lowernav', get_template_directory_uri() . '/assets/css/lowernav.css' );

    wp_enqueue_style( 'elek-sidebar', get_template_directory_uri() . '/assets/css/sidebar.css' );
    wp_enqueue_style( 'elek-calendar', get_template_directory_uri() . '/assets/css/calendar.css' );
    wp_enqueue_style( 'elek-highlight', get_template_directory_uri() . '/assets/css/highlight.css' );


    wp_enqueue_style( 'elek-promo', get_template_directory_uri() . '/assets/css/promo.css' );
    wp_enqueue_style( 'elek-sidebar_promo', get_template_directory_uri() . '/assets/css/sidebar_promo.css' );

    wp_enqueue_style( 'elek-articles', get_template_directory_uri() . '/assets/css/articles.css' );
    wp_enqueue_style( 'elek-comments', get_template_directory_uri() . '/assets/css/comments.css' );


    // Enqueue Google Fonts
    wp_enqueue_style( 'google-fonts-roboto-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'elek_enqueue_styles' );

function elek_theme_setup() {
    add_theme_support('post-thumbnails'); // Enable support for featured images
}
add_action('after_setup_theme', 'elek_theme_setup');


function theme_enqueue_scripts() {
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . 'assets/js/menu.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Handle login redirects
add_action('login_form_login', 'custom_login_redirect');
function custom_login_redirect() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = wp_signon();
        
        if (!is_wp_error($user)) {
            wp_redirect(home_url());
            exit;
        }
    }
}

// Handle registration
add_action('login_form_register', 'custom_register_redirect');
function custom_register_redirect() {
    if (!empty($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $user_data = array(
            'user_login' => sanitize_user($_POST['username']),
            'user_email' => sanitize_email($_POST['email']),
            'user_pass'  => $_POST['password']
        );
        
        $user_id = wp_insert_user($user_data);
        
        if (!is_wp_error($user_id)) {
            wp_signon(array(
                'user_login' => $user_data['user_login'],
                'user_password' => $user_data['user_pass']
            ));
            wp_redirect(home_url());
            exit;
        }
    }
}

function theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'textdomain'),
        'id'            => 'primary-sidebar',
        'description'   => __('Add widgets here to appear in your sidebar.', 'textdomain'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'theme_widgets_init');