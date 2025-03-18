document.addEventListener("DOMContentLoaded", function () {
    function checkActiveTag() {
        const tags = document.querySelectorAll(".artical-page_tag");
        let activeItem = null;

        tags.forEach(tag => {
            const tagRect = tag.getBoundingClientRect();
            const postItem = tag.closest(".post-item");

            if (!postItem) return;

            if (tagRect.top >= 0 && tagRect.top <= window.innerHeight / 1) {
                activeItem = postItem;
            }
        });

        // Если ничего не нашли, то активируем последний post-item, который был на экране
        if (!activeItem && tags.length > 0) {
            for (let i = tags.length - 1; i >= 0; i--) {
                const tagRect = tags[i].getBoundingClientRect();
                if (tagRect.top < 0) {
                    activeItem = tags[i].closest(".post-item");
                    break;
                }
            }
        }

        // Обновляем URL, если нашли активный пост
        if (activeItem) {
            let newUrl = activeItem.dataset.postLink;
            if (newUrl && window.location.href !== newUrl) {
                history.pushState({}, "", newUrl);
            }
        }

        // Удаляем active у всех и добавляем только активному
        document.querySelectorAll(".post-item").forEach(el => el.classList.remove("active"));
        if (activeItem) activeItem.classList.add("active");
    }

    // Следим за скроллом и изменением окна
    window.addEventListener("scroll", checkActiveTag);
    window.addEventListener("resize", checkActiveTag);
    checkActiveTag();

    // Обрабатываем динамическую подгрузку
    const observer = new MutationObserver(checkActiveTag);
    observer.observe(document.body, { childList: true, subtree: true });
});
