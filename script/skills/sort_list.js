export function sortList() {

    $('.skills_input_wrap').on("input", "input", function () {
        const inputText = $(this).val().toLowerCase().trim();

        // Получаем список элементов внутри .list_input текущего блока
        const $currentWrap = $(this).closest(".skills_input_wrap");
        const $listItems = $currentWrap.find(".list_input li");

        // Фильтруем список
        $listItems.each(function () {
            const listItemText = $(this).text().toLowerCase();

            if (listItemText.includes(inputText)) {
                $(this).show(); // Показываем, если текст совпадает
            } else {
                $(this).hide(); // Скрываем, если текст не совпадает
            }
        });
    });
}




