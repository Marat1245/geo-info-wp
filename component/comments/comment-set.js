document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("submit", function (event) {
        const form = event.target.closest(".comment_input_wrap");
        if (!form) return;

        event.preventDefault();

        let contentEditable = form.querySelector(".comment_input");
        let commentText = contentEditable.textContent.trim();
        let postID = form.querySelector("[name='post_id']").value;
        let author = form.querySelector("[name='author']").value;

        if (!commentText) {
            alert("Введите комментарий");
            return;
        }

        let button = form.querySelector("button[type='submit']");
        button.disabled = true;
        button.innerHTML = "⏳";

        fetch("/wp-admin/admin-ajax.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "add_comment",
                comment_content: commentText,
                post_id: postID,
                author: author
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Находим правильный список комментариев
                    let commentSection = form.closest(".post").querySelector(".comments_list");
                    let newComment = document.createElement("div");
                    newComment.classList.add("comment");
                    newComment.innerHTML = `
                    <p><strong>${author}:</strong> ${commentText}</p>
                    <button class="edit-comment" data-id="${data.comment_id}">✏️</button>
                    <button class="delete-comment" data-id="${data.comment_id}">❌</button>
                `;
                    commentSection.prepend(newComment);

                    // Очищаем поле ввода
                    contentEditable.textContent = "";
                } else {
                    alert(data.message);
                }
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = `<img src="/wp-content/themes/yourtheme/img/icons/leter_36.svg" alt="">`;
            });
    });


    // Удаление комментария
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-comment")) {
            let commentID = event.target.dataset.id;
            fetch("/wp-admin/admin-ajax.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    action: "delete_comment",
                    comment_id: commentID
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        event.target.closest(".comment").remove();
                    } else {
                        alert(data.message);
                    }
                });
        }
    });

    // Обновление комментария
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("edit-comment")) {
            let commentID = event.target.dataset.id;
            let commentElement = event.target.closest(".comment").querySelector("p");
            let newText = prompt("Редактировать комментарий:", commentElement.textContent);

            if (newText) {
                fetch("/wp-admin/admin-ajax.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        action: "update_comment",
                        comment_id: commentID,
                        new_content: newText
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            commentElement.textContent = newText;
                        } else {
                            alert(data.message);
                        }
                    });
            }
        }
    });
});
