document.addEventListener("DOMContentLoaded", () => {
    const notificationText = {
        "link": "Ссылка скопирована"
    };

    function createNotification() {
        if (!document.querySelector(".notification")) {
            const notification = document.createElement("div");
            notification.classList.add("notification");
            notification.innerHTML = `
                <span>Ссылка скопирована</span>
                <img src="./img/icons/close_20.svg" alt="">
            `;
            document.body.appendChild(notification);

            // Закрытие при клике
            notification.addEventListener("click", hideNotification);
        }
    }

    function showNotification(dataValue) {
        createNotification(); // Создаем уведомление, если его нет

        const notification = document.querySelector(".notification");
        const text = notificationText[dataValue] || "Что-то пошло не так";
        notification.querySelector("span").textContent = text;

        // Определяем анимацию в зависимости от ширины экрана
        const translateValue = window.innerWidth > 760 ? "0px" : "-60px";
        notification.style.transform = `translateY(${translateValue})`;

        // Скрываем уведомление через 3 секунды
        setTimeout(hideNotification, 3000);
    }

    function hideNotification() {
        const notification = document.querySelector(".notification");
        if (notification) {
            notification.style.transform = "translateY(100px)";
        }
    }

    document.addEventListener("click", (e) => {
        const clickedElement = e.target.closest(".selector li");
        if (clickedElement && clickedElement.dataset.li === "link") {
            hideNotification();
            setTimeout(() => showNotification(clickedElement.dataset.li), 100);
        }
    });
});
