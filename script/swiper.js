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

document.addEventListener('DOMContentLoaded', function () {
    // Объект для хранения экземпляров Swiper
    const swipers = {};

    // Функция инициализации Swiper
    function initSwiper(container) {
        const swiperId = 'swiper-' + Math.random().toString(36).substr(2, 9);
        container.setAttribute('data-swiper-id', swiperId);

        swipers[swiperId] = new Swiper(container, {
            // Ваши настройки Swiper
            slidesPerView: "auto",
            loop: true, // Включение бесконечной прокрутки
            loopAdditionalSlides: 1, // Дополнительные слайды для плавности
            loopedSlides: 3, // Количество клонируемых слайдов            


            pagination: {
                el: container.querySelector('.swiper-pagination'),
                clickable: true,
            },
            // Важные параметры для динамического контента:
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            // Дополнительные параметры:
            preventClicks: false, // Разрешить клики по элементам внутри слайдов
            preventClicksPropagation: false, // Разрешить всплытие событий клика
        });
    }

    // Инициализация всех существующих слайдеров при загрузке
    document.querySelectorAll('.mySwiper').forEach(swiperEl => {
        initSwiper(swiperEl);
    });

    // Для динамически подгружаемых слайдеров используем MutationObserver
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                if (node.nodeType === 1) { // Проверяем только элементы
                    const newSwipers = node.querySelectorAll ? node.querySelectorAll('.mySwiper') : [];
                    newSwipers.forEach(swiperEl => {
                        if (!swiperEl.hasAttribute('data-swiper-id')) {
                            initSwiper(swiperEl);
                        }
                    });
                }
            });
        });
    });

    // Начинаем наблюдение за изменениями в body
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Функция для ручной инициализации новых слайдеров
    window.initNewSwipers = function (container) {
        const newSwipers = container.querySelectorAll('.mySwiper:not([data-swiper-id])');
        newSwipers.forEach(swiperEl => {
            initSwiper(swiperEl);
        });
    };
});