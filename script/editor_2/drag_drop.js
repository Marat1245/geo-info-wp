import {checkLastParagraph} from "./create_paragraph.js";
import {updateButtonHeight} from "./update _button_height.js";

const editor = document.getElementById("editor");
let draggedElement = null;

function handleDragStart(event) {
    draggedElement = event.target.closest(".tag_editor_wrap");
    event.dataTransfer.effectAllowed = "move";
    setTimeout(() => draggedElement.classList.add("dragging"), 0);
}

function handleDragEnd() {
    if (draggedElement) {
        draggedElement.classList.remove("dragging");
        removeDropIndicators();
        draggedElement = null;
    }
}

function handleDragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = "move";

    if (!draggedElement) return; // Защита от ошибок

    const afterElement = getDragAfterElement(editor, event.clientY);

    removeDropIndicators();

    if (afterElement) {
        afterElement.closest(".tag_editor_wrap").classList.add("before-drop");
    } else {
        editor.lastElementChild.classList.add("after-drop");
    }
}

function handleDrop(event) {
    event.preventDefault();
    removeDropIndicators();
    if (!draggedElement) {
        return
    }

    const afterElement = getDragAfterElement(editor, event.clientY);
    console.log(afterElement)
    if (afterElement) {

        editor.insertBefore(draggedElement, afterElement.closest(".tag_editor_wrap"));
    } else {
        editor.appendChild(draggedElement);
    }
}

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll(":not(.dragging)")];

    let closest = null;
    let closestOffset = Number.NEGATIVE_INFINITY;

    draggableElements.forEach((child) => {
        const box = child.getBoundingClientRect();
        const offset = y - (box.top + box.height / 2);

        if (offset < 0 && offset > closestOffset) {
            closestOffset = offset;
            closest = child;
        }
    });

    return closest;
}

function removeDropIndicators() {
    document.querySelectorAll(".before-drop, .after-drop").forEach((el) => {
        el.classList.remove("before-drop", "after-drop");
    });
}

export function initDragAndDrop() {
    editor.addEventListener("dragstart", (event) => {
        if (event.target.parentElement.classList.contains("image-container")) {
            handleDragStart(event);
        }
    });

    editor.addEventListener("dragend", (event) => {
        if (event.target.parentElement.classList.contains("image-container")) {
            handleDragEnd(event);
        }
    });

    editor.addEventListener("dragover", handleDragOver);
    editor.addEventListener("drop", handleDrop);

    checkLastParagraph(editor);
    updateButtonHeight(editor);
}
