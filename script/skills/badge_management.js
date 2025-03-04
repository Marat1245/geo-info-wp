export function badgeManagement() {
    // Обработка клика по элементам списка
    $(".skills_input_wrap").on("click", ".list_input li", function () {
        const $img = $(this).find("img"); // Находим img внутри li
        const skillText = $(this).text().trim(); // Получаем текст навыка

        if ($img.hasClass("list_input_active")) {
            // Если класс уже есть, убираем его и удаляем бейдж
            $img.removeClass("list_input_active");
            $(".badges_wrap").find(`.badge:contains('${skillText}')`).remove();
        } else {
            // Если класса нет, добавляем и создаём бейдж
            $img.addClass("list_input_active");

            appendBadge(skillText);


        }
    });


}
export function appendBadge(skillText) {
    // Создаём бейдж
    const badgeHTML = `
    <div class="badge">
        <span>${skillText}</span>
        <img src="./img/icons/delete_20.svg" alt="Удалить">
    </div>`;
    $(".badges_wrap").append(badgeHTML);
}
