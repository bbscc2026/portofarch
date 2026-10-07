import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger, SplitText);

// Mobile browsers resize the viewport as the address bar shows/hides; recalculating every
// trigger then makes pinned sections jump. Ignore those resizes.
ScrollTrigger.config({ ignoreMobileResize: true });

const ease = 'expo.out';

/**
 * Smooth scrolling (desktop wheel only — touch keeps native scrolling), kept in sync with ScrollTrigger.
 * In-page anchor links scroll smoothly through Lenis instead of jumping.
 */
function smoothScroll() {
    const lenis = new Lenis({ lerp: 0.12, wheelMultiplier: 1, anchors: { offset: -80 } });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    // Pause page scrolling while the mobile menu is open.
    document.addEventListener('menu:toggle', (event) => (event.detail ? lenis.stop() : lenis.start()));

    return lenis;
}

/**
 * Headings marked data-split rise in line by line from behind a mask.
 */
function splitHeadings() {
    document.querySelectorAll('[data-split]').forEach((el) => {
        let played = false;

        // autoSplit re-measures lines when fonts load or the window resizes, so lines never break wrongly.
        SplitText.create(el, {
            type: 'lines',
            mask: 'lines',
            linesClass: 'split-line',
            autoSplit: true,
            onSplit(split) {
                gsap.set(el, { visibility: 'visible' });
                if (played) {
                    return;
                }
                played = true;

                const tween = {
                    yPercent: 110,
                    duration: 1.3,
                    ease,
                    stagger: 0.09,
                    delay: parseFloat(el.dataset.delay || 0),
                };

                return el.dataset.split === 'load'
                    ? gsap.from(split.lines, tween)
                    : gsap.from(split.lines, { ...tween, scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
            },
        });
    });
}

/**
 * Blocks marked data-reveal fade and rise; siblings in a batch stagger.
 */
function reveals() {
    ScrollTrigger.batch('[data-reveal]', {
        start: 'top 90%',
        once: true,
        onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, duration: 1.2, ease, stagger: 0.1, overwrite: true }),
    });
}

/**
 * Images marked data-clip wipe open from the bottom while the image settles from a slight zoom.
 */
function clipImages() {
    document.querySelectorAll('[data-clip]').forEach((el) => {
        const img = el.querySelector('img');
        const tl = gsap.timeline({ scrollTrigger: { trigger: el, start: 'top 90%', once: true } });
        tl.to(el, { clipPath: 'inset(0% 0 0 0)', duration: 1.4, ease: 'expo.inOut' });
        if (img) {
            tl.from(img, { scale: 1.25, duration: 1.8, ease }, 0);
        }
    });
}

/**
 * Elements marked data-speed drift against the scroll for depth.
 */
function parallax() {
    gsap.utils.toArray('[data-speed]').forEach((el) => {
        const speed = parseFloat(el.dataset.speed);
        gsap.fromTo(el, { yPercent: -speed * 50 }, {
            yPercent: speed * 50,
            ease: 'none',
            scrollTrigger: { trigger: el.parentElement, start: 'top bottom', end: 'bottom top', scrub: true },
        });
    });
}

/**
 * Numbers marked data-count tick up when they enter the screen.
 */
function counters() {
    // The real number stays in place until the count-up actually starts, so a fast scroll or an
    // anchor jump never leaves a wrong value on screen.
    document.querySelectorAll('[data-count]').forEach((el) => {
        const target = parseInt(el.dataset.count, 10);
        if (!Number.isFinite(target)) {
            return;
        }
        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () => {
                const state = { value: 0 };
                gsap.to(state, {
                    value: target,
                    duration: 1.6,
                    ease: 'power3.out',
                    onUpdate: () => (el.textContent = String(Math.round(state.value))),
                });
            },
        });
    });
}

/**
 * Hero statements hand over every few seconds (rows slide up out of a mask while the next rise in),
 * crossfading the background to the slide paired with each statement. Videos play only when shown.
 */
function heroSequence() {
    const hero = document.querySelector('[data-hero]');
    if (!hero) {
        return;
    }

    const statements = gsap.utils.toArray(hero.querySelectorAll('[data-statement]'));
    const slides = gsap.utils.toArray(hero.querySelectorAll('[data-hero-slide]'));
    const captions = gsap.utils.toArray(hero.querySelectorAll('[data-hero-caption]'));
    const rows = (statement) => statement.querySelectorAll(':scope > span > span');
    const interval = 4200;
    let current = -1;
    let shownSlide = 0;
    let timer = null;

    statements.forEach((statement) => gsap.set(rows(statement), { yPercent: 110 }));
    gsap.set(hero.querySelector('[data-hero-text]'), { autoAlpha: 1 });

    const showSlide = (index) => {
        if (index === shownSlide) {
            return;
        }
        const previous = shownSlide;
        shownSlide = index;
        slides.forEach((slide, i) => {
            gsap.killTweensOf(slide);
            if (i !== index && i !== previous) {
                gsap.set(slide, { opacity: 0 });
            }
        });
        gsap.to(slides[previous], { opacity: 0, duration: 1.4, ease: 'power2.inOut' });
        gsap.fromTo(slides[index], { opacity: 0, scale: 1.06 }, { opacity: 1, scale: 1, duration: 1.6, ease: 'power2.out' });
        slides.forEach((slide, i) => {
            const video = slide.querySelector('video');
            if (video) {
                i === index ? video.play().catch(() => {}) : setTimeout(() => shownSlide !== i && video.pause(), 1500);
            }
        });
        captions.forEach((caption, i) => caption.classList.toggle('hidden', i !== index));
    };

    /**
     * Move to statement `next`. Every statement that is neither leaving nor entering is reset to
     * hidden first, so statements can never pile up on top of each other — even if steps fire late.
     */
    const go = (next) => {
        const previous = current;
        current = next;

        statements.forEach((statement, i) => {
            gsap.killTweensOf(rows(statement));
            if (i !== previous && i !== next) {
                gsap.set(rows(statement), { yPercent: 110 });
            }
        });

        if (previous >= 0 && previous !== next) {
            gsap.to(rows(statements[previous]), {
                yPercent: -110,
                duration: 0.75,
                ease: 'expo.in',
                stagger: 0.06,
                onComplete: () => current !== previous && gsap.set(rows(statements[previous]), { yPercent: 110 }),
            });
        }

        gsap.fromTo(rows(statements[next]), { yPercent: 110 }, {
            yPercent: 0,
            duration: 1.1,
            ease: 'expo.out',
            stagger: 0.08,
            delay: previous >= 0 ? 0.45 : 0,
        });

        showSlide(Number(statements[next].dataset.slide || 0));
    };

    // Plain timers (not the animation clock): while the tab is hidden the loop simply stops,
    // and when it returns it continues from the current statement instead of replaying missed steps.
    const schedule = () => {
        clearTimeout(timer);
        if (statements.length > 1 && !document.hidden) {
            timer = setTimeout(() => {
                go((current + 1) % statements.length);
                schedule();
            }, interval);
        }
    };

    document.addEventListener('visibilitychange', () => (document.hidden ? clearTimeout(timer) : schedule()));

    // First statement rises in after the intro curtain.
    setTimeout(() => {
        go(0);
        schedule();
    }, document.querySelector('[data-intro]') ? 2400 : 300);
}

/**
 * While scrolling past the hero it stays pinned: the media shrinks into a rounded card and the
 * statement fades, like UNStudio's opening.
 */
function heroScroll() {
    const hero = document.querySelector('[data-hero]');
    if (!hero) {
        return;
    }

    const small = window.matchMedia('(max-width: 767px)').matches;

    gsap.timeline({
        scrollTrigger: { trigger: hero, start: 'top top', end: '+=75%', scrub: true, pin: true, invalidateOnRefresh: true },
    })
        .to(hero.querySelector('[data-hero-frame]'), {
            scale: small ? 0.86 : 0.68,
            ease: 'none',
        }, 0)
        .to(hero.querySelector('[data-hero-text]'), { opacity: 0.35, scale: small ? 0.9 : 0.8, ease: 'none' }, 0)
        .to(hero.querySelector('[data-hero-bar]'), { opacity: 0, ease: 'none' }, 0);
}

/**
 * Large paragraphs marked data-words light up word by word as they scroll through the screen.
 */
function wordReveal() {
    document.querySelectorAll('[data-words]').forEach((el) => {
        const split = SplitText.create(el, { type: 'words' });
        gsap.fromTo(split.words, { opacity: 0.14 }, {
            opacity: 1,
            ease: 'none',
            stagger: 0.1,
            scrollTrigger: { trigger: el, start: 'top 80%', end: 'bottom 45%', scrub: true },
        });
    });
}

/**
 * Showcase panels stack over each other; the panel being covered sinks back and dims.
 */
function showcase() {
    const panels = gsap.utils.toArray('[data-panel]');
    panels.forEach((panel, i) => {
        const next = panels[i + 1];
        if (!next) {
            return;
        }
        gsap.to(panel.querySelector('[data-panel-inner]'), {
            scale: 0.9,
            opacity: 0.35,
            ease: 'none',
            scrollTrigger: { trigger: next, start: 'top bottom', end: 'top top', scrub: true },
        });
    });
}

/**
 * One-time intro curtain per browser session.
 */
function intro() {
    const curtain = document.querySelector('[data-intro]');
    if (!curtain) {
        return;
    }

    let seen = false;
    try {
        seen = sessionStorage.getItem('poa-intro') === '1';
        sessionStorage.setItem('poa-intro', '1');
    } catch {
        // Storage can be blocked; just play the intro.
    }

    if (seen) {
        curtain.remove();
        return;
    }

    gsap.timeline({ onComplete: () => curtain.remove() })
        .from(curtain.querySelector('img'), { yPercent: 40, opacity: 0, duration: 0.9, ease })
        .to(curtain.querySelector('[data-intro-bar]'), { scaleX: 1, duration: 0.9, ease: 'power2.inOut' }, '-=0.4')
        .to(curtain, { yPercent: -100, duration: 1.1, ease: 'expo.inOut' }, '+=0.1');
}

export function initMotion() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduced) {
        document.querySelector('[data-intro]')?.remove();
        // Keep the film still and show only the first statement.
        document.querySelectorAll('[data-hero] video').forEach((video) => video.pause());
        return;
    }

    document.documentElement.classList.add('motion');
    window.__motionReady = true;

    intro();
    smoothScroll();
    heroSequence();
    heroScroll();
    wordReveal();
    showcase();
    splitHeadings();
    reveals();
    clipImages();
    parallax();
    counters();

    // Images loading late change page height; keep trigger positions accurate.
    window.addEventListener('load', () => ScrollTrigger.refresh());
}
