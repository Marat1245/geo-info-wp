document.addEventListener('DOMContentLoaded', function () {
    const MAX_LENGTH = 2500;
    const SHOW_COUNTER_AT = 2250;

    // Обработка клика по кнопке "Ответить"
    document.addEventListener('click', function (e) {
        const answerButton = e.target.closest('.answer_comment');
        if (!answerButton) return;

        const commentBlock = answerButton.closest('.user_comment');
        if (!commentBlock) return;

        const commentId = commentBlock.dataset.commentId;
        const authorName = commentBlock.querySelector('.comment_name').textContent;

        // Получаем форму ответа для текущего комментария
        let responseForm = commentBlock.querySelector('.comment_response_form');

        // Если форма существует и уже отображается, скрываем её
        if (responseForm && responseForm.style.display === 'block') {
            window.commentManager.closeAllForms(commentBlock);
            return;
        }

        // Показываем форму ответа для текущего комментария
        if (responseForm) {
            responseForm.style.display = 'block';
            // Вставляем имя автора в поле ввода
            const input = responseForm.querySelector('.comment_input');
            if (input) {
                input.innerHTML = `@${authorName},&nbsp;`;
                // Устанавливаем фокус и перемещаем курсор в конец
                input.focus();
                const range = document.createRange();
                const sel = window.getSelection();
                range.selectNodeContents(input);
                range.collapse(false);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    });

    // Обработка отмены ответа
    document.addEventListener('click', function (e) {
        const cancelButton = e.target.closest('.cancel_response');

        if (!cancelButton) return;

        const responseForm = cancelButton.closest('.comment_response_form');
        if (responseForm) {
            responseForm.style.display = 'none';
            // Очищаем поле ввода
            const input = responseForm.querySelector('.comment_input');
            if (input) {
                input.textContent = '';
                // Меняем иконку на исходную
                const icon = responseForm.querySelector('.comment_icon');
                if (icon) {
                    icon.src = icon.dataset.defaultIcon;
                }
            }
        }
    });

    // Обработка счетчика символов и активации кнопки
    document.addEventListener('input', function (e) {
        const input = e.target.closest('.comment_input');
        if (!input) return;

        const form = input.closest('.comment_response_form');
        if (!form) return;

        const counter = form.querySelector('.comment_char_counter');
        const currentChars = form.querySelector('.current_chars');
        const saveButton = form.querySelector('.save_response');
        const icon = saveButton.querySelector('img');
        const length = input.textContent.length;

        // Обновляем счетчик символов
        currentChars.textContent = length;

        // Показываем/скрываем счетчик
        if (length >= SHOW_COUNTER_AT) {
            counter.style.display = 'block';
            if (length > MAX_LENGTH) {
                counter.classList.add('exceeded');
            } else {
                counter.classList.remove('exceeded');
            }
        } else {
            counter.style.display = 'none';
        }

        // Активируем/деактивируем кнопку и меняем иконку
        if (saveButton && icon) {
            if (length > 0 && length <= MAX_LENGTH) {
                saveButton.disabled = false;
                icon.src = icon.dataset.activeIcon;
            } else {
                saveButton.disabled = true;
                icon.src = icon.dataset.defaultIcon;
            }
        }

        // Ограничиваем длину текста
        if (length > MAX_LENGTH) {
            input.textContent = input.textContent.substring(0, MAX_LENGTH);
        }
    });

    // Обработка вставки текста
    document.addEventListener('paste', function (e) {
        const input = e.target.closest('.comment_input');
        if (!input) return;

        e.preventDefault();
        const currentText = input.textContent;
        let pastedText = (e.clipboardData || window.clipboardData).getData('text');

        // Вычисляем, сколько символов можно вставить
        const remainingSpace = MAX_LENGTH - currentText.length;

        if (remainingSpace <= 0) return;

        // Обрезаем вставляемый текст, если нужно
        if (pastedText.length > remainingSpace) {
            pastedText = pastedText.substring(0, remainingSpace);
        }

        // Вставляем текст
        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        range.deleteContents();
        range.insertNode(document.createTextNode(pastedText));
    });

    // Обработка отправки ответа
    document.addEventListener('click', function (e) {
        const saveButton = e.target.closest('.save_response');
        if (!saveButton || saveButton.disabled) return;

        const form = saveButton.closest('.comment_response_form');
        const input = form.querySelector('.comment_input');
        const parentId = form.dataset.parentId;
        const content = input.textContent.trim();


        if (!content) {
            alert('Пожалуйста, введите текст ответа');
            return;
        }

        // Отправляем ответ на сервер
        fetch(comment_ajax.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'comment_response',
                parent_id: parentId,

                content: content,
                nonce: comment_ajax.nonce
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    // Находим родительский комментарий
                    const parentComment = form.closest('.user_comment');
                    if (!parentComment) return;

                    // Создаем временный контейнер для парсинга HTML
                    const temp = document.createElement('div');
                    temp.innerHTML = response.data.html;
                    const newComment = temp.firstElementChild;


                    // Вставляем новый комментарий после родительского
                    parentComment.querySelector('.comment_responses').appendChild(newComment);

                    // Скрываем и очищаем форму
                    form.style.display = 'none';
                    input.textContent = '';
                    // Возвращаем исходную иконку
                    const icon = form.querySelector('.comment_icon');
                    if (icon) {
                        icon.src = icon.dataset.defaultIcon;
                    }
                } else {
                    alert(response.data.message || 'Произошла ошибка при отправке ответа');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при отправке ответа');
            });
    });
});

// Вспомогательная функция для создания контейнера ответов
function createResponseContainer(commentBlock) {
    const container = document.createElement('div');
    container.className = 'comment_responses';
    commentBlock.appendChild(container);
    return container;
} 