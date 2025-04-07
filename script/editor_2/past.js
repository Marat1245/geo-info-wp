import { captionViewModel } from "./caption.js";
import { imgBlock } from "./component/img_block.js";
import { checkLastParagraph } from "./create_paragraph.js";

export function past(editor) {
    editor.addEventListener("paste", function (event) {
        event.preventDefault();

        const clipboardData = event.clipboardData;
        let pastedItems = [];

        // Если вставляются файлы (например, изображения)
        if (clipboardData.files.length > 0) {
            [...clipboardData.files].forEach((file) => {
                const reader = new FileReader();
                reader.onloadend = function () {
                    pastedItems.push({ type: "image", data: reader.result });
                    // processPastedItems(editor, pastedItems);
                    insertImage(editor, reader.result);
                };
                reader.readAsDataURL(file);
            });
            return;
        }


        // Если вставляется только текст
        const pastedText = clipboardData.getData("text/plain");
        if (pastedText) {
            pastedItems.push({ type: "text", data: pastedText });
            processPastedItems(editor, pastedItems);
        }
    });
}

// Функция обработки вставленных данных
function processPastedItems(editor, items) {
  

    items.forEach((item) => {
       
        if (item.type === "image") {
            insertImage(editor, item.data);

        } else if (item.type === "text") {
            insertText(editor, item.data);
        }
    });
}

// Функция вставки изображения
function insertImage(editor, imageUrl) {
    const imageWrapper = imgBlock(imageUrl);
    const selection = window.getSelection();
    const currentElement = selection.focusNode;
    const parentElement = currentElement.closest(".tag_editor_wrap");

    if (parentElement) {
        parentElement.parentNode.insertBefore(imageWrapper, parentElement.nextSibling);
        parentElement.remove();
    } else {
        editor.appendChild(imageWrapper);
    }

    captionViewModel();
    checkLastParagraph(editor);
}

// Функция вставки текста
function insertText(editor, text) {
    const paragraphs = text.split("\n").map((line) => {
        const p = document.createElement("p");
        p.classList.remove()
        p.classList.add("paragraph", "tag_editor_wrap");
        p.textContent = line;
        return p;
    });

    const selection = window.getSelection();
    const currentElement = selection.focusNode;
    const parentElement = currentElement.closest(".tag_editor_wrap");

    if (parentElement) {
        paragraphs.forEach((p) => parentElement.parentNode.insertBefore(p, parentElement.nextSibling));
        parentElement.remove();
    } else {
        paragraphs.forEach((p) => editor.appendChild(p));
    }

    captionViewModel();
    checkLastParagraph(editor);
}


