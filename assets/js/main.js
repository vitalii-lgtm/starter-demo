/**
 * Starter Demo - mobile menu toggle.
 */
document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.site-header');
	const toggle = header ? header.querySelector('[data-menu-toggle]') : null;

	if (!header || !toggle) {
		return;
	}

	toggle.addEventListener('click', () => {
		const isOpen = header.classList.toggle('is-open');
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});

	// Close the menu after a link is chosen.
	header.querySelectorAll('.site-header__nav a').forEach((link) => {
		link.addEventListener('click', () => {
			header.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		});
	});
});
