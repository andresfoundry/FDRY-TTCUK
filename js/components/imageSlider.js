$('.owl-carousel').owlCarousel({
    dots: false,
    stagePadding: 0,
    lazyLoad: true,
    lazyLoadEager: 6,
    loop: true,
    nav: true,
    margin: 0,
    autoWidth: false,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    items: 4,
    responsive: {
        0: {
            items:1,
            nav:false
        },
        600: {
            items:2
        },
        900: {
            items:3
        },
        1200: {
            items:4
        }
    }
});