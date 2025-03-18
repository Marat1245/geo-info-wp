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
                input.innerHTML = `${authorName},&nbsp;`;
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
                    const parentComment = form.closest('.parent_comment');

                    const childComment = form.closest('.response');
                    // Создаем временный контейнер для парсинга HTML
                    const temp = document.createElement('div');
                    temp.className = 'comment_responses';
                    temp.innerHTML = response.data.html;
                    const newComment = temp.firstElementChild;

                    if (childComment) {

                        // Вставляем новый комментарий после chiledComment
                        childComment.after(newComment);
                    } else {

                        // Находим следующий элемент после родительского комментария
                        let nextComment = parentComment.nextElementSibling;
                        // Если блок с дочерними комментариями существует
                        if (nextComment) {
                            // Перемещаем следующий комментарий в начало блока .comment_responses
                            nextComment.after(newComment);
                        }
                    }


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