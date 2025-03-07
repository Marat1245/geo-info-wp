import { addComment, deleteComment, updateComment, restoreComment } from './api.js';
import { createCommentHTML } from './templates.js';
import { getCommentFormData, toggleCommentVisibility } from './dom.js';
import { handleError, validateComment } from './errors.js';

export class CommentManager {
    constructor() {
        console.log("CommentManager constructor called");
        this.currentPage = 1;
        this.loading = false;
        this.bindEvents();
    }

    bindEvents() {
        console.log("Initializing CommentManager event handlers...");
        document.addEventListener('submit', handleCommentSubmit);
        document.addEventListener('click', handleCommentDelete);
        document.addEventListener('click', handleCommentRestore);
        document.addEventListener('click', handleCommentEdit);
        document.addEventListener('click', this.handleLoadMore.bind(this));
        console.log("CommentManager event handlers initialized");
    }

    async handleLoadMore(event) {
        const loadMoreBtn = event.target.closest('#load-more-comments');
        if (!loadMoreBtn || this.loading) return;

        this.loading = true;
        loadMoreBtn.classList.add('loading');

        try {
            const response = await this.loadMoreComments();
            this.appendComments(response.comments);

            if (!response.has_more) {
                loadMoreBtn.remove();
            } else {
                const remaining = Math.min(response.remaining, 5);
                loadMoreBtn.querySelector('span').textContent = `Ещё ${remaining} комментариев`;
            }
        } catch (error) {
            console.error('Failed to load more comments:', error);
        } finally {
            this.loading = false;
            loadMoreBtn.classList.remove('loading');
        }
    }

    async loadMoreComments() {
        this.currentPage++;
        const postId = document.querySelector('input[name="post_id"]').value;

        const response = await fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                action: 'load_more_comments',
                post_id: postId,
                page: this.currentPage,
                nonce: window.commentNonce
            })
        });

        if (!response.ok) {
            throw new Error('Failed to load comments');
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error(data.data || 'Failed to load comments');
        }

        return data.data;
    }

    appendComments(comments) {
        const commentsContainer = document.querySelector('.comments_list');
        if (!commentsContainer) return;

        comments.forEach(comment => {
            const commentElement = this.createCommentElement(comment);
            commentsContainer.appendChild(commentElement);
        });
    }

    createCommentElement(comment) {
        const template = document.createElement('template');
        template.innerHTML = `
            <div class="user_comment" data-id="${comment.id}">
                <div class="user_comment_info">
                    <img class="comment_avatar" src="${window.templateUrl}/img/icons/user_24.svg" alt="">
                    <span class="comment_name">${comment.author}</span>
                    <span class="comment_time card_caption_text">${this.formatDate(comment.date)}</span>
                </div>
                <div class="comment_text" data-collapsed="false">
                    ${comment.content}
                    <span class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span>
                </div>
                <div class="comment_control">
                    <div>
                        <button class="small_text flat text_icon_btn answer_comment">
                            <span class="card_caption_text">Ответить</span>
                        </button>
                        <button class="small_text flat text_icon_btn like-comment">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.9 7.2005V7.20035C2.89985 6.32296 3.26233 5.47685 3.91486 4.85401C4.56831 4.2303 5.45763 3.8839 6.3838 3.90058L6.39422 3.90076L6.40465 3.90071C7.52948 3.8949 8.5966 4.35896 9.33725 5.1651L10 5.88646L10.6628 5.1651C11.4034 4.35896 12.4705 3.8949 13.5954 3.90071L13.6058 3.90076L13.6162 3.90058C14.5424 3.8839 15.4317 4.2303 16.0851 4.85401C16.7377 5.47685 17.1002 6.32296 17.1 7.20035V7.2005C17.1 8.9076 16.0495 10.5124 14.4538 12.0888C13.6691 12.864 12.7892 13.5971 11.9092 14.3024C11.662 14.5005 11.4126 14.6981 11.1652 14.8941C10.7667 15.2099 10.3734 15.5215 10.0026 15.8247C9.61017 15.5013 9.19253 15.1693 8.76984 14.8333C8.54496 14.6546 8.31865 14.4747 8.09394 14.2943C7.21351 13.5877 6.33324 12.8554 5.54786 12.0813C3.95099 10.5075 2.9 8.90824 2.9 7.2005Z" stroke="#BBBBBB" stroke-width="1.8"/>
                            </svg>
                            <span class="card_caption_text">${comment.likes_count}</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
        return template.content.firstElementChild;
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;

        const minutes = Math.floor(diff / 60000);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (minutes < 60) {
            return `${minutes} мин. назад`;
        } else if (hours < 24) {
            return `${hours} ч. назад`;
        } else {
            return `${days} д. назад`;
        }
    }
}

export const handleCommentSubmit = async (event) => {
    const form = event.target.closest('.comment_input_wrap');
    if (!form) return;

    event.preventDefault();

    try {
        const { commentText, postID, author, button, contentEditable } = getCommentFormData(form);
        validateComment(commentText);

        button.disabled = true;
        const data = await addComment({ comment_content: commentText, post_id: postID, author });

        if (data.success) {
            const commentSection = form.closest('.post-item').querySelector('.comment_input_wrap');
            console.log('Response data:', data);
            const newComment = createCommentHTML(author, commentText, data.data.comment_id);
            commentSection.after(newComment);
            contentEditable.textContent = '';
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        handleError(error, 'Произошла ошибка при добавлении комментария');
    } finally {
        const button = form.querySelector('button[type="submit"]');
        const contentEditable = form.querySelector('.comment_input');
        button.disabled = false;
        contentEditable.classList.add("placeholder");
    }
};

export const handleCommentDelete = async (event) => {
    if (!event.target.classList.contains('delete-comment')) return;
    if (!confirm('Вы уверены, что хотите удалить этот комментарий?')) return;

    try {
        const commentElement = event.target.closest('.user_comment');
        const commentID = commentElement.dataset.id;
        const data = await deleteComment(commentID);

        if (data.success) {
            const deleteWrap = commentElement.querySelector('.delete_comment_wrap');
            deleteWrap.dataset.commentContent = commentElement.innerHTML;
            toggleCommentVisibility(commentElement, false);
        } else {
            throw new Error(data.message || 'Ошибка при удалении комментария');
        }
    } catch (error) {
        handleError(error, 'Произошла ошибка при удалении комментария');
    }
};

export const handleCommentRestore = async (event) => {
    if (!event.target.closest('.restore_comment')) return;

    try {
        const deleteWrap = event.target.closest('.delete_comment_wrap');
        const commentID = event.target.closest('.user_comment').dataset.id;

        if (!commentID) {
            throw new Error('ID комментария не найден');
        }

        const data = await restoreComment(commentID);
        if (data.success) {
            toggleCommentVisibility(deleteWrap.closest('.user_comment'), true);
        } else {
            throw new Error(data.message || 'Ошибка при восстановлении комментария');
        }
    } catch (error) {
        handleError(error, 'Произошла ошибка при восстановлении комментария');
    }
};

export const handleCommentEdit = async (event) => {
    if (!event.target.classList.contains('edit-comment')) return;

    try {
        const commentElement = event.target.closest('.user_comment');
        const commentID = commentElement.dataset.id;
        const commentText = commentElement.querySelector('.comment_text');
        const currentText = commentText.textContent;
        const newText = prompt('Редактировать комментарий:', currentText);

        if (!newText || newText === currentText) return;

        validateComment(newText);
        const data = await updateComment(commentID, newText);

        if (data.success) {
            commentText.textContent = newText;
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        handleError(error, 'Произошла ошибка при обновлении комментария');
    }
}; 