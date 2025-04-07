document.addEventListener("DOMContentLoaded", function () {
    let postType = "";
    const homePage = document.querySelector('.home-page'); // Проверяем, на главной ли странице
    if (!homePage) { return; } // Если на главной странице, выходим

    if (homePage) {
        postType = "post_users";
    } else {
        postType = document.querySelector('[data-post-type]').dataset.postType;
    }

    const postsContainer = document.querySelector('.upload_list'); // Контейнер с постами
    if (!postsContainer) return; // Если контейнер не найден, выходим
    const numberOfPosts = 5; // Количество постов на странице (можно изменить в зависимости от вашей разметки)
    const checkCountPosts = 1; // Количество постов, которые должны быть видны перед загрузкой новых (можно изменить в зависимости от вашей разметки)


    let currentPage = 1;
    let isLoading = false;
    let hasMorePosts = true;

    function loadMorePosts() {
        if (isLoading || !hasMorePosts) return;

        isLoading = true;

        let formData = new FormData();
        formData.append('action', 'load_infinity_archive');
        formData.append('page', currentPage + 1);
        formData.append('post_type', postType);
        formData.append('nonce', load_infinity_archive.nonce);
        formData.append('number', numberOfPosts); // Количество постов для загрузки

        // Показываем индикатор загрузки
        const loader = document.getElementById('loading-indicator') || createLoader();
        loader.style.display = 'block';

        fetch(load_infinity_archive.ajaxurl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.data.html) {
                        postsContainer.insertAdjacentHTML('beforeend', data.data.html);
                        currentPage++;
                    } else {
                        hasMorePosts = false;
                    }
                } else {
                    hasMorePosts = false;
                }

                isLoading = false;
                loader.style.display = 'none';
            })
            .catch(error => {
                console.error('Error loading posts:', error);
                isLoading = false;
                loader.style.display = 'none';
            });
    }

    function createLoader() {
        const loader = document.createElement('div');
        loader.id = 'loading-indicator';
        postsContainer.after(loader);
        return loader;
    }

    function checkTriggerZone() {
        const posts = document.querySelectorAll('.post_item'); // Селектор постов        
        if (posts.length === 0) return;

        // Проверяем, виден ли 10-й пост с конца
        const triggerPost = posts[Math.max(0, posts.length - checkCountPosts)];

        const rect = triggerPost.getBoundingClientRect();
        const isVisible = (
            rect.top >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        );

        if (isVisible && hasMorePosts && !isLoading) {
            loadMorePosts();
        }
    }

    // Слушаем событие прокрутки
    window.addEventListener('scroll', checkTriggerZone);

    // Проверяем при загрузке страницы
    checkTriggerZone();
})