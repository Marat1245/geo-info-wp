// Обработчик для загрузки дополнительных комментариев
document.addEventListener('click', function (event) {
    if (event.target.closest('.under_comment_more_btn')) {
        const moreBtn = event.target.closest('.under_comment_more_btn');
        const undercommentsList = moreBtn.closest('.comment_responses');
        const postId = undercommentsList.closest('.post_item').dataset.postId;
        const prevNode = undercommentsList.previousElementSibling;
        const commentId = prevNode.dataset.commentId;
        var loadedCommentsCount = undercommentsList.querySelectorAll('.response').length;

        if (!commentId || !postId) {
            console.error('ID комментария или поста не найден');
            return;
        }

        // Добавляем класс "loading" на кнопку
        moreBtn.classList.add('loading');

        // Отправляем AJAX запрос
        fetch(show_undercomment.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'show_undercomment',
                comment_id: commentId,
                post_id: postId,
                nonce: show_undercomment.nonce,
                loadedCommentsCount: loadedCommentsCount,
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
                    const totalCount = response.data.total_count - response.data.loadedCommentsCount;

                    if (totalCount <= 0) {
                        moreBtn.remove();

                    }
                    else {
                        let word = 'ответ';
                        if (totalCount % 10 === 1 && totalCount % 100 !== 11) {
                            word = 'ответ';
                        } else if ([2, 3, 4].includes(totalCount % 10) && ![12, 13, 14].includes(totalCount % 100)) {
                            word = 'ответа';
                        } else {
                            word = 'ответов';
                        }
                        moreBtn.querySelector('span').innerHTML = totalCount + ' ' + word;
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