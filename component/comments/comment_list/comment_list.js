document.addEventListener('DOMContentLoaded', function () {
    // Обработчик кнопки "Показать еще"
    // document.addEventListener('click', function (e) {
    //     const loadMoreButton = e.target.closest('.load-more-comments');
    //     if (!loadMoreButton) return;

    //     const offset = parseInt(loadMoreButton.dataset.offset);
    //     const postId = loadMoreButton.closest('.comments-list').dataset.postId;

    //     fetch(comment_controller.ajaxurl, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/x-www-form-urlencoded',
    //         },
    //         body: new URLSearchParams({
    //             action: 'load_more',
    //             post_id: postId,
    //             offset: offset,
    //             nonce: comment_controller.nonce
    //         })
    //     })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 // Добавляем новые комментарии
    //                 const commentsContainer = loadMoreButton.previousElementSibling;

    //                 commentsContainer.insertAdjacentHTML('beforeend', data.data.html);

    //                 // Обновляем смещение
    //                 loadMoreButton.dataset.offset = offset + 5;


    //             }
    //         });
    // });
}); 