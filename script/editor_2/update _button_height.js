
export const updateButtonHeight = (editor) => {
    const buttonWrap = document.querySelector(".editor_img_btn");

    if (!editor || !buttonWrap) return; // Проверяем, существуют ли элементы

    let totalHeight = 0;
    const childrenBlock = Array.from(editor.children);

    // Определяем, где находится курсор
    const selection = window.getSelection();
    let cursorBlock = null;

    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        cursorBlock = range.startContainer.nodeType === 3
            ? range.startContainer.parentElement // Если курсор внутри текста, берём родителя
            : range.startContainer; // Если нет, берём сам контейнер
    }

    // if (!cursorBlock) return; // Если не нашли курсор, ничего не меняем

    let foundCursor = false;

    for (let block of childrenBlock) {
        totalHeight += block.getBoundingClientRect().height + 20; // Считаем высоту блоков

        if (block === cursorBlock) {
            foundCursor = true;

            // Если блок пустой, показываем кнопку
            if (block.textContent.trim() === "" || block.innerHTML.trim() === "<br>") {
                block.classList.add("show_img");
                buttonWrap.classList.add("show"); // Показываем кнопку
            } else {
                block.classList.remove("show_img");
                buttonWrap.classList.remove("show"); // Скрываем кнопку
            }
            break; // Останавливаемся, как только дошли до блока с курсором
        }

    }

    // Если курсор найден, обновляем высоту кнопки
    if (foundCursor) {
        buttonWrap.style.height = `${totalHeight}px`;
    }

};

export const updateButtonHeightInit = (editor) =>{


    // Запускаем при загрузке страницы
    window.addEventListener("load", () => updateButtonHeight(editor));

    // Запускаем при изменении размера окна
    window.addEventListener("resize", () => updateButtonHeight(editor));

    // Если контент в #editor может меняться динамически (например, при вводе текста),
    // можно использовать MutationObserver или периодическое обновление:
    const observer = new MutationObserver(() => updateButtonHeight(editor));
    observer.observe(document.querySelector("#editor"), { childList: true, subtree: true, characterData: true });

    // Добавляем обработчик ввода, чтобы обновлять высоту динамически
    editor.addEventListener("input", (e) => {
        updateButtonHeight(editor);
    });

    // Добавляем обработчик кликов и перемещения курсора
    editor.addEventListener("keyup", (e) => {
        updateButtonHeight(editor);
    });
    editor.addEventListener("click", (e) => {
        updateButtonHeight(editor);
    });

}
