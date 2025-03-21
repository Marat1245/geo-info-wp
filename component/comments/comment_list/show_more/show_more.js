// Обработчик для загрузки дополнительных комментариев
document.addEventListener('click', function (event) {
    if (event.target.closest('.comment_more_btn')) {
        const moreBtn = event.target.closest('.comment_more_btn');
        const commentsList = moreBtn.closest('.comment_block');
        const currentCount = commentsList.querySelectorAll('.parent_comment');
        const postId = commentsList.dataset.postId;
        let parentId = [];
        currentCount.forEach(comment => {
            parentId.push(comment.dataset.commentId);
        });


        if (!postId) {
            console.error('ID поста не найден');
            return;
        }

        // Добавляем класс "loading" на кнопку
        moreBtn.classList.add('loading');

        // Отправляем AJAX запрос
        fetch(show_more.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'load_more_comments',
                post_id: postId,
                offset: currentCount,
                parent_id: JSON.stringify(parentId),
                nonce: show_more.nonce,
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(response => {
                if (response.success) {

                    // Добавляем новые комментарии
                    moreBtn.insertAdjacentHTML('beforebegin', response.data.html);
                    console.log(response.data.show_more);
                    // Если больше нет комментариев для загрузки, скрываем кнопку
                    if (!response.data.show_more) {
                        moreBtn.remove();
                    } else {
                        // Обновляем текст кнопки
                        const btnText = moreBtn.querySelector('span');
                        if (btnText) {
                            if (response.data.next_load_count === response.data.remaining_total) {
                                btnText.textContent = `Ещё ${response.data.next_load_count} комментариев`;
                            } else {
                                btnText.textContent = `${response.data.next_load_count} из ${response.data.remaining_total} комментариев`;
                            }
                        }
                    }
                } else {
                    console.error('Ошибка загрузки комментариев:', response.data);
                    alert('Произошла ошибка при загрузке комментариев. Пожалуйста, попробуйте позже.');
                }
            })
            .catch(error => {
                console.error('Ошибка AJAX:', error);
                alert('Произошла ошибка при загрузке комментариев. Пожалуйста, попробуйте позже.');
            })
            .finally(() => {
                moreBtn.classList.remove('loading');
            });
    }
});