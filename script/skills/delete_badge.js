export function deleteBadge() {
    // Обработка клика по изображению внутри бейджа (удаление бейджа и класса у соответствующего элемента списка)
    $(".badges_wrap").on("click", ".badge img", function () {
        const $badge = $(this).closest(".badge"); // Получаем родительский бейдж
        const skillText = $badge.find("span").text().trim(); // Текст навыка из бейджа

        // Удаляем бейдж
        $badge.remove();

        // Убираем класс list_input_active у соответствующего элемента списка
        $(".list_input li").each(function () {
            if ($(this).text().trim() === skillText) {
                $(this).find("img").removeClass("list_input_active");
            }
        });
    });
}