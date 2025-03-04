
$(document).ready(function () {
    // Получаем ширину окна
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;

    // Вешаем обработчик на кнопки и аватары
    $('[data-log="on"]').on("click", function (e) {
        if ($(window).width() > 860) {
            openSelector($(this), e);
            console.log("ddd")
        }

    });

    $(".selector_wrap button").on("click", function (e) {
        if ($(window).width() > 480) {
            openSelector($(this), e);
        }

    });

    function openSelector(clickedElement, e) {
        e.stopPropagation(); // Останавливаем всплытие клика

        const parent = clickedElement.closest(".selector_wrap"); // Находим родителя 
        const selector = parent.find(".selector"); // Ищем связанный `.selector`

        // Закрываем все `.selector`, кроме текущего
        $(".selector").not(selector).css({ display: "none" }); // Скрываем все остальные
        // console.log('Закрываем все `.selector`, кроме текущего')

        // Переключаем отображение текущего `.selector`
        if (selector.css("display") === "none") {
            selector.css({ display: "block" }); // Показываем.

        } else {
            selector.css({ display: "none" }); // Скрываем


        }

        // Проверяем, где был клик по горизонтали
        if (e.clientX > screenWidth / 2) {
            // Если клик был на второй половине экрана
            selector.css({ left: "auto" });
            selector.css({ right: 0 });
        } else {
            // Если клик был на первой половине экрана
            selector.css({ left: 0 });
            selector.css({ right: "auto" });
        }

        // Проверяем, где был клик по вертикали
        if (e.clientY > screenHeight / 2) {
            // Если клик был на нижней половине экрана
            selector.css({ top: "auto" });
            selector.css({ bottom: "5rem" });
        } else {
            // Если клик был на верхней половине экрана
            selector.css({ top: "5rem" });
            selector.css({ bottom: "auto" });
        }
    }

    // Переключение видимости между `.selector_first` и `.selector_second`
    $(document).on("click", '[data-li="share"], [data-li="share"] *', function () {
        const parent = $(this).closest(".selector");
        parent.find(".selector_first").hide(); // Скрыть первую секцию
        parent.find(".selector_second").show(); // Показать вторую секцию
    });

    $(document).on("click", ".back_list, .back_list *", function () {
        const parent = $(this).closest(".selector");
        parent.find(".selector_second").hide(); // Скрыть вторую секцию
        parent.find(".selector_first").show(); // Показать первую секцию
    });


    // Закрытие .selector
    $(document).on("click", function (e) {
        const clickedElement = $(e.target);

        // Если клик был вне `.selector`, закрываем его
        if (!clickedElement.closest('.selector').length || $(clickedElement).is('.selector li')) {
            $(".selector").css({ display: "none" }); // Закрываем все `.selector`

        }

        // Если клик по элементу с атрибутом data-li="share", предотвращаем дальнейшее выполнение
        if (clickedElement.closest('[data-li="share"]').length || clickedElement.closest('.back_list').length) {
            return false; // Возвращаем false, чтобы предотвратить выполнение следующих действий
        }

    });




});


$(document).ready(function () {
    const bgDarkMobile = $(".bg_dark_mobile_selector");

    $(document).on("click", ".selector_wrap button, .plus_item", function (e) {
        if ($(window).width() < 480) {

            bgDarkMobile.addClass("active"); // Показываем затемнённый фон
            $(".mobile_selector_wrap").css({ bottom: 0 });
            $("body").css({ overflow: "hidden" }); // Блокируем прокрутку
        }

    });


    // Закрытие меню
    function closeMenu() {
        bgDarkMobile.removeClass("active"); // Скрываем затемнённый фон
        $(".mobile_selector_wrap").css({ bottom: "-100%" });
        $("body").css({ overflow: "auto" }); // Блокируем прокрутку
    }

    // Обработчик клика на затемнённый фон
    $(document).on("click", ".bg_dark_mobile_selector, .mobile_selector_wrap li", function (e) {
        const clickedElement = $(e.target);
        const listMobile = $(".mobile_selector *")

        // Если клик по элементу с атрибутом data-li="share", предотвращаем дальнейшее выполнение
        if (clickedElement.closest('[data-li="share"]').length || clickedElement.closest('.back_list').length) {
            return false; // Возвращаем false, чтобы предотвратить выполнение следующих действий
        }
        listMobile.remove();
        closeMenu();
    });



    // Переключение видимости между `.selector_first` и `.selector_second`
    $(document).on("click", '[data-li="share"], [data-li="share"] *', function () {
        const parent = $(this).closest(" .mobile_selector");
        parent.find(".selector_first").hide(); // Скрыть первую секцию
        parent.find(".selector_second").show(); // Показать вторую секцию
    });

    $(document).on("click", ".back_list, .back_list *", function () {
        const parent = $(this).closest(".mobile_selector ");
        parent.find(".selector_second").hide(); // Скрыть вторую секцию
        parent.find(".selector_first").show(); // Показать первую секцию
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
            console.log("Swipe down detected");
            closeMenu(); // Закрыть меню
        }
    }


});




