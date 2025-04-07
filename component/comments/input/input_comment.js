import { comment_template } from './js/template_comment.js';
import { getContentEditableText } from '../js/getContentEditableText .js';
import { updateCharCounter } from '../js/updateCharCounter.js';
import { truncateText } from '../js/truncateText.js';
import { updateSubmitButton } from '../js/updateSubmitButton.js';
document.addEventListener('DOMContentLoaded', function () {
    const MAX_LENGTH = 2500;
    const SHOW_COUNTER_AT = 2250; // Показывать счетчик, когда осталось 250 символов



    // Функция инициализации формы комментария
    const initCommentForm = (commentForm) => {
        const commentInput = commentForm.querySelector('.comment_input');
        const submitButton = commentForm.querySelector('button[type="submit"]');
        const charCounter = commentForm.querySelector('.comment_char_counter');
        const commentList = commentForm.closest('.post_item').querySelector('.comment_list');


        if (!commentInput || !submitButton || !charCounter) return;

        // Инициализация начального состояния
        updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
        updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH);


        commentInput.addEventListener('paste', (e) => {
            e.preventDefault();

            // Получаем текст из буфера обмена
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');

            // Получаем текущий текст
            const currentText = commentInput.textContent;


            // Вычисляем, сколько символов можно вставить
            const remainingSpace = 2500 - currentText.length;


            // Обрезаем вставляемый текст, если нужно
            const trimmedText = pastedText.slice(0, remainingSpace);


            // Получаем текущее выделение
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);

            // Удаляем выделенный текст (если есть)
            range.deleteContents();

            // Вставляем обрезанный текст в текущую позицию курсора
            const textNode = document.createTextNode(trimmedText);
            range.insertNode(textNode);

            // Перемещаем курсор в конец вставленного текста
            const newRange = document.createRange();
            newRange.setStart(textNode, textNode.length);
            newRange.setEnd(textNode, textNode.length);

            selection.removeAllRanges();
            selection.addRange(newRange);

            // Обновляем состояние (если нужно)
            updateSubmitButton(commentInput, submitButton, 2500);
            updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, 2500);
        });



        // Обработка ввода текста
        commentInput.addEventListener('input', (e) => {

            const text = getContentEditableText(commentInput);

            if (text.length > MAX_LENGTH) {
                e.preventDefault();

                // Обрезаем текст до максимальной длины
                const truncated = truncateText(text, MAX_LENGTH);

                // Сохраняем позицию курсора
                const selection = window.getSelection();
                const range = document.createRange();

                // Обновляем содержимое с сохранением переносов строк
                commentInput.innerHTML = truncated.replace(/\n/g, '<div>');

                // Восстанавливаем курсор в конец текста
                range.selectNodeContents(commentInput);
                range.collapse(false);
                selection.removeAllRanges();
                selection.addRange(range);
            }

            updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
            updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH);
        });

        // Обработка потери фокуса
        commentInput.addEventListener('blur', () => {
            if (!getContentEditableText(commentInput)) {
                commentInput.classList.add('placeholder');
                charCounter.style.display = 'none';
            }
        });

        // Обработка получения фокуса
        commentInput.addEventListener('focus', () => {
            commentInput.classList.remove('placeholder');
            updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH);
        });

        const handleSubmit = async (e) => {
            e.preventDefault();

            const content = getContentEditableText(commentInput);

            if (!content) {
                alert('Пожалуйста, введите текст комментария');
                return;
            }

            if (content.length > MAX_LENGTH) {
                alert(`Максимальная длина комментария ${MAX_LENGTH} символов`);
                return;
            }

            const postId = commentForm.querySelector('input[name="post_id"]').value;

            if (submitButton) {
                submitButton.disabled = true;
            }

            try {
                const formData = new URLSearchParams();
                formData.append('action', 'create_comment');
                formData.append('post_id', postId);
                formData.append('content', content);
                formData.append('nonce', input_comment.nonce);

                const response = await fetch(input_comment.ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(formData).toString()
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Очищаем contenteditable
                    commentInput.innerHTML = '';
                    commentInput.classList.add('placeholder');
                    charCounter.style.display = 'none';
                    const commentHtml = comment_template(data.data);

                    commentList.insertAdjacentHTML('afterbegin', commentHtml);
                    // commentList.insertAdjacentHTML('beforebegin', commentHtml);
                    // Обновляем состояние кнопки после очистки
                    updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
                } else {
                    alert(data.data || 'Произошла ошибка при отправке комментария');
                }
            } catch (error) {
                console.error('Ошибка при отправке комментария:', error);
                alert('Произошла ошибка при отправке комментария');
            } finally {
                if (submitButton) {
                    updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
                }
            }
        };

        commentForm.addEventListener('submit', handleSubmit);
    };

    // Инициализация всех существующих форм
    document.querySelectorAll('.comment_input_wrap').forEach(initCommentForm);

    // Наблюдатель за новыми формами
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1) {
                    const forms = node.classList.contains('comment_input_wrap')
                        ? [node]
                        : node.querySelectorAll('.comment_input_wrap');

                    forms.forEach(initCommentForm);
                }
            });
        });
    });

    // Начинаем наблюдение за изменениями в DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});