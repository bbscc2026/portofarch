/**
 * Header state from scroll position, used with or without the animation layer.
 *
 * Pages with a full-screen hero:
 *  - at the very top the header sits transparent over the image;
 *  - while the hero is being scrolled through (including its pinned shrink) the header slides away,
 *    so it never covers the hero;
 *  - once the hero has passed it returns as a solid, sticky white bar.
 * Other pages: always a solid, sticky bar.
 */
export function initHeader() {
    const header = document.querySelector('.site-header');
    if (!header) {
        return;
    }

    const overHero = header.dataset.overHero === 'true';
    const hero = document.querySelector('[data-hero]') || document.querySelector('main > section');
    let ticking = false;

    // Where the hero ends in the page. When the hero is pinned, GSAP wraps it in a .pin-spacer
    // that includes the extra pinned scroll distance, so measure that wrapper.
    const heroEnd = () => {
        if (!hero) {
            return 0;
        }
        const block = hero.closest('.pin-spacer') || hero;
        return block.getBoundingClientRect().bottom + window.scrollY - header.offsetHeight;
    };

    const update = () => {
        ticking = false;

        if (!overHero) {
            return;
        }

        const y = Math.max(window.scrollY, 0);
        const menuOpen = document.body.classList.contains('overflow-hidden');
        const atTop = y <= 40;
        const pastHero = y >= heroEnd();

        header.classList.toggle('is-solid', pastHero);
        header.classList.toggle('is-hidden', !menuOpen && !atTop && !pastHero);
    };

    const requestUpdate = () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    };

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate);
    // Re-check once pinning and images have settled the page layout.
    window.addEventListener('load', requestUpdate);

    update();
}
