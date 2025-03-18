document.addEventListener("DOMContentLoaded", function () {
    let posts = document.querySelectorAll(".post-item");

    function updatePostsList() {
        posts = document.querySelectorAll(".post-item"); // Обновляем список постов
    }

    function updateURL() {
        let closestPost = null;
        let closestOffset = Infinity;
        let scrollY = window.scrollY + window.innerHeight / 3; // Смещение для точности

        posts.forEach(post => {
            let rect = post.getBoundingClientRect();
            let offset = Math.abs(rect.top + window.scrollY - scrollY);

            if (offset < closestOffset) {
                closestOffset = offset;
                closestPost = post;
            }
        });

        if (closestPost) {
            let newUrl = closestPost.dataset.postLink;
            if (newUrl && window.location.href !== newUrl) {
                history.pushState({}, "", newUrl);
            }
        }
    }

    // Отслеживаем появление новых постов (если используются AJAX-загрузки)
    const observer = new MutationObserver(updatePostsList);
    observer.observe(document.body, { childList: true, subtree: true });

    window.addEventListener("scroll", updateURL);
});