import { response_template } from './js/response_template.js';
document.addEventListener('DOMContentLoaded', function () {



    document.addEventListener('click', function (e) {
        const answerButton = e.target.closest('.answer_comment'); // кнопка "Ответить"
        if (!answerButton) return;

        const commentBlock = answerButton.closest('.user_comment'); // блок комментария
        if (!commentBlock) return;

        let comment_response_form = commentBlock.querySelector('.comment_response_form'); // ищем форму

        if (comment_response_form) {
            // Если форма уже есть, просто удаляем её (закрытие при повторном нажатии)
            comment_response_form.remove();
        } else {
            // Если формы нет, создаем и добавляем её
            const commentId = commentBlock.dataset.commentId; // id комментария
            const authorName = commentBlock.querySelector('.comment_name').textContent; // имя автора

            const responseForm = response_template(commentId, comment_response, authorName);
            commentBlock.insertAdjacentHTML("beforeend", responseForm);

            // Добавляем класс активности и ставим фокус в поле ввода
            comment_response_form = commentBlock.querySelector('.comment_response_form');

            const input = commentBlock.querySelector('.comment_input');
            requestAnimationFrame(() => {
                input.focus();
                const range = document.createRange();
                const sel = window.getSelection();
                range.selectNodeContents(input);
                range.collapse(false);
                sel.removeAllRanges();
                sel.addRange(range);
            });
        }
    });

    // Обработка клика по кнопке "Отмена"
    document.addEventListener('click', function (e) {
        const cancelButton = e.target.closest('.cancel_response');
        if (!cancelButton) return;

        const commentBlock = cancelButton.closest('.user_comment');
        if (!commentBlock) return;

        const comment_response_form = commentBlock.querySelector('.comment_response_form');
        if (comment_response_form) {
            comment_response_form.remove();
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
            console.log('Пожалуйста, введите текст ответа');
            return;
        }

        // Отправляем ответ на сервер
        fetch(comment_response.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'comment_response',
                parent_id: parentId,

                content: content,
                nonce: comment_response.nonce
            })
        })
            .then(response => response.json())
            .then(response => {

                if (response.success) {

                    // Находим родительский комментарий
                    const parentComment = form.closest('.parent_comment');

                    const childComment = saveButton.closest('.response');

                    // Создаем временный контейнер для парсинга HTML
                    const temp = document.createElement('div');
                    temp.className = 'comment_responses';
                    temp.innerHTML = response.data.html;
                    const newComment = temp.firstElementChild;


                    // Если родительский комментарий существует
                    if (childComment) {
                        // Вставляем новый комментарий после chiledComment
                        childComment.after(newComment);
                    } else {

                        // Находим следующий элемент после родительского комментария
                        let nextComment = parentComment.nextElementSibling;

                        // Перемещаем следующий комментарий в начало блока .comment_responses
                        nextComment.prepend(newComment);

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