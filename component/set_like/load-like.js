document.addEventListener("DOMContentLoaded", function () {
    const postContainer = document.querySelector("body");

    if (!postContainer) return;

    postContainer.addEventListener("click", function (e) {
        const button = e.target.closest(".like-button");
        if (!button) return;

        e.stopPropagation();

        let postId = button.dataset.postId;
        let likeCount = button.closest(".post-item").querySelectorAll(".like-count");
        let buttonAll = button.closest(".post-item").querySelectorAll(".like-button");
        if (!postId) {
            console.error("Ошибка: postId отсутствует");
            return;
        }

        let formData = new FormData();
        formData.append("action", "load_like");
        formData.append("post_id", postId);
        formData.append("nonce", typeof geoInfoLike !== "undefined" ? geoInfoLike.nonce : "");

        // console.log("Отправка запроса:", postId);
        // console.log("Nonce:", geoInfoLike.nonce);
        // console.log("AJAX URL:", geoInfoLike.ajaxurl);

        fetch(geoInfoLike.ajaxurl, {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {

                if (data.success) {
                    if (likeCount) {
                        likeCount.forEach(item => {
                            item.textContent = data.data.likes;
                        })
                    } else {
                        console.warn("⚠️ Предупреждение: like-count не найден внутри кнопки.");
                    }

                    // Меняем состояние кнопки, если лайк поставлен или снят
                    if (data.data.liked) {
                        buttonAll.forEach(item => {
                            item.classList.add("liked")
                        })

                    } else {
                        buttonAll.forEach(item => {
                            item.classList.remove("liked")
                        })

                    }

                } else {
                    console.error("Ошибка: ", data.message);
                }
            })
            .catch(error => console.error("Ошибка запроса: ", error));
    });
});

