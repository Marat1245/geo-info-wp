$(document).ready(function () {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: "auto",
        //   spaceBetween: 30,
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            380: {
                freeMode: false,
                slidesPerView: 1,

            },
            400: {
                freeMode: true,
                slidesPerView: "auto",

            },
            1000: {
                freeMode: true,
                slidesPerView: "auto",

            }
        },
    });

    var swiper = new Swiper(".diplom_slider", {
        slidesPerView: "auto",
        spaceBetween: 24,
        // freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        // breakpoints: {
        //     380: {
        //         freeMode: false,
        //         slidesPerView: 2,

        //     },
        //     400: {
        //         freeMode: true,
        //         slidesPerView: "auto",

        //     },
        //     1000: {
        //         freeMode: true,
        //         slidesPerView: "auto",

        //     }
        // },
    });
});
