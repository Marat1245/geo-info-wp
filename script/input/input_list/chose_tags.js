export function choseTags(wrap) {
    const $input = $(wrap).find("input");
    const $tagsList = $(wrap).find(".t_list_input");

    // Обработка выбора тега
    $tagsList.find("li").on("click", function () {
        // Убираем класс active у всех li
        $tagsList.find("li").removeClass("active");

        const selectedTag = $(this).text(); // Получаем текст выбранного тега
        $input.val(selectedTag); // Вставляем его в input
        $(this).addClass("active"); // Назначаем класс active
    });
}
