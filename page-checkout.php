<?php
/*
 Template Name: s2Member Checkout Page
 
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
									<?php the_content(); ?>
									<?php $subscription_desc = get_option('skinsplex_s2Member_subscription_desc');
									if ($subscription_desc) { ?>
									<div class="subscription-desc">
										<?php echo $subscription_desc; ?>
									</div>
									<?php } ?>
									<div class="subscription-terms">
									
									</div>
									<div class="subscription-form-wrapper SUBSCRIPTION_FORM_WRAPPER">
										<?php echo do_shortcode('[terms_of_use]'); ?>
										<?php 
											$subscription_amount = get_option('skinsplex_s2Member_subscription_amount');
											$urlparts = parse_url(site_url());
											$domain = $urlparts [host];
											?>
											
										<pre class="TESTORAMA" style="background:red;color:white;display:none;"><?php echo '[s2Member-Pro-Stripe-Form level="1" ccaps="" desc="$'.$subscription_amount.' / Monthly (recurring charge, for ongoing access)" cc="USD" custom="'.$domain.'" ta="0" tp="0" tt="D" ra="'.$subscription_amount.'" rp="1" rt="M" rr="1" coupon="" accept_coupons="0" default_country_code="US" captcha="0" success="'.site_url().'/subscription-success?currency_symbol=%%currency_symbol%%&initial=%%initial%%&regular=%%regular%%&recurring=%%recurring%%&first_name=%%user_first_name%%&last_name=%%user_last_name%%&email=%%user_email%%&user_login=%%user_login%%" /]';?></pre>
											<?php
											/*echo site_url();
											echo "<br>";
											echo $domain;
											echo "<br>";
											echo get_bloginfo('wpurl');*/
											echo do_shortcode('[s2Member-Pro-Stripe-Form level="1" ccaps="" desc="$'.$subscription_amount.' / Monthly (recurring charge, for ongoing access)" cc="USD" custom="'.$domain.'" ta="0" tp="0" tt="D" ra="'.$subscription_amount.'" rp="1" rt="M" rr="1" coupon="" accept_coupons="0" default_country_code="US" captcha="0" success="'.site_url().'/subscription-success?currency_symbol=%%currency_symbol%%&initial=%%initial%%&regular=%%regular%%&recurring=%%recurring%%&first_name=%%user_first_name%%&last_name=%%user_last_name%%&email=%%user_email%%&user_login=%%user_login%%" /]');
										?>
									</div>
								</section> <?php // end article section ?>

								<footer class="article-footer cf">

								</footer>

								<?php // comments_template(); ?>

							</article>

							<?php endwhile; endif; ?>

						</main>

						<?php // get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>

<?php /*
Paypal shortcode, in case it's ever wanted again: 
										
										echo do_shortcode('[s2Member-Pro-PayPal-Form level="1" ccaps="" desc="$3.00 USD / Monthly <span>(recurring charge, for ongoing access)</span>" ps="paypal" lc="" cc="USD" dg="0" ns="1" custom="localhost.gurustump.com" ta="0" tp="0" tt="D" ra="3.00" rp="1" rt="M" rr="1" rrt="" rra="2" accept="paypal,visa,mastercard,amex,discover" accept_via_paypal="paypal" coupon="" accept_coupons="0" default_country_code="" captcha="0" /]');
										
										
Stripe shortcode
										echo do_shortcode('[s2Member-Pro-Stripe-Form level="1" ccaps="" desc="$3 USD / Monthly (recurring charge, for ongoing access)" cc="USD" custom="localhost.gurustump.com" ta="0" tp="0" tt="D" ra="3" rp="1" rt="M" rr="1" coupon="" accept_coupons="0" default_country_code="US" captcha="0" /]');
*/ ?>
