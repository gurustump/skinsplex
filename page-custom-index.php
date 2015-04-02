<?php
/*
 Template Name: Custom Index Page
 
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>
			<div id="content">
				<div id="inner-content">
					<main id="main" role="main" itemscope itemprop="mainContentOfPage">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
							<?php /* if (!is_front_page()) { ?>
							<header class="article-header">
								<h1 class="page-title"><?php the_title(); ?></h1>
							</header>
							<?php } */ ?>
							<section class="entry-content cf" itemprop="articleBody">
								<?php
									// the content (pretty self explanatory huh)
									the_content();
									$pageSlug = $post->post_name;
									$sectionItems = get_posts(
										array(
											'posts_per_page'=>-1,
											'post_type'=>'media_items',
											'media_item_cat'=>is_front_page() ? 'featured-home' : $pageSlug
										)
									);
									if ( isset($sectionItems[0]) ) { ?>
										<div class="banner-gallery BANNER_GALLERY">
											<div class="banner-heading BANNER_HEADING">
												<h2></h2>
												<p></p>
											</div>
											<img />
											<div class="navigation BANNER_NAV">
												<a class="prev PREV" href="#">Previous</a>
												<a class="next NEXT" href="#">Next</a>
												<div class="hit-zone HIT_ZONE">
													<a class="btn LINK">Watch <span></span></a>
												</div>
											</div>
										</div>
										<div class="thumbnail-gallery THUMBNAIL_GALLERY owl-carousel">
										<?php foreach($sectionItems as $key => $item) {
											$itemMeta = get_post_meta($item->ID); ?>
											<div class="thumbnail-item THUMBNAIL_ITEM<?php if ($key==0) {echo ' active';} ?>">
												<a id="INDEX_ITEM_<?php echo $item->ID; ?>" href="<?php echo get_permalink($item->ID); ?>">
													<?php echo get_the_post_thumbnail($item->ID, 'index-thumb'); ?>
													<span class="item-title INDEX_TITLE"><?php echo $item->post_title; ?></span>
													<span class="hidden-data">
														<?php if ($itemMeta['_skinsplex_media_item_override_image'][0]) { ?>
															<img class="INDEX_BANNER" alt="<?php echo $item->post_title; ?>" src="<?php echo $itemMeta['_skinsplex_media_item_override_image'][0]; ?>" />
														<?php } else {
															echo get_the_post_thumbnail($item->ID, 'index-banner',array('class'=>'INDEX_BANNER')); 
														} ?>
														<?php if ($item->post_excerpt) { ?>
															<span class="INDEX_EXCERPT"><?php echo $item->post_excerpt; ?></span>
														<?php } ?>
														<?php if ($itemMeta['_skinsplex_media_item_exceprt_position_left'][0]) { ?>
															<span class="INDEX_EXCERPT_LEFT"><?php echo $itemMeta['_skinsplex_media_item_exceprt_position_left'][0]; ?></span>
														<?php } ?>
														<?php if ($itemMeta['_skinsplex_media_item_exceprt_position_top'][0]) { ?>
															<span class="INDEX_EXCERPT_TOP"><?php echo $itemMeta['_skinsplex_media_item_exceprt_position_top'][0]; ?></span>
														<?php } ?>
														<?php if ($itemMeta['_skinsplex_media_item_exceprt_text_color'][0]) { ?>
															<span class="INDEX_EXCERPT_TEXT_COLOR"><?php echo $itemMeta['_skinsplex_media_item_exceprt_text_color'][0]; ?></span>
														<?php } ?>
													</span>
												</a>
												<?php /*
												<pre>
													<?php print_r($item); ?>
												</pre>
												<pre>
													<?php print_r($itemMeta); ?>
												</pre>
												*/ ?>
											</div>
										<?php } ?>
										</div>
									<?php }
									/*
									 * Link Pages is used in case you have posts that are set to break into
									 * multiple pages. You can remove this if you don't plan on doing that.
									 *
									 * Also, breaking content up into multiple pages is a horrible experience,
									 * so don't do it. While there are SOME edge cases where this is useful, it's
									 * mostly used for people to get more ad views. It's up to you but if you want
									 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
									 *
									 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
									 *
									*/
									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
									) );
								?>
							</section>
						</article>
						<?php endwhile; else : ?>
								<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>
						<?php endif; ?>
					</main>
				</div>
			</div>
<?php get_footer(); ?>
