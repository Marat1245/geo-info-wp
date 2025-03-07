export class CommentError extends Error {
    constructor(message, code = 'UNKNOWN_ERROR') {
        super(message);
        this.name = 'CommentError';
        this.code = code;
    }
}

export const handleError = (error, defaultMessage) => {
    console.error('Error:', error);
    alert(error.message || defaultMessage);
};

export const validateComment = (text) => {
    if (!text.trim()) {
        throw new CommentError('Введите комментарий', 'EMPTY_COMMENT');
    }
    return true;
}; 