<?php
/**
 * Site footer.
 *
 * @package Starter_Demo
 */

?>
</main>

<footer class="site-footer">
	<div class="site-footer__inner">
		<p class="site-footer__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'site-footer__menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
