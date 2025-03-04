import { sortList } from "./sort_list_friends.js";
import { debounce } from "./debounce_friends.js";
import { searchFriends, showListNewfriends } from "./find_new_friends.js";
import { disappearfriends } from './disappear_friends.js';

$(document).ready(function () {
    sortList(".messenger_list_wrap", "#search_messeges", ".chat_item");
    sortList(".friends_list_wrap", "#default_search_friends", ".my_friend")
    // Создаем дебаунс-обертку
    let debouncedSearchFriends = debounce(searchFriends, 1000);

    // Вызываем функцию и передаем debouncedSearchFriends
    showListNewfriends(debouncedSearchFriends);

    disappearfriends();
})