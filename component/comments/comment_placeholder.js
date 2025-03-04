document.addEventListener("DOMContentLoaded", function () {
    function initCommentInput(input) {

        function updatePlaceholder() {
            if (!input.textContent.trim()) {
                input.classList.add("placeholder");
            }
        }

        input.addEventListener("focus", () => {
            input.classList.remove("placeholder");
        });

        input.addEventListener("blur", updatePlaceholder);

        updatePlaceholder();
    }

// Обрабатываем уже существующие элементы
    document.querySelectorAll(".comment_input").forEach(initCommentInput);

// Наблюдатель за новыми элементами
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {

            mutation.addedNodes.forEach((node) => {

                if (node.nodeType === 1) { // Проверяем, что это элемент (не текст и не комментарий)
                    const commentInput = node.querySelector(".comment_input"); // Ищем внутри node
                    if (commentInput) {
                        initCommentInput(commentInput); // Инициализируем найденный элемент
                    }
                }
            });
        });
    });

// Следим за изменениями в `body` (или в конкретном контейнере)
    observer.observe(document.body, { childList: true, subtree: true });

})