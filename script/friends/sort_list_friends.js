export function sortList(wrap, id, item) {

    $(wrap).on("input", id, function () {
        const inputText = $(this).val().toLowerCase().trim();

        // Получаем список элементов внутри .list_input текущего блока
        const $currentWrap = $(this).closest(wrap);
        const $itemNames = $currentWrap.find(item);

        // Фильтруем список
        $itemNames.each(function () {
            const listItemText = $(this).text().toLowerCase();

            if (listItemText.includes(inputText)) {
                $(this).show(); // Показываем, если текст совпадает
            } else {
                $(this).hide(); // Скрываем, если текст не совпадает
            }
        });
    });
}
