import { getContentEditableText } from './getContentEditableText .js';
// Функция обновления счетчика символов
export const updateCharCounter = (commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH) => {
    const text = getContentEditableText(commentInput);
    const length = text.length;
    const currentCharsSpan = charCounter.querySelector('.current_chars');

    if (currentCharsSpan) {
        currentCharsSpan.textContent = length;
    }

    // Показываем счетчик, если осталось менее 250 символов до лимита
    if (length >= SHOW_COUNTER_AT) {
        charCounter.style.display = 'block';
    } else {
        charCounter.style.display = 'none';
    }

    // Добавляем красный цвет, если превышен лимит
    if (length > MAX_LENGTH) {
        charCounter.classList.add('exceeded');
    } else {
        charCounter.classList.remove('exceeded');
    }
};