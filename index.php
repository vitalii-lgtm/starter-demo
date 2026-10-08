<?php
/**
 * Fallback template: posts list, archives, search, 404.
 *
 * @package Starter_Demo
 */

get_header();
?>

<div class="entry-content is-layout-constrained has-global-padding">
	<?php if ( have_posts() ) : ?>
		<?php if ( ! is_singular() ) : ?>
			<h1><?php echo is_home() ? esc_html__( 'Blog', 'starter-demo' ) : wp_kses_post( get_the_archive_title() ); ?></h1>
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php if ( is_singular() ) : ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php else : ?>
				<article class="post-teaser">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endif; ?>
		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1><?php esc_html_e( 'Nothing found', 'starter-demo' ); ?></h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the homepage', 'starter-demo' ); ?></a></p>
	<?php endif; ?>
</div>

<?php
get_footer();
