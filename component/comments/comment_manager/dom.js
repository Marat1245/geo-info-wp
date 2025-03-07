export const getCommentElements = (commentElement) => {
    return {
        info: commentElement.querySelector('.user_comment_info'),
        text: commentElement.querySelector('.comment_text'),
        control: commentElement.querySelector('.comment_control'),
        deleteWrap: commentElement.querySelector('.delete_comment_wrap')
    };
};

export const toggleCommentVisibility = (commentElement, isVisible) => {
    const elements = getCommentElements(commentElement);
    const action = isVisible ? 'remove' : 'add';

    elements.info.classList[action]('hidden');
    elements.text.classList[action]('hidden');
    elements.control.classList[action]('hidden');
    elements.deleteWrap.classList[action === 'remove' ? 'add' : 'remove']('hidden');
};

export const getCommentFormData = (form) => {
    const contentEditable = form.querySelector('.comment_input');
    const commentText = contentEditable.innerHTML
        .replace(/<br\s*\/?>/g, '\n')
        .replace(/<div>/g, '\n')
        .replace(/<\/div>/g, '');

    return {
        commentText,
        postID: form.querySelector('[name="post_id"]').value,
        author: form.querySelector('[name="author"]').value,
        button: form.querySelector('button[type="submit"]'),
        contentEditable
    };
}; 