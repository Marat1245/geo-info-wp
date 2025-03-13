import { getContentEditableText } from '../../../js/getContentEditableText .js';
import { edit_template } from './edit_template.js';
import { truncateText } from '../../../js/truncateText.js';
import { updateSubmitButton } from '../../../js/updateSubmitButton.js';

document.addEventListener('DOMContentLoaded', function () {
    const MAX_LENGTH = 2500;
    const SHOW_COUNTER_AT = 2250;





    // Обработка клика по кнопке редактирования
    document.body.addEventListener('click', function (e) {

        const editButton = e.target.closest('.edit-comment');
        if (!editButton) return;

        const commentBlock = editButton.closest('.user_comment');
        if (!commentBlock) return;

        const commentId = commentBlock.dataset.commentId;
        const commentText = commentBlock.querySelector('.comment_text > span');
        const commentControl = commentBlock.querySelector('.comment_control');

        if (!commentText || !commentControl) return;

        // Получаем текущий контент с сохранением форматирования
        const currentContent = commentText.innerHTML;



        // Создаем форму редактирования
        const editForm = templateEdit(currentContent, comment_edit, commentId)

        // Скрываем текущий текст и показываем форму
        hideEditForm(editForm, commentText, commentControl, commentBlock);

        const contentEditable = editForm.querySelector('.t_contenteditable');
        const charCounter = editForm.querySelector('.comment_char_counter');
        const currentChars = editForm.querySelector('.current_chars');
        // Сохраняем исходный текст для сравнения, нормализуя переносы строк
        const originalContent = getContentEditableText(contentEditable);
        // Обработка отмены редактирования
        showEditForm(editForm, commentText, commentControl, commentBlock);

        // Обработка сохранения
        const saveButton = editForm.querySelector('.save_edit');
        updateSubmitButton(contentEditable, saveButton, MAX_LENGTH);
        if (saveButton) {
            saveButton.addEventListener('click', function () {
                if (!contentEditable) return;

                const content = getContentEditableText(contentEditable);


                if (!content) {
                    alert('Пожалуйста, введите текст комментария');
                    return;
                }

                if (content.length > MAX_LENGTH) {
                    alert(`Максимальная длина комментария ${MAX_LENGTH} символов`);
                    return;
                }

                // Подробное логирование для отладки
                // console.log('Original content:', JSON.stringify(originalContent));
                // console.log('New content:', JSON.stringify(content));
                // console.log('Are equal:', content === originalContent);
                // console.log('Original length:', originalContent.length);
                // console.log('New length:', content.length);

                // Проверяем, изменился ли текст
                if (content === originalContent) {
                    // Если текст не изменился, просто закрываем форму редактирования
                    commentText.style.display = 'block';
                    commentControl.style.display = 'flex';
                    editForm.remove();
                    return;
                }

                // Проверяем, что у нас есть правильный URL для AJAX
                if (!comment_edit.ajaxurl) {
                    console.error('AJAX URL не определен');
                    return;
                }

                const formData = new FormData();
                formData.append('action', 'edit_comment');
                formData.append('comment_id', commentId);
                formData.append('content', content);
                formData.append('nonce', comment_edit.nonce);

                // Отправляем AJAX-запрос
                fetch(comment_edit.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Обновляем текст комментария с сохранением форматирования
                            commentText.innerHTML = data.data.content.replace(/\n/g, '<br>');
                            commentText.style.display = 'block';
                            commentControl.style.display = 'flex';

                            // Показываем метку "Изменено"
                            const changedLabel = commentBlock.querySelector('.comment_changed');
                            if (changedLabel) {
                                changedLabel.classList.add('active');
                            }

                            // Удаляем форму редактирования
                            editForm.remove();
                        } else {
                            console.error('Server response:', data);

                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);

                    });
            });
        }

        // Обработка счетчика символов
        if (contentEditable && charCounter && currentChars) {
            const updateCharCounter = () => {
                const text = getContentEditableText(contentEditable);
                const length = text.length;
                currentChars.textContent = length;

                if (length >= SHOW_COUNTER_AT) {
                    charCounter.style.display = 'block';
                } else {
                    charCounter.style.display = 'none';
                }

                if (length > MAX_LENGTH) {
                    charCounter.classList.add('exceeded');
                } else {
                    charCounter.classList.remove('exceeded');
                }
            };

            // Предотвращаем вставку текста через контекстное меню
            contentEditable.addEventListener('contextmenu', (e) => {
                e.preventDefault();
            });

            // Обработка вставки текста
            contentEditable.addEventListener('paste', (e) => {
                e.preventDefault();

                // Получаем текущий текст
                const currentText = getContentEditableText(contentEditable);
                let pastedText = (e.clipboardData || window.clipboardData).getData('text');

                // Получаем позицию курсора
                const selection = window.getSelection();
                if (!selection.rangeCount) return;

                const range = selection.getRangeAt(0);
                const startOffset = range.startOffset;

                // Вычисляем, сколько символов мы можем вставить
                const remainingSpace = MAX_LENGTH - currentText.length + (selection.toString().length);

                if (remainingSpace <= 0) {
                    return; // Если места нет, не вставляем ничего
                }

                // Обрезаем вставляемый текст, если нужно
                if (pastedText.length > remainingSpace) {
                    pastedText = pastedText.substring(0, remainingSpace);
                }

                // Удаляем выделенный текст
                selection.deleteFromDocument();

                // Вставляем новый текст
                const textNode = document.createTextNode(pastedText);
                range.insertNode(textNode);

                // Перемещаем курсор в конец вставленного текста
                range.setStartAfter(textNode);
                range.setEndAfter(textNode);
                selection.removeAllRanges();
                selection.addRange(range);

                // Обновляем счетчик
                updateCharCounter();

            });

            // Обработка ввода текста
            contentEditable.addEventListener('input', (e) => {
                const text = getContentEditableText(contentEditable);
                console.log(text);
                if (text.length > MAX_LENGTH) {
                    e.preventDefault();

                    // Обрезаем текст до максимальной длины
                    const truncated = truncateText(text, MAX_LENGTH);

                    // Сохраняем позицию курсора
                    const selection = window.getSelection();
                    const range = document.createRange();

                    // Обновляем содержимое с сохранением переносов строк
                    contentEditable.innerHTML = truncated.split('\n').map(line => `<div>${line}</div>`).join('');

                    // Восстанавливаем курсор в конец текста
                    range.selectNodeContents(contentEditable);
                    range.collapse(false);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }

                updateCharCounter();
                updateSubmitButton(contentEditable, saveButton, MAX_LENGTH);
            });

            // Инициализация начального состояния счетчика
            updateCharCounter();
        }
    });
});

function templateEdit(currentContent, comment_edit, commentId) {
    // Создаем форму редактирования
    const editForm = document.createElement('div');
    editForm.className = 'comment_input_wrap comment_edit_wrap';
    editForm.innerHTML = edit_template(currentContent, comment_edit, commentId);
    return editForm;
}

function hideEditForm(editForm, commentText, commentControl, commentBlock) {
    const comment_text = commentBlock.querySelector('.comment_text');

    // Скрываем текущий текст и показываем форму
    commentText.style.display = 'none';
    comment_text.parentNode.insertBefore(editForm, comment_text.nextSibling);
    commentControl.style.display = 'none';

    comment_text.style.maxHeight = 'none';

    const toggle_text = commentBlock.querySelector('.toggle_text');
    toggle_text.style.display = 'none';
}

function showEditForm(editForm, commentText, commentControl,) {
    // Обработка отмены редактирования
    const cancelButton = editForm.querySelector('.cancel_edit');
    if (cancelButton) {
        cancelButton.addEventListener('click', function () {
            editForm.remove();
            commentText.style.display = 'block';
            commentControl.style.display = 'flex';
        });
    }
}
