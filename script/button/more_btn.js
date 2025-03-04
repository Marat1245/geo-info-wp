// КНОПКА БОЛЕШЕ, ДЛЯ ПОКАЗА СКРЫТОГО КОНТЕНТА

export function moreBtn(){

    // Функция для изменения состояния кнопки
    const toggleButtonState = (button, isExpanded) => {
        button.querySelector("span").textContent = isExpanded ? "скрыть" : "больше";
        button.querySelector("img").style.transform = isExpanded ? "rotate(180deg)" : "rotate(0deg)";
    };

    // Функция для изменения максимальной высоты контента
    const toggleContentHeight = (profileText, isExpanded) => {
        profileText.classList.toggle("expanded", isExpanded);

        // Мы уже настроили поведение через CSS, поэтому здесь не требуется `max-height`
    };

    // Обработчик события на кнопках
    document.querySelectorAll(".more_btn_profile").forEach(button => {
        button.addEventListener("click", () => {
            const profileText = button.previousElementSibling; // Ищем соседний элемент

            const isExpanded = !profileText.classList.contains("expanded");

            // Изменяем состояние кнопки и контента
            toggleButtonState(button, isExpanded);
            toggleContentHeight(profileText, isExpanded);
        });
    });

}