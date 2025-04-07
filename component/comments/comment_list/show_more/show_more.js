// Обработчик для загрузки дополнительных комментариев
document.addEventListener('click', function (event) {
    if (event.target.closest('.comment_more_btn')) {
        const moreBtn = event.target.closest('.comment_more_btn');
        const commentsList = moreBtn.closest('.comment_block') || moreBtn.closest('.post_item');
        const contSpan = moreBtn.querySelector('.count_comments')
        const countComments = contSpan.textContent.trim();
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
                count_comments: countComments,
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
                    if (!response.data.show_more) {
                        moreBtn.remove();
                    } else {
                        function getCommentWord(count) {
                            count = Math.abs(count) % 100;
                            let num = count % 10;

                            if (count > 10 && count < 20) {
                                return "комментариев";
                            }
                            if (num > 1 && num < 5) {
                                return "комментария";
                            }
                            if (num === 1) {
                                return "комментарий";
                            }
                            return "комментариев";
                        }

                        const remainingTotal = response.data.remaining_total;
                        const commentText = getCommentWord(remainingTotal);

                        contSpan.textContent = "\u00A0" + remainingTotal + "\u00A0";
                        moreBtn.querySelector(".count_comments_text").textContent = commentText;

                        if (remainingTotal <= 50) {
                            const uploadSpan = moreBtn.querySelector('.count_comments_upload');
                            if (uploadSpan) uploadSpan.remove();
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