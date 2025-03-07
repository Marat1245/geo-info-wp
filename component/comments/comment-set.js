import { handleCommentSubmit, handleCommentDelete, handleCommentEdit, handleCommentRestore } from './comment_manager/handlers.js';

document.addEventListener('DOMContentLoaded', function () {
    // Добавление обработчиков событий
    document.addEventListener('submit', handleCommentSubmit);
    document.addEventListener('click', handleCommentDelete);
    document.addEventListener('click', handleCommentEdit);
    document.addEventListener('click', handleCommentRestore);
});
