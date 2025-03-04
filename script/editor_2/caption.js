export function captionViewModel(selector = ".t_contenteditable, #editor, .input-caption") {
    const elements = document.querySelectorAll(selector);

    elements.forEach((element) => {
        // Наблюдаем за изменениями в элементе
        const observer = new MutationObserver(() => updatePlaceholder(element));
        observer.observe(element, { childList: true, subtree: true, characterData: true });

        element.addEventListener("input", (event) => {
            event.stopImmediatePropagation(); // Полностью останавливаем событие
            updatePlaceholder(element);
        });

        element.addEventListener("blur", () => applyPlaceholder(element));
        element.addEventListener("focus", () => applyPlaceholder(element));

        // Применяем плейсхолдер при загрузке
        applyPlaceholder(element);
    });
}

export function updatePlaceholder(element) {

    if (element.textContent.trim() === "" || element.innerHTML.trim() === "<br>" ) {

        element.classList.add("placeholder");
    } else {
        element.classList.remove("placeholder");
    }
}

function applyPlaceholder(element) {
    if (element.textContent.trim() === "" || element.innerHTML.trim() === "<br>" ) {
        element.classList.add("placeholder");
    }
}
