$(document).ready(function () {
    // Получаем ширину окна
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;

    // Вешаем обработчик на кнопки и аватары через делегирование
    $(document).on("click", '[data-log="on"]', function (e) {
        if ($(window).width() > 760) {
            openSelector($(this), e);
        }
    });

    // Обработчик для кнопок селектора через делегирование
    $(document).on("click", ".selector_wrap button", function (e) {
        if ($(window).width() > 480) {
            openSelector($(this), e);
        }
    });

    function openSelector(clickedElement, e) {
        e.stopPropagation(); // Останавливаем всплытие клика

        const parent = clickedElement.closest(".selector_wrap"); // Находим родителя 
        const selector = parent.find(".selector"); // Ищем связанный `.selector`
        const button = parent.find("button"); // Находим кнопку

        // Закрываем все `.selector`, кроме текущего
        $(".selector").not(selector).css({ display: "none" });

        // Переключаем отображение текущего `.selector`
        if (selector.css("display") === "none") {
            selector.css({ display: "block" });

            // Получаем размеры и позиции элементов
            const buttonRect = button[0].getBoundingClientRect();
            const selectorRect = selector[0].getBoundingClientRect();
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            // Вычисляем позицию по горизонтали с учетом скролла
            let left = buttonRect.left + scrollLeft;
            if (left + selectorRect.width > windowWidth) {
                left = windowWidth - selectorRect.width;
            }

            // Вычисляем позицию по вертикали с учетом скролла
            let top = buttonRect.bottom + scrollTop + 5; // 5px отступ от кнопки
            if (top + selectorRect.height > windowHeight + scrollTop) {
                top = buttonRect.top + scrollTop - selectorRect.height - 5; // Показываем над кнопкой
            }

            // Применяем позицию
            selector.css({
                position: 'absolute', // Меняем на absolute
                left: left + 'px',
                top: top + 'px'
            });




        } else {
            selector.css({ display: "none" });
        }
    }

    // Переключение видимости между `.selector_first` и `.selector_second` через делегирование
    $(document).on("click", '[data-li="share"], [data-li="share"] *', function () {
        const parent = $(this).closest(".selector");
        parent.find(".selector_first").hide();
        parent.find(".selector_second").show();
    });

    $(document).on("click", ".back_list, .back_list *", function () {
        const parent = $(this).closest(".selector");
        parent.find(".selector_second").hide();
        parent.find(".selector_first").show();
    });

    // Закрытие .selector через делегирование
    $(document).on("click", function (e) {
        const clickedElement = $(e.target);

        // Если клик был вне `.selector`, закрываем его
        if (!clickedElement.closest('.selector').length || $(clickedElement).is('.selector li')) {
            $(".selector").css({ display: "none" });
        }

        // Если клик по элементу с атрибутом data-li="share", предотвращаем дальнейшее выполнение
        if (clickedElement.closest('[data-li="share"]').length || clickedElement.closest('.back_list').length) {
            return false;
        }
    });
});

$(document).ready(function () {
    const bgDarkMobile = $(".bg_dark_mobile_selector");

    // Обработчик для мобильных селекторов через делегирование
    $(document).on("click", ".selector_wrap button, .plus_item", function (e) {
        if ($(window).width() < 480) {
            bgDarkMobile.addClass("active");
            $(".mobile_selector_wrap").css({ bottom: 0 });
            $("body").css({ overflow: "hidden" });
        }
    });

    // Закрытие меню
    function closeMenu() {
        bgDarkMobile.removeClass("active");
        $(".mobile_selector_wrap").css({ bottom: "-100%" });
        $("body").css({ overflow: "auto" });
    }

    // Обработчик клика на затемнённый фон через делегирование
    $(document).on("click", ".bg_dark_mobile_selector, .mobile_selector_wrap li", function (e) {
        const clickedElement = $(e.target);
        const listMobile = $(".mobile_selector *");

        // Если клик по элементу с атрибутом data-li="share", предотвращаем дальнейшее выполнение
        if (clickedElement.closest('[data-li="share"]').length || clickedElement.closest('.back_list').length) {
            return false;
        }
        listMobile.remove();
        closeMenu();
    });

    // Переключение видимости между `.selector_first` и `.selector_second` для мобильной версии через делегирование
    $(document).on("click", '[data-li="share"], [data-li="share"] *', function () {
        const parent = $(this).closest(".mobile_selector");
        parent.find(".selector_first").hide();
        parent.find(".selector_second").show();
    });

    $(document).on("click", ".back_list, .back_list *", function () {
        const parent = $(this).closest(".mobile_selector");
        parent.find(".selector_second").hide();
        parent.find(".selector_first").show();
    });

    const mobileMenu = $(".mobile_selector_wrap");

    let startX = 0;
    let startY = 0;
    let endX = 0;
    let endY = 0;

    // Отслеживание начала касания
    mobileMenu.on("touchstart", function (e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    });

    // Отслеживание завершения свайпа
    mobileMenu.on("touchend", function (e) {
        endX = e.changedTouches[0].clientX;
        endY = e.changedTouches[0].clientY;
        handleSwipe();
    });

    // Логика для обработки свайпа
    function handleSwipe() {
        const diffX = endX - startX;
        const diffY = endY - startY;

        // Свайп сверху вниз
        if (Math.abs(diffY) > Math.abs(diffX) && diffY > 50) {
            closeMenu();
        }
    }
});




