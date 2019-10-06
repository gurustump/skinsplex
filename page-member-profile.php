<?php
/*
 Template Name: s2Member Member Profile Page
 
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
									?>
									<ul class="tabs">
										<?php if (is_user_logged_in()) { ?>
										<li class="profile">
											<input type="radio" name="tabbed" id="tab1" checked />
											<div class="tab-container">
												<h2><label for="tab1">Profile</label></h2>
												<div class="tab-content">
													<?php 
													echo do_shortcode('[s2Member-Profile /]');
													?>
												</div>
											</div>
										</li>
										<?php } ?>
										<?php if (current_user_can("access_s2member_level1")){ ?>
										<li class="cancel-membership">
											<input type="radio" name="tabbed" id="tab2" />
											<div class="tab-container">
												<h2><label for="tab2">Cancel Account</label></h2>
												<div class="tab-content">
													<?php 
													echo do_shortcode('[s2Member-Pro-Stripe-Form cancel="1" desc="This will cancel your account.<br> You will no longer be billed your monthly subscription rate, but you will no longer be able to view exclusive, subscriber-only content on Skinsplex.<br> Are you sure?" unsub="0" captcha="0" /]');
													?>
												</div>
											</div>
										</li>
										<?php } ?>
										<?php
										$subscription_desc = get_option('skinsplex_s2Member_subscription_desc');
										$subscription_amount = get_option('skinsplex_s2Member_subscription_amount');
										$urlparts = parse_url(site_url());
										$domain = $urlparts [host];
										?>
										<?php if(current_user_is("s2member_level0")){ ?>
										<li class="upgrade">
											<input type="radio" name="tabbed" id="tab3" />
											<div class="tab-container">
												<h2><label for="tab3">Upgrade</label></h2>
												<div class="tab-content">
													<?php 	
													if ($subscription_desc) { ?>
													<div class="subscription-desc">
														<?php echo $subscription_desc; ?>
													</div>
													<?php } ?>
													<div class="subscription-form-wrapper SUBSCRIPTION_FORM_WRAPPER">
														<?php echo do_shortcode('[terms_of_use]'); ?>
														<?php 
														echo do_shortcode('[s2Member-Pro-Stripe-Form modify="1" level="1" ccaps="" desc="$'.$subscription_amount.' / Monthly (recurring charge, for ongoing access)" cc="USD" custom="'.$domain.'" ta="0" tp="0" tt="D" ra="'.$subscription_amount.'" rp="1" rt="M" rr="1" coupon="" accept_coupons="0" default_country_code="US" captcha="0" success="'.site_url().'/subscription-success?currency_symbol=%%currency_symbol%%&initial=%%initial%%&regular=%%regular%%&recurring=%%recurring%%&first_name=%%user_first_name%%&last_name=%%user_last_name%%&email=%%user_email%%&user_login=%%user_login%%" /]');
														?>
													</div>
												</div>
											</div>
										</li>
										<?php } else if (is_user_not_logged_in()) { ?>
										<li class="sign-up">
											<input type="radio" name="tabbed" id="tab4" checked />
											<div class="tab-container">
												<h2><label for="tab4">Sign Up</label></h2>
												<div class="tab-content">
													<?php 	
													if ($subscription_desc) { ?>
													<div class="subscription-desc">
														<?php echo $subscription_desc; ?>
													</div>
													<?php } ?>
													<div class="subscription-form-wrapper SUBSCRIPTION_FORM_WRAPPER">
														<?php echo do_shortcode('[terms_of_use]'); ?>
														<?php
														echo do_shortcode('[s2Member-Pro-Stripe-Form level="1" ccaps="" desc="$'.$subscription_amount.' / Monthly (recurring charge, for ongoing access)" cc="USD" custom="'.$domain.'" ta="0" tp="0" tt="D" ra="'.$subscription_amount.'" rp="1" rt="M" rr="1" coupon="" accept_coupons="0" default_country_code="US" captcha="0" success="'.site_url().'/subscription-success?currency_symbol=%%currency_symbol%%&initial=%%initial%%&regular=%%regular%%&recurring=%%recurring%%&first_name=%%user_first_name%%&last_name=%%user_last_name%%&email=%%user_email%%&user_login=%%user_login%%" /]');
														?>
													</div>
												</div>
											</div>
										</li>
										<?php } ?>
									</ul>
								</section> <?php // end article section ?>

								<?php // comments_template(); ?>

							</article>

							<?php endwhile; endif; ?>

						</main>

						<?php // get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
