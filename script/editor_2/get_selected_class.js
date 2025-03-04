// Получаем классы выделенных узлов и создаем массив
export function getSelectedClass() {
    const selection = window.getSelection();
    const classes = new Set(); // Используем Set, чтобы избежать дубликатов

    if (selection.rangeCount === 0 || selection.isCollapsed) {
        return []; // Если ничего не выделено, возвращаем пустой массив
    }

    const range = selection.getRangeAt(0);
    let node = range.commonAncestorContainer;

    // Если узел — это текст, берем его родителя
    if (node.nodeType === Node.TEXT_NODE) {
        node = node.parentElement;

    }

    // Добавляем классы самого родительского элемента
    if (node && node.classList) {
        node.classList.forEach(cls => classes.add(cls));
    }

    // Используем TreeWalker, чтобы пройтись по дочерним элементам
    const treeWalker = document.createTreeWalker(
        node,
        NodeFilter.SHOW_ELEMENT,
        {
            acceptNode: function(node) {
                return range.intersectsNode(node) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
            }
        }
    );

    while (treeWalker.nextNode()) {
        const currentNode = treeWalker.currentNode;
        if (currentNode.classList.length > 0) {
            currentNode.classList.forEach(cls => classes.add(cls));
        }
    }

    return Array.from(classes); // Преобразуем Set в массив и возвращаем


}