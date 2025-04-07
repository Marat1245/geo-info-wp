document.addEventListener("DOMContentLoaded", () => {
    const maxLoads = 2;

    // Общий обработчик событий
    document.addEventListener("click", (e) => {
        const moreBtn = e.target.closest(".more_btn");
        if (!moreBtn) return;

        let postType = moreBtn.dataset.postType;
        console.log(postType);
        // Если на кнопке нет данных или кнопка уже загружается, выходим
        if (moreBtn.dataset.isLoading === "true" || moreBtn.dataset.page <= 0) {
            return;
        }

        // Убедимся, что data-page инициализировано как число
        let page = parseInt(moreBtn.dataset.page, 10);
        if (isNaN(page)) {
            page = 1; // Устанавливаем по умолчанию первую страницу, если значение некорректно
            moreBtn.dataset.page = page; // Обновляем значение data-page на корректное
        }

        const loadCount = parseInt(moreBtn.dataset.loadCount || 0, 10);

        if (loadCount >= maxLoads) {
            moreBtn.outerHTML = `
                <a href="/${postType === "post" ? "preprints" : postType}" class="more_btn">
                    <span>Все ${postType === "news" ? "новости" : "посты"}</span>
                </a>
            `;
            return;
        }

        // Устанавливаем флаг загрузки
        moreBtn.dataset.isLoading = "true";
        showListPosts(moreBtn, postType, page, loadCount);
    });

    /**
     * Универсальная функция для загрузки постов
     * @param {HTMLElement} moreBtn Кнопка загрузки
     * @param {string} postType Тип поста (например, 'news', 'events' и т.д.)
     * @param {number} page Номер страницы для загрузки
     * @param {number} loadCount Счётчик загруженных блоков
     */
    function showListPosts(moreBtn, postType, page, loadCount) {
        const container = document.getElementById(postType + "-container");
        if (!container) return;

        const formData = new FormData();
        formData.append("action", "load_more_posts");
        formData.append("post_type", postType); // Тип поста
        formData.append("page", page); // Страница для загрузки
        formData.append("nonce", typeof load_more_posts !== "undefined" ? load_more_posts.nonce : "");

        fetch(load_more_posts.ajaxurl, {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    container.insertAdjacentHTML("beforeend", data.data.html);
                    moreBtn.dataset.page = page + 1; // Обновляем страницу
                    moreBtn.dataset.loadCount = loadCount + 1; // Обновляем счётчик загрузок

                    if (loadCount + 1 >= maxLoads) {
                        moreBtn.outerHTML = `
                        <a href="/${postType === "post" ? "preprints" : postType}" class="more_btn">
                            <span>Все ${postType === "news" ? "новости" : "посты"}</span>
                        </a>
                    `;
                    }
                } else {
                    moreBtn.querySelector("span").textContent = data.message || `Больше нет постов`;
                    moreBtn.disabled = true;
                }
            })
            .catch((error) => console.error("Ошибка загрузки:", error))
            .finally(() => {
                moreBtn.dataset.isLoading = "false"; // Убираем флаг загрузки
            });
    }
});
