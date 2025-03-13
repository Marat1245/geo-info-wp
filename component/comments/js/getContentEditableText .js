// Функция для преобразования HTML в текст с переносами строк
export const getContentEditableText = (element) => {
    // Получаем HTML контент
    let html = element.innerHTML;

    // Заменяем <div> и </div> на переносы строк
    html = html.replace(/<div>/gi, '\n').replace(/<\/div>/gi, '');

    // Удаляем все остальные HTML теги
    html = html.replace(/<[^>]+>/g, '');

    // Декодируем HTML сущности
    let txt = document.createElement("textarea");
    txt.innerHTML = html;
    let decodedText = txt.value;

    // Убираем множественные переносы строк и пробелы
    decodedText = decodedText.replace(/\n{3,}/g, '\n\n');

    // Убираем пробелы в начале и конце каждой строки
    decodedText = decodedText.split('\n')
        .map(line => line.trim())
        .join('\n')
        .trim();

    return decodedText;
};