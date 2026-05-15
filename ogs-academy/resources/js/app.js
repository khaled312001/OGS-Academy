import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

window.Alpine = Alpine;
window.gsap = gsap;
gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
        mirror: false,
    });

    // Hero counter animation
    document.querySelectorAll('[data-count]').forEach((el) => {
        const target = parseInt(el.dataset.count, 10);
        if (!target) return;
        const obj = { v: 0 };
        gsap.to(obj, {
            v: target,
            duration: 2,
            ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 85%' },
            onUpdate: () => { el.textContent = Math.floor(obj.v).toLocaleString('ar-EG'); },
        });
    });

    // Subtle parallax on hero photo
    const heroBg = document.querySelector('[data-hero-bg]');
    if (heroBg) {
        gsap.to(heroBg, {
            yPercent: 12,
            ease: 'none',
            scrollTrigger: { trigger: heroBg, start: 'top top', end: 'bottom top', scrub: true },
        });
    }

    // Nav scrolled state
    const nav = document.querySelector('[data-nav]');
    if (nav) {
        const update = () => nav.classList.toggle('is-scrolled', window.scrollY > 24);
        update();
        window.addEventListener('scroll', update, { passive: true });
    }

    // Reading progress bar
    const bar = document.querySelector('[data-reading-bar] span');
    if (bar) {
        const updateBar = () => {
            const h = document.documentElement;
            const total = h.scrollHeight - h.clientHeight;
            const pct = total > 0 ? (h.scrollTop / total) * 100 : 0;
            bar.style.width = Math.min(100, pct).toFixed(1) + '%';
        };
        updateBar();
        window.addEventListener('scroll', updateBar, { passive: true });
        window.addEventListener('resize', updateBar, { passive: true });
    }

    // Back-to-top button
    const back = document.querySelector('[data-back-to-top]');
    if (back) {
        const toggle = () => {
            const show = window.scrollY > 600;
            back.classList.toggle('opacity-0', !show);
            back.classList.toggle('invisible', !show);
            back.classList.toggle('translate-y-2', !show);
        };
        toggle();
        window.addEventListener('scroll', toggle, { passive: true });
        back.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    // Lazy-load only below-the-fold images (skip first 3 to avoid breaking hero/logo)
    const imgs = Array.from(document.querySelectorAll('img:not([loading])'));
    imgs.slice(3).forEach(img => {
        img.setAttribute('loading', 'lazy');
        img.setAttribute('decoding', 'async');
    });
});

Alpine.start();
