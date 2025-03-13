// Обработчик для загрузки дополнительных комментариев
document.addEventListener('click', function (event) {
    if (event.target.closest('.more_btn')) {
        const moreBtn = event.target.closest('.more_btn');
        const commentsList = moreBtn.closest('.comment_block');
        const currentCount = commentsList.querySelectorAll('.user_comment').length;
        const postId = commentsList.dataset.postId;
        const nonce = show_more.nonce;
        console.log('currentCount: ' + currentCount);

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
                nonce: nonce,
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
                    console.log('response: ' + response);
                    // Добавляем новые комментарии
                    moreBtn.insertAdjacentHTML('beforebegin', response.data.html);

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