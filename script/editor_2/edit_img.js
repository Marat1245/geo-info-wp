import { displayImage } from "../pop_up/show_image_pop_up.js";
import ShowPopUp from "../pop_up/show_pop_up.js";
import { enableCropping } from "../pop_up/crop_img_pop_up.js";
import { ShowEditImg } from "./show_edit_img.js";

export function editImg(editor) {

    // Назначаем обработчик на родительский элемент
    editor.addEventListener('click', (event) => {
        const cropImg = event.target.closest('.crop_img'); // Проверяем, является ли кликнутый элемент .crop_img

        if (!cropImg) return; // Если это не .crop_img, выходим

        // Находим родителя с классом image-container
        const imageContainer = cropImg.closest('.image-container');


        if (imageContainer) {
            // Ищем <img> внутри image-container
            const image = imageContainer.querySelector('img');


            if (image) {
                // Получаем src изображения
                const imageSrc = image.src;
                // Устанавливаем изображение в popup
                const popUpImage = document.querySelector(".edit_img_pop_up img");
                popUpImage.src = imageSrc; // Устанавливаем изображение

                // Ожидаем, пока изображение загрузится
                popUpImage.onload = () => {
                    // После загрузки изображения, инициализируем Cropper
                    enableCropping(null,"edit_img", {imageContainer: imageContainer});
                };

                // Если изображение уже было загружено, то вызовем onload сразу
                if (popUpImage.complete) {
                    popUpImage.onload(); // Вызываем onload вручную, если изображение уже загружено
                }

            }
        }
    });

    // Вызываем ShowEditImg для дополнительных настроек (если нужно)
    ShowEditImg();
}
