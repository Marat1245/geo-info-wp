import { API_ENDPOINT } from './config.js';
import { CommentError } from './errors.js';

export const apiRequest = async (action, data) => {
    try {
        // Добавляем nonce для безопасности WordPress
        const formData = new URLSearchParams({
            action,
            nonce: window.commentNonce, // Нужно будет добавить это в PHP
            ...data
        });

        console.log('Sending request:', {
            url: API_ENDPOINT,
            action,
            data: Object.fromEntries(formData)
        });

        const response = await fetch(API_ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        });

        const responseText = await response.text();
        console.log('Raw server response:', responseText);

        let responseData;
        try {
            responseData = JSON.parse(responseText);
        } catch (e) {
            console.error('Failed to parse JSON response:', e);
            throw new CommentError('Некорректный ответ от сервера', 'INVALID_RESPONSE');
        }

        if (!response.ok) {
            throw new CommentError(responseData.message || 'Ошибка сервера', 'SERVER_ERROR');
        }

        return responseData;
    } catch (error) {
        console.error('API Request failed:', error);
        if (error instanceof CommentError) {
            throw error;
        }
        throw new CommentError(error.message || 'Ошибка при выполнении запроса', 'REQUEST_ERROR');
    }
};

export const addComment = async (commentData) => {
    console.log('Adding comment with data:', commentData);
    const response = await apiRequest('add_comment', commentData);
    console.log('Add comment response:', response);
    return response;
};

export const deleteComment = async (commentId) => {
    return apiRequest('delete_comment', { comment_id: commentId });
};

export const updateComment = async (commentId, newContent) => {
    return apiRequest('update_comment', {
        comment_id: commentId,
        new_content: newContent
    });
};

export const restoreComment = async (commentId) => {
    console.log('Sending restore request for comment:', commentId);
    const response = await apiRequest('restore_comment', { comment_id: commentId });
    console.log('Restore API response:', response);
    return response;
};