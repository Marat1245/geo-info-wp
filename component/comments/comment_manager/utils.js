// Защита от XSS
export const escapeHtml = (unsafe) => {
    // Если unsafe это DOM элемент
    if (unsafe instanceof HTMLElement) {
        let result = '';

        // Обрабатываем текст, который находится непосредственно в contenteditable
        const directText = Array.from(unsafe.childNodes)
            .filter(node => node.nodeType === Node.TEXT_NODE)
            .map(node => node.textContent)
            .join('')
            .trim();

        if (directText) {
            const escapedDirectText = directText
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
            result += `<div>${escapedDirectText}</div>`;
        }

        // Получаем все div'ы из элемента
        const divs = unsafe.getElementsByTagName('div');

        // Обрабатываем каждый div
        for (let div of divs) {
            // Экранируем HTML в содержимом div
            const escapedContent = div.innerHTML
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");

            // Добавляем обработанный div в результат
            result += `<div>${escapedContent}</div>`;
        }

        return result;
    }

    // Если unsafe это строка, обрабатываем как раньше
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/\n/g, "<br>");
};

// Форматирование времени
export const formatTimeAgo = (date) => {
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) return 'только что';

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}м`;

    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}ч`;

    const days = Math.floor(hours / 24);
    if (days < 30) return `${days}д`;

    const months = Math.floor(days / 30);
    if (months < 12) return `${months}м`;

    return `${Math.floor(months / 12)}г`;
}; 