
// ТЫБА ДЛЯ ОТОБРАЖЕНИЯ КОНТЕНТА

export function btnSwitcher(btn, wrap, content) {
    const wrapper = document.querySelector(wrap);
    const buttons = document.querySelectorAll(btn);
    const contents = document.querySelectorAll(content);

    // Изначально скрываем все контенты и показываем первый
    contents.forEach((contentItem, index) => {
        contentItem.classList.add('hidden');
        if (index === 0) {
            contentItem.classList.add('visible_flex');
        }
    });

    // Функция для обновления контента и активных кнопок
    const updateContent = (index) => {
        contents.forEach((contentItem, i) => {
            contentItem.classList.toggle('visible_flex', i === index);
            contentItem.classList.toggle('hidden', i !== index);
        });

        buttons.forEach((button, i) => {
            button.classList.toggle('full_orange', i === index);
            button.classList.toggle('stroke_btn', i !== index);
            button.classList.toggle('small_text', true);
        });
    };

    // Изначально обновляем состояние
    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
            updateContent(index);
        });
    });
}

