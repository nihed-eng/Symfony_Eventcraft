import 'bootstrap';
import 'owl.carousel';
import $ from 'jquery';
global.$ = global.jQuery = $;

// CSS (à importer dans votre template)
import './styles/app.css';  // ou './styles/app.scss' si tu utilises SCSS
import './js/bootstrap.min.js';
import './js/owl.carousel.min.js';
import './js/main.js';

import 'owl.carousel/dist/assets/owl.carousel.css';

import $ from 'jquery';

$(document).ready(function(){
    $(".testimonial__slider").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        smartSpeed: 600,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        dots: true,
        nav: true,
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
    });
});

console.log('App JS loaded!');
