// Получаем текущий блок
export const getCurrentBlock = (editor) => {
    let sel = window.getSelection();
    if (!sel.rangeCount) return null;
    let node = sel.anchorNode;
    while (node && node !== editor && node.parentNode !== editor) node = node.parentNode;
    return node && node !== editor ? node : null;
};