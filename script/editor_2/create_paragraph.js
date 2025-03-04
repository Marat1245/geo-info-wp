import {getCurrentBlock} from "./get_current_block.js";
import {setCaretAtStart} from "./set_caret_at_start.js";

// Создаем первый блок <p> если в editor ничего нет
export const createPAfterInput = (editor) =>{
    const buttons = document.querySelectorAll("#toolbar button[data-command]");
    editor.addEventListener("input", () => {

            let block = getCurrentBlock();
            let allOtherElements = editor.children; // Получаем все дочерние элементы редактора


            // Проверяем, что есть только один <p> и его содержимое пустое, а других элементов нет
            if (allOtherElements.length === 1 && allOtherElements[0].innerText.trim() === '' ){
                editor.innerHTML = "<p class='paragraph tag_editor_wrap'><br></p>";
                block = editor.firstChild;
                setCaretAtStart(block);
            }
            checkLastParagraph(editor)

    });

    buttons.forEach(button => {
        button.addEventListener("mouseup", () => {
            setTimeout(() => checkLastParagraph(editor), 10);
        })

    });

}

export function checkLastParagraph(editor) {
    let lastElement = editor.lastElementChild; // Берем последний элемент

    // Проверяем, является ли последний элемент <p> и содержит ли только <br>
    if (!lastElement || lastElement.tagName !== "P") {
        let newParagraph = document.createElement("p");
        newParagraph.classList.add("paragraph", "tag_editor_wrap");
        newParagraph.innerHTML = "<br>";

        editor.appendChild(newParagraph);


    }
}