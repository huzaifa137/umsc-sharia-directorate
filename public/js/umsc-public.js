(function () {
    'use strict';

    var header = document.querySelector('.u-header');
    function onScroll() { if (header) header.classList.toggle('is-scrolled', window.scrollY > 6); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    var burger = document.getElementById('uBurger');
    var nav = document.getElementById('uNav');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        nav.addEventListener('click', function (e) {
            if (e.target.closest('a')) { nav.classList.remove('is-open'); burger.setAttribute('aria-expanded', 'false'); }
        });
    }

    // Highlight the nav link of the section currently in view
    var links = [].slice.call(document.querySelectorAll('.u-nav a[href*="#"]'));
    var map = links.map(function (a) {
        var id = a.getAttribute('href').split('#')[1];
        return { a: a, el: id ? document.getElementById(id) : null };
    }).filter(function (x) { return x.el; });
    if ('IntersectionObserver' in window && map.length) {
        var spy = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                map.forEach(function (x) { x.a.classList.toggle('is-active', x.el === en.target); });
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        map.forEach(function (x) { spy.observe(x.el); });
    }
})();
