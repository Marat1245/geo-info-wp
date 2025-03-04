export function manageDelete() {
    const $input = $("input[name='tags']");
    const $deleteButton = $("#delet_tag");


    // Обработка выбора тега
    $("#tags_list li").on("click", function () {

        // Показываем кнопку удаления
        $deleteButton.show();

    });

    // Удаление тега
    $deleteButton.on("click", function () {
        // Убираем класс active с выбранного li
        $("#tags_list li.active").removeClass("active");

        // Очищаем текст в input
        $input.val("");

        // Скрываем кнопку удаления
        $deleteButton.hide();

    });
}
