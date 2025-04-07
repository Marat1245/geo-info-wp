import { showNotification } from '../../script/notification.js';

document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.artical_share');

        if (btn) {

            const postItem = btn.closest('.post_item');
            if (!postItem) return;

            const postLink = postItem.dataset.postLink;
            if (!postLink) return;

            // Проверяем поддержку clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(postLink)
                    .then(() => {
                        showNotification();
                    })
                    .catch(err => console.error("Ошибка копирования:", err));
            } else {
                // Если clipboard API не поддерживается — используем старый способ
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = postLink;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                showNotification();
            }
        }
    });
});
