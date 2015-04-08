<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class="wrap full-wrap cf">
					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php $itemMeta = get_post_meta(get_the_ID()); ?>
						<div class="video-wrapper">
							<?php if (is_user_logged_in() && $itemMeta['_skinsplex_media_item_video_link'][0]) { ?>
							<div class="video-controls">
								<a class="video-thumb TRIGGER_VIDEO" href="#">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'media-item-thumb'); ?>
								</a>
								<a class="btn TRIGGER_VIDEO" href="#">Play</a>
							</div>
							<div class="vid-player-container ov VID_PLAYER_OV OV">
								<video id="vidPlayer" class="video-js vjs-default-skin vjs-skinsplex-skin" controls>
									<source src="<?php echo $itemMeta['_skinsplex_media_item_video_link'][0]; ?>" type="video/mp4">
								</video>
							</div>
							<?php } else if (is_user_logged_in()) { ?>
							<div class="video-controls">
								<span class="video-thumb">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'media-item-thumb'); ?>
									<span class="sub-head">Coming Soon</span>
								</span>
							</div>
							<?php } else { ?>
							<div class="video-login">
								<?php $post_thumb_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(),'media-item-thumb',true); ?>
								<h2 style="background-image:url(<?php echo $post_thumb_src_array[0]; ?>);"><span>You must be logged in to view this video</span></h2>
								<a class="btn TRIGGER_LOGIN" href="#">Login</a>
								<span>- or -</span>
								<a class="btn" href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=register">Create an account</a>
							</div>
							<?php } ?>
						</div>
						<?php $ad_160x600_object = get_posts(array('post_type'=>'ad_spaces','name'=>'ad-160x600')); 
						$thisPostClass = isset($ad_160x600_object[0]) ? 'cf advactive' : 'cf'; ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($thisPostClass); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
							<?php // checking whether this is in the preview media-item category
							$mediaItemCatTerms = get_the_terms( get_the_ID(), 'media_item_cat'); 
							$isPreview = false;
							foreach ($mediaItemCatTerms as $term) {
								if ($term->slug == 'previews') {
									$isPreview = true;
									break;
								}
							} ?> 
							<header class="article-header entry-header">
								<?php if ($isPreview) { ?>
								<h2 class="super-head">Coming Soon</h2>
								<?php } ?>
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
						<?php if (isset($ad_160x600_object[0])) { ?>
						<ul class="advspcnt w-skyscr ADVSPCNT">
							<?php $ads_160x600 = get_post_meta($ad_160x600_object[0]->ID, '_skinsplex_ad_space_group', true);
							foreach( (array) $ads_160x600 as $key => $ad) { 
								echo adItemHtml($key, $ad);
								/*
								<li class="adv-<?php echo $ad[image_id]; ?><?php echo $key==0 ? ' active':''; ?>">
									<a href="<?php echo $ad[link]; ?>">
										<img src="<?php echo $ad[image]; ?>" alt="<?php echo $ad[description]; ?>" />
									</a>
								</li>
								*/
							} ?>
						</ul>
						<?php } ?>
						
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
