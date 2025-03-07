import { handleError } from './errors.js';
import { CommentError } from './errors.js';

export class CommentLikes {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        document.addEventListener('click', this.handleLikeClick.bind(this));
    }

    async handleLikeClick(event) {
        const likeButton = event.target.closest('.like-comment');
        if (!likeButton) {
            return;
        }

        event.preventDefault();
        const commentId = likeButton.closest('.user_comment').dataset.id;
        const isLiked = likeButton.classList.contains('liked');

        try {
            const response = await this.toggleLike(commentId, !isLiked);
            this.updateLikeUI(likeButton, response);
        } catch (error) {
            handleError(error, 'Ошибка при обновлении лайка');
        }
    }

    async toggleLike(commentId, shouldLike) {
        if (!window.commentNonce) {
            console.error('Comment nonce is not available');
            throw new CommentError('Ошибка безопасности', 'SECURITY_ERROR');
        }

        const formData = new FormData();
        formData.append('action', 'toggle_comment_like');
        formData.append('comment_id', commentId);
        formData.append('is_liked', shouldLike ? '1' : '0');
        formData.append('nonce', window.commentNonce);

        try {
            const response = await fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const responseText = await response.text();

            // Ищем JSON в ответе
            const jsonMatch = responseText.match(/\{[\s\S]*\}/);
            if (!jsonMatch) {
                throw new CommentError('Некорректный ответ от сервера', 'INVALID_RESPONSE');
            }

            let responseData;
            try {
                responseData = JSON.parse(jsonMatch[0]);
            } catch (e) {
                console.error('Failed to parse like response:', e);
                throw new CommentError('Некорректный ответ от сервера', 'INVALID_RESPONSE');
            }

            if (!responseData.success) {
                throw new CommentError(responseData.data || 'Ошибка при обновлении лайка', 'SERVER_ERROR');
            }

            return responseData.data;
        } catch (error) {
            console.error('Like request failed:', error);
            throw error;
        }
    }

    updateLikeUI(likeButton, response) {
        let countElement = likeButton.querySelector('.likes-count');

        if (response.likes_count > 0) {
            if (!countElement) {
                countElement = document.createElement('span');
                countElement.className = 'card_caption_text likes-count';
                likeButton.appendChild(countElement);
            }
            countElement.textContent = response.likes_count;
        } else if (countElement) {
            countElement.remove();
        }

        if (response.is_liked) {
            likeButton.classList.add('liked');
        } else {
            likeButton.classList.remove('liked');
        }
    }
} 