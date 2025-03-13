import { getContentEditableText } from './getContentEditableText .js';
// Функция обновления состояния кнопки
export const updateSubmitButton = (commentInput, submitButton, MAX_LENGTH) => {
    const content = getContentEditableText(commentInput);
    const img = submitButton.querySelector('img');
    const length = content.length;

    if (!content || length > MAX_LENGTH) {
        submitButton.disabled = true;
        if (img) {
            img.src = img.dataset.defaultIcon;
        }
    } else {
        submitButton.disabled = false;
        if (img) {
            img.src = img.dataset.activeIcon;
        }
    }
};