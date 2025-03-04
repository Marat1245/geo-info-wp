import { enableCropping } from "./crop_img_pop_up.js";

const imageHTMLFirst = document.querySelector(".pop_up_one");
const imageHTMLSecond = document.querySelector(".pop_up_two");
let imageSecondImg = imageHTMLSecond?.querySelector("img") || "";


// Функция отображения изображения
export function displayImage(src, id = null, edit = false) {
    imageHTMLFirst.style.display = "none"; // Скрываем первый блок
    imageHTMLSecond.style.display = "block"; // Показываем второй блок
    imageSecondImg.src = src; // Устанавливаем изображение

    enableCropping(id);
}

// Обработчик событий для кнопки "Назад" и закрытия попапа
document.addEventListener("click", (event) => {

    if (

        event.target.closest(".btn_load_back, .pop_up_bg, .pop_up_close, .btn_load_img")

    ) {
        imageHTMLFirst.style.display = "block"; // Показываем первый блок
        imageHTMLSecond.style.display = "none"; // Скрываем второй блок
        imageSecondImg.src = ""; // Очищаем изображение
    }
});
