<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" role="main">
						<h1 class="page-title"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

									
						<?php if (have_posts()) : ?>
								
						<div class="thumb-index">
							<div class="thumb-index-inner">
								<ul>
								
								<?php while (have_posts()) : the_post(); ?>

									<li>
										<a href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail()) { ?>
											<img class="item-thumb" src="<?php the_post_thumbnail_url(  'media-item-thumb' ); ?>" />
											<?php } ?>
											<span class="item-head"><span><?php the_title(); ?></span></span>
										</a>
									</li>

								<?php endwhile; ?>

								<ul>
							</div>
						</div>
						<?php bones_page_navi(); ?>

						<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h2><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h2>
										</header>
									</article>

							<?php endif; ?>

						</main>

					</div>

			</div>

<?php get_footer(); ?>
