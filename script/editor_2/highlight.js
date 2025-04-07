import {setCaretAtStart} from "./set_caret_at_start.js";

export const highlight = (editor) =>{

    editor.addEventListener("input", (event) => {
        const highlight = document.querySelector(".highlight");
        if (!highlight) return;

        const lastChild = highlight.lastElementChild;

        // Проверяем, является ли последний элемент <br>
        if (!lastChild || lastChild.tagName !== "BR") {
            const br = document.createElement("br");
            highlight.appendChild(br);
          
        }
    })
    editor.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {

            let sel = window.getSelection();
            if (!sel.rangeCount) return;

            let range = sel.getRangeAt(0);
            const cursorContainer = range.startContainer;
            let currentElement = range.commonAncestorContainer;

            // Если курсор внутри текстового узла, берем родителя
            if (currentElement.nodeType === Node.TEXT_NODE) {
                currentElement = currentElement.parentElement;
            }

            if( !currentElement.matches(".highlight")){
                return
            }
            event.preventDefault(); // Отменяем стандартное поведение Enter
            // Проверяем, является ли элемент пустым .highlight или <li>
            if (currentElement && currentElement.innerText.trim() === "") {

                let newParagraph = document.createElement("p");
                newParagraph.innerHTML = "<br>";

                // Заменяем старый элемент на новый <p>
                currentElement.replaceWith(newParagraph);


            }



            // Вставляем <br>, если его еще нет в конце
            const br = document.createElement("br");
            range.insertNode(br);
            currentElement.normalize();

            // Перемещаем курсор после вставленного <br>
            range.setStartAfter(br);
            range.setEndAfter(br);
            sel.removeAllRanges();
            sel.addRange(range);



            // Если это <li>, поднимаемся до родителя <ol> или <ul>
            if (currentElement && currentElement.innerText.trim() === "" && currentElement.tagName === "LI") {

                let parent = currentElement.parentElement;

                // Проверяем, что родитель — это <ol> или <ul>
                if (parent && (parent.tagName === "OL" || parent.tagName === "UL")) {

                    // Создаем новый <p> после родительского <ol> или <ul>
                    let newParagraph = document.createElement("p");
                    newParagraph.classList.add("paragraph", "tag_editor_wrap");
                    newParagraph.innerHTML = "<br>";
                    parent.parentNode.insertBefore(newParagraph, parent.nextSibling);
                    currentElement.remove();
                    setCaretAtStart(newParagraph)

                }
            }
        }
    });
}
