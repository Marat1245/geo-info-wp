export function pastTitle (){
    const createPostTitle = document.getElementById("create_post_title");

    createPostTitle.addEventListener('paste', function(event) {
        // Предотвращаем стандартное поведение (вставка текста)
        event.preventDefault();

        // Получаем текст из буфера обмена
        const pastedText = event.clipboardData.getData('text/plain');

        // Если вставлено текстовое содержимое
        if (pastedText) {
            // Получаем текущее выделение
            const selection = window.getSelection();
            const range = selection.getRangeAt(0);

            // Создаем текстовый узел с вставляемым текстом
            const textNode = document.createTextNode(pastedText);

            // Вставляем текстовый узел в диапазон
            range.deleteContents(); // Удаляем выделенный текст, если он есть
            range.insertNode(textNode);

            // Устанавливаем курсор после вставленного текста
            range.setStartAfter(textNode);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    });


}