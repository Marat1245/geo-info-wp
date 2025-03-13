// Функция для ограничения текста по максимальной длине
export const truncateText = (text, MAX_LENGTH) => {
    return text.length > MAX_LENGTH ? text.substring(0, MAX_LENGTH) : text;
};