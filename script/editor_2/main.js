import { mergeSpan } from './merge_span.js';
import { updateToolbarButtons} from './update_btn.js';
import {getSelectedClass} from './get_selected_class.js';
import {wrapBlockWith} from './wrap_block_with.js';
import {createPAfterInput} from "./create_paragraph.js";
import {deleteSpanWithStyle} from "./delet_span_with_style.js";
import {getCurrentBlock} from "./get_current_block.js";
import {cleanBoldSpans } from "./clean_bold_span_in_h.js";
import {highlight} from "./highlight.js";
import { replaceDivAfterH2 } from "./replace_div_after_h2.js";
import {captionViewModel} from "./caption.js";
import {ToolbarViewModel} from "./toolbar_position.js";
import {updateButtonHeightInit} from "./update _button_height.js";
import {insertCroppedImage, insertImg} from "./img_insert.js";
import {handleEnterInCaption} from "./img_manage.js";
import {initDragAndDrop} from "./drag_drop.js";
import {showSetting} from "./show_setting.js";
import {past} from "./past.js";
import {editImg} from "./edit_img.js";
import {updateFixBlockPosition} from "./update_fix_block_position.js";
import {pastTitle} from "./past/past_title.js";
import {scaleImg} from "./scale_img.js";


document.addEventListener("DOMContentLoaded", () => {

    const editor = document.getElementById("editor");
    if (!editor) {
        return
    }
    if (!editor.innerHTML.trim()) {
        editor.innerHTML = "<p class='paragraph tag_editor_wrap'><br></p>";
        editor.focus();
    }
    const toolbar = document.getElementById("toolbar");

    const blockTags = ["P", "H2", "H3", "UL", "OL", "BLOCKQUOTE", "DIV"];



    const insertAfter = (newNode, referenceNode) => {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    };





    function selectElement(element) {
        let classListArray = []; // Массив для классов
        const range = document.createRange();
        const selection = window.getSelection();

        range.selectNodeContents(element); // Выделяем весь контент элемента
        selection.removeAllRanges();
        selection.addRange(range);

        const elementClass = element.className; // Получаем класс элемента
        classListArray.push(elementClass); // Добавляем класс в массив

        return classListArray; // Возвращаем сам элемент
    }
    const getSelectedNodes = (range) => {
        let nodes = [];
        let treeWalker = document.createTreeWalker(
            range.commonAncestorContainer, // корневой узел
            NodeFilter.SHOW_ELEMENT | NodeFilter.SHOW_TEXT, // элементы и текстовые узлы
            {
                acceptNode: (node) => range.intersectsNode(node) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT
            }
        );

        while (treeWalker.nextNode()) {
            nodes.push(treeWalker.currentNode);
        }

        // Если выделение состоит из одного текстового узла, добавляем его родителя
        if (nodes.length === 1 && nodes[0].nodeType === Node.TEXT_NODE) {
            let parent = nodes[0].parentNode;
            if (parent && parent.nodeType === Node.ELEMENT_NODE) {
                nodes.push(parent);
            }
        }

        return nodes;
    };


    const toggleInline = (command) => {
        let sel = window.getSelection();
        if (!sel.rangeCount || sel.isCollapsed) return;

        let range = sel.getRangeAt(0);
        const parentElement = range.commonAncestorContainer;
        let selectedNodes = getSelectedNodes(range); // Получаем все узлы в выделении
        let hasCommand = selectedNodes.some(node => node.nodeType === 1 && node.classList.contains(command));

        

        if (hasCommand) {
            // Если уже есть блок с этим классом → убираем его
            selectedNodes.forEach(node => {
                if (node.nodeType === 1 && node.classList.contains(command)) {
                    node.replaceWith(...node.childNodes); // Удаляем тег, оставляем содержимое
                    const selectedClasses = getSelectedClass();
                    updateToolbarButtons(selectedClasses, editor)
                }
            });
        } else {
            // проверяем что не создам внутри себя же один и тот же объект
            if (parentElement.parentElement.classList.contains(command) || (parentElement.className && parentElement.className.includes(command))) {
                return
            }
            setTimeout(() =>{
                // Если такого блока нет → создаем новый
                let span = document.createElement("span");
                span.classList.add(command);
                let extracted = range.extractContents();
                span.appendChild(extracted);
                range.insertNode(span);


                mergeSpan(sel);
                const selectedElement = selectElement(span)
                updateToolbarButtons(selectedElement, editor);

            }, 20)

        }


    };


    const convertToList = (block, listType) => {
      

        // Создаём новый список
        let list = document.createElement(listType);

        // Добавляем классы в зависимости от типа списка
        list.classList.add(listType.toLowerCase(), "tag_editor_wrap");

        // Если блок уже содержит <li>, просто переносим их в новый список
        if (block.querySelector("li")) {
            while (block.firstChild) {
                list.appendChild(block.firstChild);
            }
        } else {
            // Если внутри нет <li>, создаём один <li> и кладём туда содержимое
            let li = document.createElement("li");
            li.innerHTML = block.innerHTML;
            list.appendChild(li);
        }

        // Заменяем старый элемент новым списком
        block.parentNode.replaceChild(list, block);
    };


    const toggleBlock = (command) => {
        let targetTag;
        let extraClass = "";
        switch (command) {
            case "p":
                targetTag = "P";
                extraClass = "paragraph";
                break;
            case "blockquote":
                targetTag = "BLOCKQUOTE";
                extraClass = "blockquote";
                break;
            case "ol":
                targetTag = "OL";
                extraClass = "ol";
                break;
            case "ul":
                targetTag = "UL";
                extraClass = "ul";
                break;
            case "highlight":
                targetTag = "DIV";
                extraClass = "highlight";
                break;
            case "h2":
                targetTag = "H2";
                extraClass = "h2";
                break;
            case "h3":
                targetTag = "H3";
                extraClass = "h3";
                break;
            default:
                return; // Если команда не совпала, выходим
        }
        let block = getCurrentBlock(editor);
        if (!block || !blockTags.includes(block.tagName)) return;
        if (block.tagName === targetTag && (extraClass === "" || block.classList.contains(extraClass))) {
            wrapBlockWith(block, "P", "paragraph" ,editor);
        } else if (targetTag === "OL" || targetTag === "UL") {
            convertToList(block, targetTag);
        } else {
            let newBlock = wrapBlockWith(block, targetTag, extraClass, editor);
            return newBlock;
        }

    };

    const insertImage = () => {
        const url = prompt("Введите URL изображения:");
        if (!url) return;
        let sel = window.getSelection();
        if (!sel.rangeCount) return;
        let range = sel.getRangeAt(0);
        let img = document.createElement("img");
        img.src = url;
        range.collapse(false);
        range.insertNode(img);
        range.setStartAfter(img);
        sel.removeAllRanges();
        sel.addRange(range);
    };



    toolbar.addEventListener("click", (e) => {
        const button = e.target.closest("button[data-command]");

        if (button) {
            let command = button.getAttribute("data-command");

            if (command === "bold" || command === "italic") toggleInline(command);
            else if (["bold", "italic", "p", "h2", "h3", "ol", "ul", "blockquote", "highlight"].includes(command)) toggleBlock(command);
            else if (command === "insertImage") insertImage();



        }
    });


    // Обновляет классы у кнопок в тулбаре при клике
    toolbar.addEventListener("mouseup", () => {
        const selectedClasses = getSelectedClass();
        updateToolbarButtons(selectedClasses, editor)
    });

    // Обновляет классы у кнопок в тулбаре при клике
    editor.addEventListener("mouseup", () => {
        const selectedClasses = getSelectedClass();
        updateToolbarButtons(selectedClasses, editor)
    });

    // Склеиваем несколько текстовых узлов
    const buttons = document.querySelectorAll("#toolbar button[data-command]");
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            editor.normalize();
        })

    })



    deleteSpanWithStyle(editor);
    createPAfterInput(editor);
    highlight(editor);
    replaceDivAfterH2(editor);
    captionViewModel();
    new ToolbarViewModel()
    updateButtonHeightInit(editor);
    insertImg(editor);
    handleEnterInCaption();
    initDragAndDrop();
    showSetting();
    past(editor);
    editImg(editor);
    updateFixBlockPosition();
    pastTitle();
    scaleImg(editor);




});