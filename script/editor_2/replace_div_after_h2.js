export const replaceDivAfterH2 = (editor) =>{
    document.addEventListener('keydown', (event) => {
        if (event.key === "Enter") {
            let selection = window.getSelection();
            let range = selection.getRangeAt(0);
            let parentElement = range.commonAncestorContainer.parentElement;

            // Проверяем, что родительский элемент имеет класс .container и это h2 или h3
            if (parentElement && (parentElement.tagName === "H2" || parentElement.tagName === "H3") ){
                // Создаем новый элемент <p>
                let newP = document.createElement('p');
                newP.innerHTML = "<br>"; // Можно оставить пустым, если хотите пустой параграф

                // Вставляем <p> после текущего элемента h2/h3
                parentElement.parentNode.insertBefore(newP, parentElement.nextSibling);

                // Перемещаем курсор в новый <p>
                let rangeAfter = document.createRange();
                rangeAfter.setStart(newP, 0);
                rangeAfter.setEnd(newP, 0);

                selection.removeAllRanges();
                selection.addRange(rangeAfter);

                event.preventDefault(); // Отменяем стандартное поведение Enter
            }
        }
    });


}
