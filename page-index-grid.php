<?php
/*
 Template Name: Index Grid Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="full-wrap wrap cf">

						<main id="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


							<h1 class="page-title"><?php the_title(); ?></h1>
								<?php if (get_the_content()) { ?>
								<section class="entry-content cf" itemprop="articleBody">
									<?php the_content(); ?>
								</section>
								<?php } 
								$mediaItemCat = get_post_meta(get_the_ID(), '_skinsplex_index_grid_select', true); 
								$shows = get_posts(array(
										'posts_per_page'=>-1,
										'post_type'=>'media_items',
										'orderby'=>'title',
										'order'=>'ASC',
										'media_item_cat'=> $mediaItemCat
								));
								/*echo count($shows);
								echo '<pre>';
								// print_r($shows);
								echo '</pre>';*/
								if (count($shows) > 0) { ?>
									
								<div class="thumb-index">
									<div class="thumb-index-inner">
										<ul>
											<?php global $post;
											foreach($shows as $key => $item) { 
											$post = $item;
											setup_postdata($post);
											$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'media-item-thumb');
											?>
											<li>
												<a href="<?php the_permalink(); ?>">
													<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
													<span class="item-head"><span><?php the_title(); ?></span></span>
												</a>
											</li>
											<?php } ?>
										<ul>
									</div>
								</div>
								<?php } ?>
						

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>


<?php get_footer(); ?>
