// Ставим курсор в начале созданного блока
export const setCaretAtStart = (el) => {
    let range = document.createRange();
    range.selectNodeContents(el);
    range.collapse(true);
    let sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
};