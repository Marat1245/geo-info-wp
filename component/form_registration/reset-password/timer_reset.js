
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll('form .primary');
    const wrap = document.querySelector('.login');
    if (!wrap) {
        return; // Если элемент не найден, выходим из функции
    }
    buttons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            btn.classList.add('inactive');

            // Удалим старый индикатор, если он есть
            const existingIndicator = document.getElementById('loading-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }

            // Создаём новый индикатор
            const indicator = document.createElement('div');
            indicator.id = 'loading-indicator';

            // Вставляем индикатор после кнопки
            btn.parentNode.insertBefore(indicator, btn.nextSibling);

        });
    });
});
