<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class="wrap full-wrap cf">
					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php $itemMeta = get_post_meta(get_the_ID()); ?>
						<div class="video-wrapper">
							<?php if (is_user_logged_in()) { ?>
							<div class="video-controls">
								<a class="video-thumb TRIGGER_VIDEO" href="#">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'media-item-thumb'); ?>
								</a>
								<a class="btn TRIGGER_VIDEO" href="#">Play</a>
							</div>
							<div class="vid-player-container ov VID_PLAYER_OV OV">
								<video id="vidPlayer" class="video-js vjs-default-skin" controls>
									<source src="<?php echo $itemMeta['_skinsplex_media_item_video_link'][0]; ?>" type="video/mp4">
								</video>
							</div>
							<?php } else { ?>
							<div class="video-login">
								<?php $post_thumb_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(),'media-item-thumb',true); ?>
								<h2 style="background-image:url(<?php echo $post_thumb_src_array[0]; ?>);"><span>You must be logged in to view this video</span></h2>
								<a class="btn" href="#">Login</a>
								<span>- or -</span>
								<a class="btn" href="#">Create an account</a>
							</div>
							<?php } ?>
						</div>
						<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
							<header class="article-header entry-header">
								<h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
							</header> <?php // end article header ?>
							<section class="entry-content cf" itemprop="articleBody">
								<?php the_content(); ?>
								<?php if ($itemMeta['_skinsplex_media_item_director'][0] || $itemMeta['_skinsplex_media_item_producer'][0] || $itemMeta['_skinsplex_media_item_writer'][0] || $itemMeta['_skinsplex_media_item_cast'][0] || $itemMeta['_skinsplex_media_item_duration'][0] || $itemMeta['_skinsplex_media_item_age_restriction'][0] || $itemMeta['_skinsplex_media_item_country'][0]) { ?>
								<div class="media-item-info">
									<table>
										<?php if ($itemMeta['_skinsplex_media_item_director'][0]) { ?>
										<tr>
											<td>Director</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_director'][0]; ?></td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_producer'][0]) { ?>
										<tr>
											<td>Producer</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_producer'][0]; ?></td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_writer'][0]) { ?>
										<tr>
											<td>Writer</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_writer'][0]; ?></td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_cast'][0]) { ?>
										<tr>
											<td>Cast</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_cast'][0]; ?></td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_duration'][0]) { ?>
										<tr>
											<td>Duration</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_duration'][0]; ?> min.</td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_age_restriction'][0]) { ?>
										<tr>
											<td>Age Restriction</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_age_restriction'][0]; ?></td>
										<tr>
										<?php } ?>
										<?php if ($itemMeta['_skinsplex_media_item_country'][0]) { ?>
										<tr>
											<td>Country</td>
											<td><?php echo $itemMeta['_skinsplex_media_item_country'][0]; ?></td>
										<tr>
										<?php } ?>
									</table>
								</div>
								<?php } ?>
							</section> <?php // end article section ?>
						</article> <?php // end article ?>
						
						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</main>

				</div>

			</div>

<?php get_footer(); ?>
