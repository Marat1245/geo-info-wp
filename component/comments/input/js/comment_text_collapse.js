document.addEventListener('DOMContentLoaded', function () {
    const LINE_HEIGHT = 24; // Высота одной строки в пикселях
    const MAX_LINES = 5; // Максимальное количество видимых строк
    const MAX_HEIGHT = LINE_HEIGHT * MAX_LINES; // Максимальная высота в пикселях

    function initCommentText(commentText) {

        if (!commentText) return;

        // Проверяем реальную высоту текста
        const realHeight = commentText.scrollHeight;

        if (realHeight > MAX_HEIGHT) {
            // Если текст больше 5 строк, устанавливаем collapsed состояние
            commentText.setAttribute('data-collapsed', 'true');

            // Находим кнопку "еще"
            const toggleButton = commentText.querySelector('.toggle_text');
            if (toggleButton) {
                toggleButton.style.display = 'inline';
            }

            // Добавляем обработчик клика на весь блок текста
            commentText.addEventListener('click', function (e) {

                // Проверяем, есть ли выделенный текст
                const selection = window.getSelection();
                if (selection.toString().length > 0) {
                    return; // Если есть выделение, не сворачиваем/разворачиваем
                }

                const isCollapsed = commentText.getAttribute('data-collapsed') === 'true';

                // Переключаем состояние
                commentText.setAttribute('data-collapsed', !isCollapsed);

                // Меняем текст кнопки
                if (toggleButton) {
                    toggleButton.textContent = isCollapsed ? 'свернуть' : '...еще';
                    toggleButton.style.display = isCollapsed ? 'none' : 'inline';
                }
            });
        } else {
            // Если текст меньше или равен 4 строкам, убираем collapsed состояние
            commentText.setAttribute('data-collapsed', 'false');
            const toggleButton = commentText.querySelector('.toggle_text');
            if (toggleButton) {
                toggleButton.style.display = 'none';
            }
        }
    }

    // Инициализация для существующих комментариев
    document.querySelectorAll('.comment_text').forEach(initCommentText);

    // Наблюдатель за новыми комментариями
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1) { // Проверяем, что это элемент
                    // Если добавленный узел сам является comment_text
                    if (node.classList.contains('comment_text')) {
                        initCommentText(node);
                    }
                    // Ищем .comment_text внутри добавленного узла
                    const commentTexts = node.querySelectorAll('.comment_text');
                    commentTexts.forEach(initCommentText);
                }
            });
        });
    });

    // Начинаем наблюдение за изменениями в DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}); 