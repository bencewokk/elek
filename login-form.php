<?php
/*
Template Name: Login Form
*/
get_header(); ?>

<main class="auth-page">
    <div class="auth-container">
        <?php
        $args = array(
            'echo'           => true,
            'remember'       => true,
            'redirect'       => home_url('/'),
            'form_id'        => 'loginform',
            'label_username' => __('Username'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in'   => __('Log In'),
            'value_username' => '',
            'value_remember' => false
        );
        wp_login_form($args); 
        ?>
        
        <div class="auth-links">
            <a href="<?php echo wp_registration_url(); ?>">Register</a> | 
            <a href="<?php echo wp_lostpassword_url(); ?>">Lost Password?</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>