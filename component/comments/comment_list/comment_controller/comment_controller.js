document.addEventListener('DOMContentLoaded', function () {
    // Используем делегирование событий через document
    document.addEventListener('click', function (e) {
        const likeButton = e.target.closest('.like-comment-button');

        if (!likeButton) return;

        if (likeButton.classList.contains('disabled')) {
            return;
        }

        const commentId = likeButton.dataset.commentId;
        const likeIcon = likeButton.querySelector('.like-icon');
        const likeCount = likeButton.querySelector('.like-count');
        const isLiked = likeButton.classList.contains('liked');

        fetch(comment_controller.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json'
            },
            body: new URLSearchParams({
                action: 'comment_controller',
                comment_id: commentId,
                nonce: comment_controller.nonce
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(text => {
                // Удаляем любые лишние символы перед JSON
                const jsonStart = text.indexOf('{');
                const jsonEnd = text.lastIndexOf('}') + 1;
                const jsonString = text.slice(jsonStart, jsonEnd);

                try {
                    return JSON.parse(jsonString);
                } catch (e) {
                    console.error('Raw response:', text);
                    throw new Error('Could not parse JSON response');
                }
            })
            .then(data => {
                if (data.success) {
                    // Обновляем состояние кнопки
                    likeButton.classList.toggle('liked');

                    // Обновляем иконку
                    const themeUrl = comment_controller.themeUrl;
                    likeIcon.src = data.data.is_liked ?
                        `${themeUrl}/img/icons/button_heart_act_20.svg` :
                        `${themeUrl}/img/icons/button_heart_20.svg`;

                    // Обновляем счетчик
                    if (data.data.likes > 0) {
                        likeCount.textContent = data.data.likes;
                        likeCount.style.display = 'flex';
                    } else {
                        likeCount.style.display = 'none';
                    }
                } else if (data.data && data.data.message) {
                    console.error('Server error:', data.data.message);
                } else {
                    console.error('Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});