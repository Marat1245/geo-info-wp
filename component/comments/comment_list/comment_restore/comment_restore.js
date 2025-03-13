document.addEventListener('DOMContentLoaded', function () {
    // Обработка восстановления комментария
    document.body.addEventListener('click', function (e) {
        const restoreButton = e.target.closest('.restore_comment');
        if (!restoreButton) return;

        const commentBlock = restoreButton.closest('.user_comment');
        if (!commentBlock) return;

        const commentId = commentBlock.dataset.commentId;
        if (!commentId) return;

        e.preventDefault();

        const formData = new FormData();
        formData.append('action', 'restore_comment');
        formData.append('comment_id', commentId);
        formData.append('nonce', comment_actions.nonce);

        // Отладочная информация
        console.log('Sending restore request:', {
            action: 'restore_comment',
            comment_id: commentId,
            nonce: comment_actions.nonce
        });

        fetch(comment_actions.ajaxurl, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Показываем основной контент комментария
                    const userCommentInfo = commentBlock.querySelector('.user_comment_info');
                    const commentText = commentBlock.querySelector('.comment_text');
                    const commentControl = commentBlock.querySelector('.comment_control');

                    if (userCommentInfo) userCommentInfo.style.display = 'flex';
                    if (commentText) commentText.style.display = 'block';
                    if (commentControl) commentControl.style.display = 'flex';

                    // Скрываем блок восстановления
                    const restoreWrap = commentBlock.querySelector('.delete_comment_wrap');
                    if (restoreWrap) {
                        restoreWrap.style.display = 'none';
                        console.log('Restore wrap hidden');
                    } else {
                        console.log('Restore wrap not found');
                    }
                } else {
                    alert(data.data || 'Произошла ошибка при восстановлении комментария');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при восстановлении комментария');
            });
    });
}); 