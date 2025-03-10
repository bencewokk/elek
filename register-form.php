<?php
/*
Template Name: Register Form
*/
get_header(); ?>

<main class="auth-page">
    <div class="auth-container">
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
                <label for="username">Username<br>
                <input type="text" name="username" id="username" class="input" 
                    value="<?php echo esc_attr($username); ?>" 
                    required="required" 
                    size="20">
                </label>
            </p>
            
            <p>
                <label for="email">Email<br>
                <input type="email" name="email" id="email" class="input" 
                    value="<?php echo esc_attr($email); ?>" 
                    required="required" 
                    size="20">
                </label>
            </p>
            
            <p>
                <label for="password">Password<br>
                <input type="password" name="password" id="password" class="input" 
                    required="required" 
                    size="20">
                </label>
            </p>
            
            <?php wp_nonce_field('register_action', 'register_nonce'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Register">
        </form>
        
        <div class="auth-links">
            Already have an account? <a href="<?php echo wp_login_url(); ?>">Login here</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>