document.addEventListener("DOMContentLoaded", function () {
    const bgDark = document.querySelector(".bg_dark");
    const mobileMenu = document.querySelector(".mobile_list_menu");
    const menuButton = document.querySelector(".mobile_menu_more");
    const profileButton = document.querySelector("[data-log='on']");
    const body = document.body;

    const isMobile = () => window.innerWidth < 860;


    // Открытие меню
    function toggleMenu() {
        if (menuButton.classList.contains("mobile_menu_item_active")) {
            closeMenu();
        } else {
            show()

        }
    }

    // Закрытие меню
    function closeMenu() {
        bgDark.classList.remove("active"); // Скрываем затемнённый фон
        mobileMenu.classList.remove("active"); // Убираем меню
        body.style.overflow = "auto"; // Восстанавливаем прокрутку
        menuButton.classList.remove("mobile_menu_item_active"); // Убираем активный класс
    }

    // Обработчик клика по кнопке меню
    menuButton.addEventListener("click", function (event) {
        event.preventDefault();
        toggleMenu();
    });
    if(profileButton){
        profileButton.addEventListener("click", function (event) {
            console.log(isMobile())
            if (isMobile() ){
                show()
            }

        })
    }

    // Обработчик клика на затемнённый фон
    bgDark.addEventListener("click", closeMenu);

    // Пересчитываем меню при изменении ширины экрана
    window.addEventListener("resize", () => {
        if (!isMobile()) {
            closeMenu();
        }
    });
    function show(){
        bgDark.classList.add("active"); // Показываем затемнённый фон
        mobileMenu.classList.add("active"); // Показываем меню
        body.style.overflow = "hidden"; // Блокируем прокрутку
        menuButton.classList.add("mobile_menu_item_active"); // Добавляем активный класс
    }
});
