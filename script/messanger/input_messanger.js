export function messagesTextarea() {
    const textarea = document.querySelector(".messages_textarea");
    if (textarea) {
        // Устанавливаем минимальную высоту
        const lineHeight = 14;
        textarea.style.height = `${lineHeight}px`;

        // Функция для автоматического изменения высоты
        function autoResize() {
            // Сбрасываем высоту перед расчетом, чтобы убрать прокрутку
            textarea.style.height = `${lineHeight}px`;

            // // Разделим scrollHeight на высоту строки и округлим вверх
            // let count = Math.max(1, Math.ceil((textarea.scrollHeight - textarea.offsetHeight + lineHeight) / lineHeight));

            // // Рассчитываем высоту с учетом содержимого
            const newHeight = Math.min(textarea.scrollHeight - 21, 200); // Ограничиваем максимум 200px
            // textarea.style.height = `${count * newHeight}px`;
            textarea.style.height = `${newHeight}px`;
            // console.log(textarea.scrollHeight, textarea.scrollHeight - 24);
        }

        // Слушатель изменения текста
        textarea.addEventListener("input", autoResize);

        // Инициализируем авто-изменение при загрузке
        autoResize();
    }
}

