document.addEventListener("DOMContentLoaded", function () {
    // Делегирование событий на <body> для обработки как статических, так и динамических изображений
    document.body.addEventListener("click", function (event) {
        const img = event.target.closest(".article_page_text img"); // Проверяем, кликнули ли по изображению
        
        if (img) {
            event.preventDefault(); // Предотвращаем стандартное действие

            // Проверяем, загружен ли Fancybox
            if (typeof Fancybox !== "undefined" && Fancybox.show) {
                Fancybox.show([
                    {
                        src: img.getAttribute("src"), // Берем src из атрибута
                        type: "image",
                        caption: img.getAttribute("alt") || "", // Подпись (если есть alt)
                    }
                ]);
            } else {
                console.error("Ошибка: Fancybox не загружен.");
            }
        }
    });
});
