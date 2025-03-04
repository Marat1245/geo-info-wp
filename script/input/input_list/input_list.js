import { openList } from "./open_list.js";
import { choseTags } from "./chose_tags.js";

export function input(data, wrap, disabledInput, placeholder) {
    const block = `
        <div class="wrap_input_selector">
            <input name="type_post" type="text" placeholder="${placeholder}" ${disabledInput ? "readonly" : ""} class="${disabledInput ? "readonly_input" : ""}">
            <button class="flat small_icon"><img src="./img/icons/Arrow_down_20.svg" alt=""></button>
            <div class="t_list_input post_list">
                <ul></ul>
            </div>
        </div>`;

    $(wrap).append(block);

    const listContainer = $(wrap).find('.wrap_input_selector .post_list ul');
    if (!listContainer.length) return;

    // Очищаем список и добавляем новые элементы
    listContainer.empty();
    data.forEach(item => {
        const li = $('<li>').text(item);  // Используем jQuery для создания элементов
        listContainer.append(li);
    });

    openList();
    choseTags(wrap);
}



