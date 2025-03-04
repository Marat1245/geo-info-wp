import {updateToolbarButtons} from "./update_btn.js";
import {cleanBoldSpans} from "./clean_bold_span_in_h.js";

// Переключаем блоки на нужные
export const wrapBlockWith = (block, tagName, className = "", editor) => {
    // Сохраняем текущее выделение (range)
    const selection = window.getSelection();
    const range = selection.getRangeAt(0); // Берем текущий выделенный диапазон

    // Сохраняем начало и конец выделения
    const startOffset = range.startOffset;
    const endOffset = range.endOffset;

    // Создаем новый элемент
    let newEl = document.createElement(tagName);

    if (className) {
        newEl.classList.remove();
        newEl.classList.add(className, "tag_editor_wrap");
    }

    // Если это список, удаляем все li внутри
    if (tagName !== "UL" && tagName !== "OL" && (block.tagName === "UL" || block.tagName === "OL")) {
        const liElements = block.querySelectorAll("li");
        liElements.forEach((li, index) => {
            // Создаем новый текстовый узел с содержимым li
            newEl.appendChild(document.createTextNode(li.innerText)); // Используем appendChild для текста
            // Добавляем <br> после каждого элемента li, если это не последний элемент
            if (index !== liElements.length - 1) {
                newEl.appendChild(document.createElement("br"));

            }
        });


    } else {
        // Просто копируем содержимое
        console.log(block)
        newEl.innerHTML = block.innerHTML;
        newEl.appendChild(document.createElement("br"));


    }


    // Заменяем старый блок на новый
    block.parentNode.replaceChild(newEl, block);

    cleanBoldSpans(newEl)

    // Восстанавливаем выделение на том же фрагменте текста
    const newTextNode = newEl.firstChild; // Это первый дочерний текстовый узел

    // Создаем новый диапазон и восстанавливаем выделение
    const newRange = document.createRange();
    newRange.setStart(newTextNode, startOffset); // Устанавливаем начало выделения
    newRange.setEnd(newTextNode, endOffset); // Устанавливаем конец выделения

    // Применяем новый диапазон к выделению
    selection.removeAllRanges(); // Убираем старое выделение
    selection.addRange(newRange); // Восстанавливаем выделение

    updateToolbarButtons(newEl.className.split(" "), editor);

    return newEl;
};