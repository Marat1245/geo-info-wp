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

        // Если вставляется HTML-код
        // const pastedHTML = clipboardData.getData("text/html");
        // if (pastedHTML) {
        //     const parser = new DOMParser();
        //     const doc = parser.parseFromString(pastedHTML, "text/html");
        //
        //     // Проходим по каждому элементу внутри <body>, сохраняя порядок
        //     doc.body.childNodes.forEach((node) => {
        //         console.log(node.nodeName)
        //         if (node.nodeName === "IMG") {
        //             // Если это простой <img> узел
        //             pastedItems.push({ type: "image", data: node.src });
        //
        //
        //         } else if (node.nodeType === Node.TEXT_NODE) {
        //             // Если это текстовый узел
        //             const text = node.textContent.trim();
        //             if (text) {
        //                 pastedItems.push({ type: "text", data: text });
        //             }
        //         } else if (node.nodeType === Node.ELEMENT_NODE) {
        //             // Если это элемент (например, <div>, <p>)
        //             // Сначала извлекаем текст из элемента
        //             const text = node.innerText.trim();
        //             if (text) {
        //                 pastedItems.push({ type: "text", data: text });
        //             }
        //
        //             // Теперь проверяем, есть ли в этом элементе изображения
        //             const images = node.querySelectorAll("img");
        //             images.forEach((img) => {
        //                 pastedItems.push({ type: "image", data: img.src });
        //             });
        //         }
        //
        //     });
        //
        //     processPastedItems(editor, pastedItems);
        //     return;
        // }


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
    console.log("📋 Вставленные данные:", items);

    items.forEach((item) => {
        console.log(item);
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


