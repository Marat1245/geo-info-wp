import { appendBadge } from "./badge_management.js";

export function addSkills() {
    const $skillsInput = $(".skills_input_wrap input"); // Поле ввода
    const $skillsList = $(".list_input ul"); // Список навыков
    const $skillsListLi = $(".list_input ul li"); // Список навыков
    const skillTemplate = (text) => `
        <li>${text}<img class="list_input_active" src="./img/icons/check_20.svg" alt=""></li>
    `;

    let newSkill = false;
    let inputValue = "";

    $('.skills_input_wrap').on("input", "input", function (event) {
        event.preventDefault();
        inputValue = $skillsInput.val().trim();
        // Проверка, существует ли такой навык
        const skillExists = $skillsList.find(`li:contains('${inputValue}')`).length > 0;
        if ($(".list_input").find(`p`).length !== 0) {
            $(".list_input").find(`p`).remove();
        }
        if (inputValue !== "" && $(".list_input").find(`p`).length === 0 && !skillExists) {

            $skillsList.append(`<p>Нажмите на + и добавьте навык</p>`);
            newSkill = true;

        }

    });

    // Также добавляем функционал на кнопку "+"
    $(".skills_input_wrap button").on("click", function (event) {
        event.preventDefault();
        $(".list_input").find(`p`).remove();
        if (newSkill) {
            $skillsList.append(skillTemplate(inputValue));
            $skillsInput.val(""); // Очищаем input

            appendBadge(inputValue);

            $skillsListLi.css("display", "flex");
        }

    });

}
