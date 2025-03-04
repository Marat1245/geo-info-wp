// Обработчик ввода в поле поиска
export function disappearfriends() {
    const searchInput = document.getElementById("default_search_friends");
    const friendsList = document.getElementById("friends_list");

    if (searchInput && friendsList) {
        searchInput.addEventListener("input", event => {
            const query = event.target.value;
            let isClearing = false; // Флаг, чтобы отслеживать, что происходит удаление текста
            if (query.length < 3) {
                // Если поле поиска пустое
                friendsList.innerHTML = ""; // Очищаем список
                friendsList.classList.remove("active"); // Убираем класс active
                isClearing = true;
            } else {
                isClearing = false;
            }

            // Очищаем класс active, если список пуст и нет поиска
            setInterval(() => {
                if (!isClearing && searchInput.value === "") {
                    friendsList.classList.remove("active");
                    friendsList.innerHTML = ""; // Очищаем список
                }
            }, 500); // Проверка каждую секунду, можно настроить задержку
        });
    }

}