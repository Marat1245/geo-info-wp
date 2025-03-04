// При появлении нескольких span с одинаковым стилями и внутри тоже. МЫ соединяем их

// Слушаем клик по кнопке в #toolbar
export const mergeSpan = (sel) => {
    // Получаем текущее выделение текста
    let selection = sel;

    // Если текст был выделен
    if (!selection.isCollapsed) {
        // Получаем родительский элемент, содержащий выделенный текст
        let parentElement = selection.anchorNode;

        // Идем вверх по DOM-дереву, чтобы найти родительский элемент, в котором содержится выделение
        while (parentElement && parentElement !== document.body) {
            if (parentElement.nodeType === 1 && parentElement.id !== 'editor') {
                // Это родительский элемент, содержащий выделенный текст (не #editor)
                let elements = [];
                // Проходим по всем дочерним элементам внутри этого родителя
                let child = parentElement.firstChild;
                while (child) {
                    if(child.nodeValue !== ""){
                        elements.push(child);  // Добавляем дочерний элемент в массив
                    }
                    child = child.nextSibling;  // Переходим к следующему элементу
                }


                // Теперь объединяем соседние элементы с одинаковым тегом и классом
                for (let i = 0; i < elements.length; i++) {

                    // Если текущий элемент - это элемент, и его тег и класс совпадают с следующим элементом
                    if (elements[i].nodeType === 1 && elements[i] && elements[i+1] && elements[i].className === elements[i+1].className) {

                        // Объединяем их текстовое содержимое
                        if(elements[i+1]){
                            elements[i+1].remove();
                        }
                        elements[i].innerHTML = elements[i].innerHTML + elements[i+1].innerHTML;


                        // Находим вложенный <span> внутри родительского
                        let nestedSpan = elements[i].querySelector("." + elements[i].className);

                        // Удаляем вложенный <span>, но оставляем его содержимое
                        if (nestedSpan) {
                            nestedSpan.replaceWith(...nestedSpan.childNodes);
                        }

                    }



                }
                // Выводим массив элементов
                // console.log(elements);
                break;
            }
            parentElement = parentElement.parentNode;
        }
    }
}