export function choseTags() {
    const $input = $(".tags_input_wrap input[name='tags']");
    const $tagsList = $(".tags_input_wrap #tags_list");


    // Обработка выбора тега
    $("#tags_list li").on("click", function () {

        // Убираем класс active у всех li
        $("#tags_list li").removeClass("active");

        const selectedTag = $(this).text(); // Получаем текст выбранного тега
        $input.val(selectedTag); // Вставляем его в input
        $(this).addClass("active"); // Назначаем класс active
        $tagsList.css("display", "none") // Закрываем список
    });
}


