document.addEventListener('DOMContentLoaded', function () {
    // Обработка удаления комментария
    document.body.addEventListener('click', function (e) {
        const deleteButton = e.target.closest('.delete-comment');
        if (!deleteButton) return;

        const commentBlock = deleteButton.closest('.user_comment');
        if (!commentBlock) return;

        const commentId = commentBlock.dataset.commentId;
        if (!commentId) return;

        e.preventDefault();


        const formData = new FormData();
        formData.append('action', 'delete_comment');
        formData.append('comment_id', commentId);
        formData.append('nonce', comment_actions.nonce);

        // Отладочная информация
        console.log('Sending delete request:', {
            action: 'delete_comment',
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
                    // Скрываем основной контент комментария
                    const userCommentInfo = commentBlock.querySelector('.user_comment_info');
                    const commentText = commentBlock.querySelector('.comment_text');
                    const commentControl = commentBlock.querySelector('.comment_control');

                    if (userCommentInfo) userCommentInfo.style.display = 'none';
                    if (commentText) commentText.style.display = 'none';
                    if (commentControl) commentControl.style.display = 'none';

                    // Показываем блок восстановления
                    const restoreWrap = commentBlock.querySelector('.delete_comment_wrap');
                    if (restoreWrap) {
                        restoreWrap.style.display = 'flex';
                        console.log('Restore wrap shown');
                    } else {
                        console.log('Restore wrap not found');
                    }
                } else {
                    alert(data.data || 'Произошла ошибка при удалении комментария');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при удалении комментария');
            });

    });
}); 