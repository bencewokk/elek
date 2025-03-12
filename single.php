<?php get_header(); ?>

<main class="main-content">
    <div class="content-grid">
        <article class="single-post">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        <span class="comments-link">
                            <a href="#comments">
                                <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                            </a>
                        </span>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>

                            
            <!-- Comments Section -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <section class="comments-section">
                    <div class="container">
                        <h3 class="comments-title">
                            <?php
                            printf(
                                _nx('One thought on "%2$s"', '%1$s thoughts on "%2$s"', get_comments_number(), 'comments title'),
                                number_format_i18n(get_comments_number()),
                                get_the_title()
                            );
                            ?>
                        </h3>
                        <?php comments_template(); ?>
                    </div>
                </section>
            <?php endif; ?>

        </article>


        
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>