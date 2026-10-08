<?php
/**
 * Site header.
 *
 * @package Starter_Demo
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="site-header__inner">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<button class="site-header__burger" type="button" aria-expanded="false" aria-controls="site-nav" data-menu-toggle>
			<span></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'starter-demo' ); ?></span>
		</button>

		<nav class="site-header__nav" id="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'starter-demo' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-header__menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
</header>

<main class="site-main" id="main">
