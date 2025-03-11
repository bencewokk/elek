<?php
// Enqueue stylesheets and scripts
function elek_enqueue_styles() {
    wp_enqueue_style( 'elek-layout', get_template_directory_uri() . '/assets/css/layout.css' );
    wp_enqueue_style( 'elek-link', get_template_directory_uri() . '/assets/css/links.css' );

    wp_enqueue_style( 'elek-style', get_stylesheet_uri() );
    wp_enqueue_style( 'elek-footer', get_template_directory_uri() . '/assets/css/footer.css' );
    wp_enqueue_style( 'elek-header', get_template_directory_uri() . '/assets/css/header.css' );
    wp_enqueue_style( 'elek-sidebar', get_template_directory_uri() . '/assets/css/sidebar.css' );
    wp_enqueue_style( 'elek-calendar', get_template_directory_uri() . '/assets/css/calendar.css' );


    wp_enqueue_style( 'elek-promo', get_template_directory_uri() . '/assets/css/promo.css' );
    wp_enqueue_style( 'elek-sidebar_promo', get_template_directory_uri() . '/assets/css/sidebar_promo.css' );

    wp_enqueue_style( 'elek-articles', get_template_directory_uri() . '/assets/css/articles.css' );


    // Enqueue Google Fonts
    wp_enqueue_style( 'google-fonts-roboto-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'elek_enqueue_styles' );

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

function register_match_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Matches',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-calendar-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'matches'),
    );
    register_post_type('match', $args);
}
add_action('init', 'register_match_post_type');

function add_match_meta_boxes() {
    add_meta_box(
        'match_details',
        'Match Details',
        'match_details_callback',
        'match',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_match_meta_boxes');

function match_details_callback($post) {
    wp_nonce_field(basename(__FILE__), 'match_details_nonce');
    
    $match_date = get_post_meta($post->ID, '_match_date', true);
    $team_a = get_post_meta($post->ID, '_team_a', true);
    $team_b = get_post_meta($post->ID, '_team_b', true);
    $team_a_logo = get_post_meta($post->ID, '_team_a_logo', true);
    $team_b_logo = get_post_meta($post->ID, '_team_b_logo', true);
    
    echo '<p>Match Date: <input type="date" name="match_date" value="' . esc_attr($match_date) . '" /></p>';
    echo '<p>Team A: <input type="text" name="team_a" value="' . esc_attr($team_a) . '" /></p>';
    echo '<p>Team B: <input type="text" name="team_b" value="' . esc_attr($team_b) . '" /></p>';
    echo '<p>Team A Logo ID: <input type="text" name="team_a_logo" value="' . esc_attr($team_a_logo) . '" /> (Add media and input attachment ID)</p>';
    echo '<p>Team B Logo ID: <input type="text" name="team_b_logo" value="' . esc_attr($team_b_logo) . '" /> (Add media and input attachment ID)</p>';
}

function save_match_meta($post_id) {
    if (!isset($_POST['match_details_nonce']) || !wp_verify_nonce($_POST['match_details_nonce'], basename(__FILE__)))
        return $post_id;
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    
    if (!current_user_can('edit_post', $post_id))
        return $post_id;
    
    $match_date = isset($_POST['match_date']) ? sanitize_text_field($_POST['match_date']) : '';
    $team_a = isset($_POST['team_a']) ? sanitize_text_field($_POST['team_a']) : '';
    $team_b = isset($_POST['team_b']) ? sanitize_text_field($_POST['team_b']) : '';
    $team_a_logo = isset($_POST['team_a_logo']) ? intval($_POST['team_a_logo']) : '';
    $team_b_logo = isset($_POST['team_b_logo']) ? intval($_POST['team_b_logo']) : '';
    
    update_post_meta($post_id, '_match_date', $match_date);
    update_post_meta($post_id, '_team_a', $team_a);
    update_post_meta($post_id, '_team_b', $team_b);
    update_post_meta($post_id, '_team_a_logo', $team_a_logo);
    update_post_meta($post_id, '_team_b_logo', $team_b_logo);
}
add_action('save_post', 'save_match_meta');

function custom_calendar_day_cell($day_cell, $day, $month, $year) {
    // Find matches for this day
    $args = array(
        'post_type' => 'match',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_match_date',
                'value' => date('Y-m-d', strtotime("$year-$month-$day")),
                'compare' => '=',
            )
        )
    );
    
    $matches = new WP_Query($args);
    
    if ($matches->have_posts()) {
        $match_html = '';
        while ($matches->have_posts()) {
            $matches->the_post();
            $team_a = get_post_meta(get_the_ID(), '_team_a', true);
            $team_b = get_post_meta(get_the_ID(), '_team_b', true);
            $team_a_logo_id = get_post_meta(get_the_ID(), '_team_a_logo', true);
            $team_b_logo_id = get_post_meta(get_the_ID(), '_team_b_logo', true);
            
            // Get the logo URLs
            $team_a_logo = wp_get_attachment_image_url($team_a_logo_id, 'thumbnail');
            $team_b_logo = wp_get_attachment_image_url($team_b_logo_id, 'thumbnail');
            
            $match_html .= '<div class="match-item" data-match-id="' . get_the_ID() . '">';
            $match_html .= '<div class="match-logo-container">';
            if ($team_a_logo) {
                $match_html .= '<div class="half-logo team-a"><img src="' . esc_url($team_a_logo) . '" alt="' . esc_attr($team_a) . '"></div>';
            }
            if ($team_b_logo) {
                $match_html .= '<div class="half-logo team-b"><img src="' . esc_url($team_b_logo) . '" alt="' . esc_attr($team_b) . '"></div>';
            }
            $match_html .= '</div>';
            $match_html .= '<div class="match-popup">';
            $match_html .= '<h4>' . get_the_title() . '</h4>';
            $match_html .= '<p class="match-teams">' . esc_html($team_a) . ' vs ' . esc_html($team_b) . '</p>';
            $match_html .= '<div class="match-excerpt">' . get_the_excerpt() . '</div>';
            $match_html .= '</div>';
            $match_html .= '</div>';
        }
        wp_reset_postdata();
        
        return str_replace('>$day<', '><span class="has-match">' . $day . '</span>' . $match_html . '<', $day_cell);
    }
    
    return $day_cell;
}
add_filter('calendar_day_cell', 'custom_calendar_day_cell', 10, 4);