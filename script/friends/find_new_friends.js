// Локальный массив друзей
const friends = [
    { name: "Иван Иванов", link: "#" },
    { name: "Петр Петров", link: "#" },
    { name: "Сергей Сергеев", link: "#" },
    { name: "Анна Смирнова", link: "#" },
    { name: "Мария Кузнецова", link: "#" },
    { name: "Алексей Сидоров", link: "#" },
    { name: "Дмитрий Крылов", link: "#" },
    { name: "Юлия Романова", link: "#" }
];

// Функция для рендера списка друзей
function renderFriends(friends) {
    const friendsList = document.getElementById("friends_list");
    friendsList.innerHTML = ""; // Очищаем список перед рендером

    friends.forEach(friend => {
        const friendHTML = `
        <div class='my_friend'>
            <a href='${friend.link}'>
                <img src='./img/icons/user_24.svg' alt=''>
                <div class='my_friend_name'>${friend.name}</div>
            </a>
            <button class='full_dark small_icon'>
                <img src='./img/icons/user-plus_white_20.svg' alt=''>
            </button>
        </div>`;
        friendsList.insertAdjacentHTML("beforeend", friendHTML);
    });
    friendsList.classList.add("active");
}

// Функция для фильтрации списка друзей
export function searchFriends(query) {
    const filteredFriends = friends.filter(friend =>
        friend.name.toLowerCase().includes(query.toLowerCase())
    );
    renderFriends(filteredFriends);
}

// Обработчик ввода в поле поиска
export function showListNewfriends(func) {
    let defaultSearch = document.getElementById("default_search_friends");
    if (defaultSearch) {
        defaultSearch
            .addEventListener("input", event => {
                const query = event.target.value;


                if (query.length > 3) {
                    func(query);
                }

            });
    }

}



