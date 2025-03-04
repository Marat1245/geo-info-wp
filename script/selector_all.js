$(document).ready(function () {
    // Найти все ссылки в edit_colum_right > li
    let links = $(".edit_colum_right li a");

    // Получить текущий путь страницы
    let currentPath = window.location.pathname;

    // Сформировать HTML для вставки
    let linksHTML = "";
    links.each(function () {
        let href = $(this).attr("href"); // Получить атрибут href
        let text = $(this).text();       // Получить текст ссылки

        // Проверить, совпадает ли текущий путь с href
        let activeClass = (href === currentPath) ? "active" : "";

        // Сформировать HTML с классом, если нужно
        linksHTML += `<li><a href="${href}" class="${activeClass}">${text}</a></li>`;
    });

    // Вставить сформированный HTML в topMenuMobile
    let topMenuMobile = $(".top_menu_list_btn");
    topMenuMobile.append(`<div class="selector"><ul>${linksHTML}</ul></div>`);
    $(".mobile_selector_wrap .mobile_selector").html(`<ul>${linksHTML}</ul>`)



});

$(document).ready(function () {
    function moveListOnMobile(mobileWrap, buttonToOpenSelector, selector_wrap, selector) {
        const listMobile = $(mobileWrap)
        $(document).on("click", buttonToOpenSelector, function () {
            if ($(window).width() < 480) {
                let ulItems = $(this).closest(selector_wrap).find(selector);
                listMobile.append(ulItems.children().clone());
            }
        });
    }

    moveListOnMobile(".mobile_selector", ".selector_wrap button", ".selector_wrap", ".selector");
    moveListOnMobile(".mobile_selector", ".plus_item", ".area_create_post", ".basic_block")







});
