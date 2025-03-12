<?php
/*
Template Name: Login Form
*/
get_header(); ?>

<h1 class="auth-title"><?php _e('Log In to Your Account'); ?></h1>

<main class="auth-page">
    <?php
    // Check for any errors or messages
    if (isset($_GET['login']) && $_GET['login'] == 'failed') {
        echo '<div class="error">Invalid username or password. Please try again.</div>';
    } elseif (isset($_GET['password']) && $_GET['password'] == 'reset') {
        echo '<div class="success">Password reset link has been sent to your email.</div>';
    }
    
    $args = array(
        'echo'           => true,
        'remember'       => true,
        'redirect'       => home_url('/'),
        'form_id'        => 'loginform',
        'label_username' => __('Username or Email'),
        'label_password' => __('Password'),
        'label_remember' => __('Remember Me'),
        'label_log_in'   => __('Log In'),
        'value_username' => '',
        'value_remember' => false
    );
    wp_login_form($args); 
    ?>
    
    <div class="auth-links">
        <a href="<?php echo wp_registration_url(); ?>">Create an account</a>
        <a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
    </div>
</main>

<?php get_footer(); ?>