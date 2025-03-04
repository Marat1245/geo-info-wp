export function grabBlock() {
    const container = $(".switch_wrap_btn, .profil_switch_wrap"); // Замените на ваш элемент
    let isDown = false; // Флаг для отслеживания нажатия кнопки мыши
    let startX, scrollLeft;

    // Когда нажали мышь
    container.on("mousedown", function (e) {
        isDown = true;
        startX = e.pageX - container.offset().left;
        scrollLeft = container.scrollLeft();
    });

    // Когда отпустили мышь
    $(document).on("mouseup", function () {
        isDown = false;
    });

    // Когда двигаем мышь
    container.on("mousemove", function (e) {
        if (!isDown) return; // Если кнопка мыши не нажата — выходим
        e.preventDefault();
        const x = e.pageX - container.offset().left; // Текущее положение мыши
        const walk = (x - startX) * 2; // Скорость прокрутки (измените multiplier для настройки)
        container.scrollLeft(scrollLeft - walk); // Прокручиваем контейнер
    });
};
