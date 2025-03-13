import { comment_template } from './js/template_comment.js';
import { getContentEditableText } from '../js/getContentEditableText .js';
import { updateCharCounter } from '../js/updateCharCounter.js';
import { truncateText } from '../js/truncateText.js';
import { updateSubmitButton } from '../js/updateSubmitButton.js';
document.addEventListener('DOMContentLoaded', function () {
    const MAX_LENGTH = 2500;
    const SHOW_COUNTER_AT = 2250; // Показывать счетчик, когда осталось 250 символов

    // Функция для преобразования HTML в текст с переносами строк
    // const getContentEditableText = (element) => {
    //     // Получаем HTML контент
    //     let html = element.innerHTML;

    //     // Заменяем <div> и </div> на переносы строк
    //     html = html.replace(/<div>/gi, '\n').replace(/<\/div>/gi, '');

    //     // Удаляем все остальные HTML теги
    //     html = html.replace(/<[^>]+>/g, '');

    //     // Декодируем HTML сущности
    //     let txt = document.createElement("textarea");
    //     txt.innerHTML = html;
    //     let decodedText = txt.value;

    //     // Убираем множественные переносы строк и пробелы
    //     decodedText = decodedText.replace(/\n{3,}/g, '\n\n');

    //     // Убираем пробелы в начале и конце каждой строки
    //     decodedText = decodedText.split('\n')
    //         .map(line => line.trim())
    //         .join('\n')
    //         .trim();

    //     return decodedText;
    // };

    // Функция для ограничения текста по максимальной длине
    // const truncateText = (text) => {
    //     return text.length > MAX_LENGTH ? text.substring(0, MAX_LENGTH) : text;
    // };

    // Функция обновления счетчика символов
    // const updateCharCounter = (commentInput, charCounter) => {
    //     const text = getContentEditableText(commentInput);
    //     const length = text.length;
    //     const currentCharsSpan = charCounter.querySelector('.current_chars');

    //     if (currentCharsSpan) {
    //         currentCharsSpan.textContent = length;
    //     }

    //     // Показываем счетчик, если осталось менее 250 символов до лимита
    //     if (length >= SHOW_COUNTER_AT) {
    //         charCounter.style.display = 'block';
    //     } else {
    //         charCounter.style.display = 'none';
    //     }

    //     // Добавляем красный цвет, если превышен лимит
    //     if (length > MAX_LENGTH) {
    //         charCounter.classList.add('exceeded');
    //     } else {
    //         charCounter.classList.remove('exceeded');
    //     }
    // };

    // Функция обновления состояния кнопки
    // const updateSubmitButton = (commentInput, submitButton) => {
    //     const content = getContentEditableText(commentInput);
    //     const img = submitButton.querySelector('img');
    //     const length = content.length;

    //     if (!content || length > MAX_LENGTH) {
    //         submitButton.disabled = true;
    //         if (img) {
    //             img.src = img.dataset.defaultIcon;
    //         }
    //     } else {
    //         submitButton.disabled = false;
    //         if (img) {
    //             img.src = img.dataset.activeIcon;
    //         }
    //     }
    // };

    // Функция инициализации формы комментария
    const initCommentForm = (commentForm) => {
        const commentInput = commentForm.querySelector('.comment_input');
        const submitButton = commentForm.querySelector('button[type="submit"]');
        const charCounter = commentForm.querySelector('.comment_char_counter');

        if (!commentInput || !submitButton || !charCounter) return;

        // Инициализация начального состояния
        updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
        updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH);


        // Обработка вставки текста
        commentInput.addEventListener('paste', (e) => {
            e.preventDefault();

            // Получаем текущий текст
            const currentText = getContentEditableText(commentInput);
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

            // Обновляем состояние
            updateSubmitButton(commentInput, submitButton, MAX_LENGTH);
            updateCharCounter(commentInput, charCounter, SHOW_COUNTER_AT, MAX_LENGTH);
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
                    commentForm.insertAdjacentHTML('afterend', commentHtml);
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