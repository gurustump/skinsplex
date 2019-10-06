<?php
/*
 Template Name: s2Member Subscription Success Page
 
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="full-wrap wrap cf">

						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									<?php /*
									<p class="byline vcard">
										<?php printf( __( 'Posted', 'bonestheme').' <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> '.__( 'by',  'bonestheme').' <span class="author">%3$s</span>', get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>
									*/ ?>

								</header> <?php // end article header ?>
								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
									?>
									<div class="response-message">
										<p>You have signed up for Skinsplex Premium with the following information:</p>
										<table>
											<tr>
												<td>First Name</td><td><?php echo esc_html($_REQUEST['first_name']); ?></td>
											</tr>
											<tr>
												<td>Last Name</td><td><?php echo esc_html($_REQUEST['last_name']); ?></td>
											</tr>
											<tr>
												<td>Email Address</td><td><?php echo esc_html($_REQUEST['email']); ?></td>
											</tr>
											<tr>
												<td>Username</td><td><?php echo esc_html($_REQUEST['user_login']); ?></td>
											</tr>
										</table>
										<p>If this is your first time signing up for Skinsplex, you will receive an email with your new account password. Follow the instructions in the email to change your password to something that you can remember more easily.</p>
										<p>Your credit card has been billed <?php echo esc_html($_REQUEST['currency_symbol']); ?><?php echo esc_html($_REQUEST['initial']); ?>. Until such time as you cancel your membership, you will be billed a recurring fee of <?php echo esc_html($_REQUEST['currency_symbol']); ?><?php echo esc_html($_REQUEST['regular']); ?> on a monthly basis.</p>
										<p>If you wish to make any modifications to your profile or cancel your subscription at any time, you may go to your <a href="<?php bloginfo('wpurl'); ?>/account">account page</a>. You can always find your account page through a link in Main Menu at the top right of the site by clicking on the user icon ( <span class="ic-user"></span> ) and then clicking the "Edit My Account" button.</p>
									</div>
								</section> <?php // end article section ?>

								<?php // comments_template(); ?>

							</article>

							<?php endwhile; endif; ?>

						</main>

						<?php // get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
