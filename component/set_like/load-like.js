/**
 * Система лайков для постов
 * 
 * Основной принцип работы:
 * 1. Отслеживаем клики по кнопкам лайков на странице
 * 2. При клике отправляем AJAX-запрос на сервер
 * 3. Получаем обновленное состояние (количество лайков и статус лайка)
 * 4. Обновляем все связанные элементы на странице
 */
document.addEventListener("DOMContentLoaded", function () {

    // Используем body как контейнер для делегирования событий
    const postContainer = document.querySelector("body");
    if (!postContainer) return;

    // Делегируем обработку кликов на уровень body
    postContainer.addEventListener("click", function (e) {
        // Проверяем, был ли клик по кнопке лайка или её дочерним элементам
        const button = e.target.closest(".like-button");
        if (!button) return;

        // Предотвращаем стандартное поведение и всплытие события
        e.preventDefault();
        e.stopPropagation();

        // Проверка авторизации пользователя
        // Если пользователь не авторизован, перенаправляем на страницу входа
        if (!geoInfoLike.isLoggedIn) {
            window.location.href = geoInfoLike.loginUrl;
            return;
        }

        // Находим родительский элемент поста
        // Это нужно для обновления всех связанных элементов именно этого поста
        const postItem = button.closest(".post-item");
        if (!postItem) {
            console.error("Ошибка: элемент .post-item не найден");
            return;
        }

        // Получаем ID поста из data-атрибута родительского элемента
        const postId = postItem.dataset.postId;
        if (!postId) {
            console.error("Ошибка: postId отсутствует в родительском элементе");
            return;
        }

        // Находим все элементы, связанные с лайками в текущем посте:
        // - кнопки лайков (может быть несколько копий одной кнопки)
        // - иконки внутри кнопок
        // - счетчики количества лайков
        const buttonAll = postItem.querySelectorAll(".like-button");

        // Логируем количество найденных элементов для отладки
        // console.group('Обработка лайка');
        // console.log('Найдено элементов:', {
        //     buttons: buttonAll.length,
        //     icons: likeIcons.length,
        //     counts: likeCounts.length
        // });

        // Подготавливаем данные для отправки на сервер
        const formData = new FormData();
        formData.append("action", "load_like"); // WordPress action hook
        formData.append("post_id", postId);     // ID поста
        formData.append("nonce", geoInfoLike.nonce); // Защитный токен

        // Добавляем индикацию загрузки на все кнопки лайка в посте
        buttonAll.forEach(btn => btn.classList.add("loading"));

        // Отправляем AJAX-запрос на сервер
        fetch(geoInfoLike.ajaxurl, {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Логируем ответ сервера
                // console.group('Ответ сервера');
                // console.log('Данные:', data);
                // console.log('Количество лайков:', data.data.likes);
                // console.log('Статус лайка:', data.data.liked);
                // console.groupEnd();

                // Процесс обновления разделен на три этапа:

                // 1. Обновляем иконки
                // Меняем изображение и alt-текст в зависимости от состояния лайка
                if (buttonAll.length > 0) {
                    // console.group('Обновление иконок');
                    buttonAll.forEach((item, index) => {
                        const icon = item.querySelector(".like-icon");
                        const count = item.querySelector(".like-count");
                        // const oldSrc = icon.src;
                        if (data.data.liked) {
                            // Если пост лайкнут - показываем активную иконку
                            icon.src = icon.dataset.activeIcon;
                            icon.alt = "Пользователь поставил лайк";
                            // Обновляем значение счетчика
                            count.textContent = data.data.likes;
                            // Показываем счетчик только если есть хотя бы один лайк
                            count.style.display = data.data.likes > 0 ? 'flex' : 'none';
                        } else {
                            // Если пост не лайкнут - показываем обычную иконку
                            icon.src = icon.dataset.defaultIcon;
                            icon.alt = "Лайк";
                            // Обновляем значение счетчика
                            count.textContent = data.data.likes;
                            // Показываем счетчик только если есть хотя бы один лайк
                            count.style.display = data.data.likes > 0 ? 'flex' : 'none';
                        }
                        // console.log(`Иконка ${index + 1}:`, {
                        //     было: oldSrc.split('/').pop(),
                        //     стало: icon.src.split('/').pop(),
                        //     alt: icon.alt
                        // });
                    });
                    // console.groupEnd();
                }


                // 3. Обновляем состояние кнопок
                // Добавляем задержку для плавности анимации
                setTimeout(() => {
                    // console.group('Обновление кнопок');
                    buttonAll.forEach((btn, index) => {
                        // const oldClasses = btn.className;
                        // Сначала убираем индикатор загрузки
                        btn.classList.remove("loading");

                        // Обновляем класс в зависимости от состояния лайка
                        if (data.data.liked) {
                            btn.classList.add("liked");
                        } else {
                            btn.classList.remove("liked");
                        }

                        // console.log(`Кнопка ${index + 1}:`, {
                        //     'классы было': oldClasses,
                        //     'классы стало': btn.className,
                        //     'статус лайка': data.data.liked
                        // });
                    });
                    // console.groupEnd();
                }, 300); // Задержка для плавности анимации
            })
            // Обработка ошибок
            .catch(error => {
                // Если произошла ошибка, показываем сообщение
                console.error("Ошибка запроса:", error);
                alert(geoInfoLike.messages.error);
                // Убираем индикатор загрузки со всех кнопок
                buttonAll.forEach(btn => btn.classList.remove("loading"));
            })
            .finally(() => {
                // Закрываем группу логов
                // console.groupEnd();
            });
    });
});

