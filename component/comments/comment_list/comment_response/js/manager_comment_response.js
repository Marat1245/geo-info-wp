// Функция для проверки открытых форм
function hasOpenForms(commentBlock) {
    const editForm = commentBlock.querySelector('.comment_edit_form');
    const responseForm = commentBlock.querySelector('.comment_response_form');

    return (editForm && editForm.style.display !== 'none') ||
        (responseForm && responseForm.style.display !== 'none');
}

// Функция для закрытия всех форм
function closeAllForms(commentBlock) {
    const editForm = commentBlock.querySelector('.comment_edit_form');
    const responseForm = commentBlock.querySelector('.comment_response_form');

    if (editForm) {
        editForm.style.display = 'none';
        const editInput = editForm.querySelector('.comment_input');
        if (editInput) {
            editInput.textContent = '';
        }
    }

    if (responseForm) {
        responseForm.style.display = 'none';
        const responseInput = responseForm.querySelector('.comment_input');
        if (responseInput) {
            responseInput.textContent = '';
        }
    }
}

// Экспортируем функции
window.commentManager = {
    hasOpenForms,
    closeAllForms
};
