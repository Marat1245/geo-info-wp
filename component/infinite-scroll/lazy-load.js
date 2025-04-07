document.addEventListener("DOMContentLoaded", function () {
    let postContainer = document.getElementById("posts-container");
    let loadTrigger = document.getElementById("load-trigger");
    let loadingIndicator = document.getElementById("loading-indicator");
    const postTypeWrapper = document.querySelector(".inner_page")
    if (!postTypeWrapper || !postContainer) {
        return
    }
    const postType = postTypeWrapper.dataset.postType;

    const excludePostId = postTypeWrapper.querySelectorAll(".post_item")[0].dataset.postId;

    let currentPage = 1;
    let isLoading = false;
    const MAX_POSTS = 20;
    let currentPostId = 0;

    if (!postContainer) {
        return
    }
    // Получаем элемент, у которого есть нужный класс
    let postElement = document.querySelector('.single');

    if (postElement) {
        // Извлекаем все классы элемента
        let classes = postElement.classList;

        // Ищем класс, который содержит 'postid-'
        for (let className of classes) {
            if (className.startsWith('postid-')) {
                // Извлекаем post ID
                currentPostId = className.split('-')[1]; // Разделяем строку по '-' и берем второй элемент 
                break; // Выходим из цикла после нахождения ID
            }
        }
    } else {
        console.log('Element not found');
    }

    function loadMorePosts() {

        if (isLoading) return; // Предотвращаем дублирующуюся загрузку
        isLoading = true;
        loadingIndicator.style.display = "block";


        let formData = new FormData();
        formData.append('action', 'load_infinity');
        formData.append('page', currentPage);
        formData.append('nonce', typeof geoInfoInfinity !== 'undefined' ? geoInfoInfinity.nonce : '');
        formData.append("post_id", currentPostId);
        formData.append("post_type", postType);
        formData.append("exclude_post_id", excludePostId);

        fetch(geoInfoInfinity.ajaxurl, {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    ;
                    postContainer.insertAdjacentHTML("beforeend", data.data.html);
                    currentPage++; // Увеличиваем страницу только после успешной загрузки

                    // Обновляем список постов и следим за четвертым с конца
                    let posts = document.querySelectorAll(".post_item");
                    if (posts.length > 3) {
                        observer.observe(posts[posts.length - 3]);
                    }


                    // Удаляем старые посты, если их количество превышает MAX_POSTS
                    while (posts.length > MAX_POSTS) {
                        // Отключаем наблюдение за первым постом
                        observer.unobserve(posts[0]);

                        // Удаляем первый пост из DOM
                        posts[0].remove();

                        // Обновляем список постов
                        posts = document.querySelectorAll(".post_item");
                    }
                } else {
                    if (loadTrigger) {
                        loadTrigger.remove();
                    }
                }
                isLoading = false;
                loadingIndicator.style.display = "none";
            })
            .catch(error => {
                console.error("Ошибка загрузки:", error);
                isLoading = false;
                loadingIndicator.style.display = "none";
            });
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadMorePosts();
            }
        });
    });

    // Следим за триггером загрузки
    if (loadTrigger) {
        observer.observe(loadTrigger);
    }
    loadMorePosts()
});

