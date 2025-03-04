// Получаем массив с выделенными узлами и делаем актив для кнопок в тулбаре
import {getCurrentBlock} from "./get_current_block.js";


export function updateToolbarButtons(selectedClasses, editor) {
    const buttons = document.querySelectorAll("#toolbar button[data-command]");
    const block = getCurrentBlock(editor);

    if(!selectedClasses || !block) {
        return
    }
    buttons.forEach(button => {
        const command = button.getAttribute("data-command");


        // Если у выделенного текста есть этот класс, добавляем 'active', иначе убираем
        if (selectedClasses.includes(command) || block.className.includes(command) ) {
            button.classList.add("active_toolbar");
        } else {
            button.classList.remove("active_toolbar");
        }

        // 🔹 Если есть 'bold', отключаем 'italic', и наоборот
        if (selectedClasses.includes("bold") && selectedClasses.includes("italic")) {
            button.disabled = false;
        } else if (selectedClasses.includes("bold") && command === "italic") {
            button.disabled = true;
        } else if (selectedClasses.includes("italic") && command === "bold") {
            button.disabled = true;
        } else if (selectedClasses.includes("h2") && command === "bold") {
            button.disabled = true;
        } else if (selectedClasses.includes("h3") && command === "bold") {
            button.disabled = true;
        } else {
            button.disabled = false;
        }
    });
}

