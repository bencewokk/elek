<?php get_header(); ?>

<main class="main-content">
    <div class="content-grid">
        <section class="post-list">
            <!-- Promotional Ad -->
            <div class="promo-ad">
                <a href="https://www.mcdonalds.com/hu/hu-hu/Ajanlatok/maestro-goosey-gustav.html" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/landing_meki.jpg" alt="McDonald's Special Offer" class="ad-image">
                </a>
            </div>

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="post-card">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-content">
                            <?php the_excerpt(); ?>
                        </div>
                        <div class="post-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-posts">
                    <p>No posts found.</p>
                </div>
            <?php endif; ?>
        </section>
        
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>