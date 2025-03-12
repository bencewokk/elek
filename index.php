<?php get_header(); ?>

<!-- Featured Posts Highlight Section -->
<section class="featured-posts-carousel">
    <div class="container">
        <h2 class="section-title">Latest Updates</h2>
        <div class="carousel-container">
            <?php
            $featured_posts = new WP_Query(array(
                'posts_per_page' => 4,
                'order' => 'DESC',
                'orderby' => 'date'
            ));
            
            if ($featured_posts->have_posts()) :
                $post_count = 0;
                while ($featured_posts->have_posts()) : $featured_posts->the_post();
                $post_count++;
                $active_class = ($post_count === 1) ? 'active' : '';
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $thumbnail_style = $thumbnail_url ? 'style="background-image: url(\'' . esc_url($thumbnail_url) . '\');"' : '';
            ?>
                <div class="carousel-item <?php echo $active_class; ?>" data-slide="<?php echo $post_count; ?>">
                    <div class="featured-post" <?php echo $thumbnail_style; ?>>
                        <div class="overlay">
                            <div class="featured-content">
                                <h3 class="featured-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="featured-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="featured-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <span class="comments-link">
                                        <a href="<?php the_permalink(); ?>#comments">
                                            <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
            
            <!-- Navigation Controls -->
            <div class="carousel-controls">
                <button class="carousel-prev" aria-label="Previous post">&lsaquo;</button>
                <div class="carousel-indicators">
                    <?php for ($i = 1; $i <= $post_count; $i++) : ?>
                        <span class="indicator <?php echo ($i === 1) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
                    <?php endfor; ?>
                </div>
                <button class="carousel-next" aria-label="Next post">&rsaquo;</button>
            </div>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="content-grid">
        <section class="post-list">
            <!-- Promotional Ad -->
            <div class="promo-ad">
                <a href="https://www.mcdonalds.com/hu/hu-hu/Ajanlatok/maestro-goosey-gustav.html" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/landing_meki.jpg" alt="McDonald's Special Offer" class="ad-image">
                </a>
            </div>

            <div class="two-column-grid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                    <article class="post-card">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                        <?php endif; ?>
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
                            <span class="comments-link">
                                <a href="<?php the_permalink(); ?>#comments">
                                    <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                                </a>
                            </span>
                        </div>
                    </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-posts">
                        <p>No posts found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        
        <?php get_sidebar(); ?>
    </div>
</main>


<!-- Add JavaScript for the carousel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselItems = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.indicator');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    let currentSlide = 1;
    const totalSlides = carouselItems.length;
    
    // Function to show a specific slide
    function showSlide(slideNumber) {
        carouselItems.forEach(item => {
            item.classList.remove('active');
        });
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
        });
        
        document.querySelector(`.carousel-item[data-slide="${slideNumber}"]`).classList.add('active');
        document.querySelector(`.indicator[data-slide="${slideNumber}"]`).classList.add('active');
        currentSlide = slideNumber;
    }
    
    // Set up automatic cycling
    let slideInterval = setInterval(() => {
        let nextSlide = currentSlide + 1;
        if (nextSlide > totalSlides) {
            nextSlide = 1;
        }
        showSlide(nextSlide);
    }, 5000); // Change slide every 5 seconds
    
    // Event listeners for controls
    prevButton.addEventListener('click', function() {
        clearInterval(slideInterval); // Reset the interval when user interacts
        let prevSlide = currentSlide - 1;
        if (prevSlide < 1) {
            prevSlide = totalSlides;
        }
        showSlide(prevSlide);
        
        // Restart the interval
        slideInterval = setInterval(() => {
            let nextSlide = currentSlide + 1;
            if (nextSlide > totalSlides) {
                nextSlide = 1;
            }
            showSlide(nextSlide);
        }, 5000);
    });
    
    nextButton.addEventListener('click', function() {
        clearInterval(slideInterval); // Reset the interval when user interacts
        let nextSlide = currentSlide + 1;
        if (nextSlide > totalSlides) {
            nextSlide = 1;
        }
        showSlide(nextSlide);
        
        // Restart the interval
        slideInterval = setInterval(() => {
            let nextSlide = currentSlide + 1;
            if (nextSlide > totalSlides) {
                nextSlide = 1;
            }
            showSlide(nextSlide);
        }, 5000);
    });
    
    // Event listeners for indicators
    indicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            clearInterval(slideInterval); // Reset the interval when user interacts
            const slideNumber = parseInt(this.getAttribute('data-slide'));
            showSlide(slideNumber);
            
            // Restart the interval
            slideInterval = setInterval(() => {
                let nextSlide = currentSlide + 1;
                if (nextSlide > totalSlides) {
                    nextSlide = 1;
                }
                showSlide(nextSlide);
            }, 5000);
        });
    });
    
    // Pause carousel on hover
    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', function() {
        clearInterval(slideInterval);
    });
    
    carouselContainer.addEventListener('mouseleave', function() {
        slideInterval = setInterval(() => {
            let nextSlide = currentSlide + 1;
            if (nextSlide > totalSlides) {
                nextSlide = 1;
            }
            showSlide(nextSlide);
        }, 5000);
    });
});
</script>

<?php get_footer(); ?>