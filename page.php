<?php
/**
 * Pages (including the homepage): content comes from the block editor.
 * The title is not printed, so each page controls its own hero in the editor.
 *
 * @package Starter_Demo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="entry-content is-layout-constrained has-global-padding">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
