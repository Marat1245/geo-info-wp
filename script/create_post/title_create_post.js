
export function titleTextarea() {
    const textareas = document.querySelectorAll(".t_textarea");

    textareas.forEach(item => {
        if (!item) return;

        // Получаем `line-height` и приводим к числу
        const lineHeight = 44;
        if (!lineHeight) return;

        // Функция автоматического изменения высоты
        function autoResize() {

            // Сбрасываем высоту перед пересчетом, чтобы scrollHeight корректно обновился
            item.style.height = "auto";

            // Разделим scrollHeight на высоту строки и округлим вверх
            const count = Math.floor(item.scrollHeight / lineHeight);
            // Устанавливаем новую высоту в зависимости от количества строк item.offsetHeight

            item.style.height = `${count * lineHeight}px`;


        }

        // Вызываем autoResize при изменении ввода
        item.addEventListener("input", autoResize);

        // Вызываем autoResize для корректной инициализации (если в textarea уже есть текст)
        autoResize();
    });
}
