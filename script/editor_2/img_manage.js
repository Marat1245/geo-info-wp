
import {setCaretAtStart} from "./set_caret_at_start.js";

export function handleEnterInCaption() {
    // Находим родительский элемент, например, редактор или контейнер
    const editor = document.getElementById('editor'); // или любой другой родительский контейнер, который существует в момент загрузки

    editor.addEventListener('keydown', (event) => {
        // Проверяем, что нажата клавиша Enter
        if (event.key === 'Enter') {

            // Проверяем, что элемент с фокусом является .input-caption
            if (event.target.classList.contains('input-caption')) {
                event.preventDefault(); // Отменяем стандартное поведение Enter (создание новой строки)

                // Ищем родительский контейнер с классом tag_editor_wrap
                let parent = event.target.closest('.tag_editor_wrap');

                if (parent) {
                    // Создаем новый <p> элемент
                    const newParagraph = document.createElement('p');
                    newParagraph.classList.add("paragraph", "tag_editor_wrap");
                    // newParagraph.setAttribute('tabindex', '0');
                    newParagraph.innerHTML = '<br>';  // Добавляем <br> для пустого абзаца
                    // Вставляем новый <p> после текущего блока
                    insertAfter(newParagraph, parent); // Вставляем новый <p> после родительского контейнера .input-caption

                    setCaretAtStart(parent.nextSibling);


                }
            }
        }
    });
    deleteImg();
}
// Функция вставки узла после другого узла
const insertAfter = (newNode, referenceNode) => {
    if (referenceNode.parentNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }
};
export function deleteImg(){
    document.addEventListener("click", (event) => {
        const deleteButton = event.target.closest(".delete_img");

        if (deleteButton) {
            const imageContainer = deleteButton.closest(".image-container");
            imageContainer.remove();
        }
    });

}