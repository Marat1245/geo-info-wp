export function heightList() {
    const $skillsList = $(".list_input"); // Находим список навыков


    $('.skills_input_wrap').on("input", "input", function () {
        const visibleSkills = $skillsList.find("li:not([style*='display: none'])"); // Находим все видимые li

        // Вычисляем высоту в зависимости от количества видимых li
        const liCount = visibleSkills.length;
        const heightPerSkill = 48; // Высота одного элемента li (можно настроить по необходимости)

        // Устанавливаем высоту контейнера, основываясь на количестве видимых элементов
        $skillsList.css("height", liCount * heightPerSkill + 24 + "px");

    });
}