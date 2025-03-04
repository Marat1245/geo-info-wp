// При переносе текста с разными стилями могут появится ненужные style. Удаляем такие span
export const deleteSpanWithStyle = (editor) => {
    editor.addEventListener("input", () => {
        // Получаем все спаны с атрибутом style (пустым)
        let spans = document.querySelectorAll('span[style]');
        if(!spans){ return }

        // Проходим по каждому из них
        spans.forEach(span => {
            // Создаем текстовый узел с содержимым внутри спана
            let textNode = document.createTextNode(span.textContent);

            // Заменяем спан на его текстовое содержимое
            span.parentNode.replaceChild(textNode, span);
        });
    })



}
