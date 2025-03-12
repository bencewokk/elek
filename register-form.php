<?php
/*
Template Name: Register Form
*/
get_header(); ?>

<h1 class="auth-title"><?php _e('Create an Account'); ?></h1>

<main class="auth-page">
    <?php
    // Initialize variables
    $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $error = '';
    
    // Handle form submission
    if (isset($_POST['submit']) && isset($_POST['register_nonce'])) {
        if (wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
            $user_id = wp_create_user($username, $password, $email);
            
            if (is_wp_error($user_id)) {
                $error = $user_id->get_error_message();
            } else {
                echo '<div class="success">Registration successful. You can now <a href="'.wp_login_url().'">login</a>.</div>';
            }
        }
    }
    ?>

    <?php if (!empty($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form id="registerform" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="input" 
                value="<?php echo esc_attr($username); ?>" 
                required="required" 
                size="20">
        </p>
        
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="input" 
                value="<?php echo esc_attr($email); ?>" 
                required="required" 
                size="20">
        </p>
        
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="input" 
                required="required" 
                size="20">
        </p>
        
        <div id="pass-strength-result" class="hide-if-no-js" aria-live="polite"><?php _e('Strength indicator'); ?></div>
        <p class="description indicator-hint"><?php _e('Hint: The password should be at least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).'); ?></p>
        
        <?php wp_nonce_field('register_action', 'register_nonce'); ?>
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Register">
    </form>
    
    <div class="auth-links">
        <a href="<?php echo wp_login_url(); ?>">Already have an account? Log in</a>
    </div>
</main>

<?php 
// Properly enqueue the password strength meter scripts
wp_enqueue_script('user-profile');

// Get footer which will output the scripts
get_footer(); 
?>

<script>
jQuery(document).ready(function($) {
    // Password strength meter
    $('#password').on('keyup', function() {
        var pass1 = $(this).val();
        var result = $('#pass-strength-result');
        
        result.removeClass('short bad good strong');
        if (!pass1) {
            result.html('<?php _e("Strength indicator"); ?>');
            return;
        }
        
        // The third parameter should be an empty array, not pass1
        var strength = wp.passwordStrength.meter(pass1, [], '');
        
        switch (strength) {
            case 0: // Empty
            case 1: // Very Weak
                result.addClass('short').html('<?php _e("Very weak"); ?>');
                break;
            case 2: // Weak
                result.addClass('bad').html('<?php _e("Weak"); ?>');
                break;
            case 3: // Medium
                result.addClass('good').html('<?php _e("Medium"); ?>');
                break;
            case 4: // Strong
                result.addClass('strong').html('<?php _e("Strong"); ?>');
                break;
            default:
                result.addClass('short').html('<?php _e("Very weak"); ?>');
        }
    });
});
</script>