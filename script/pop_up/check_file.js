import {showAlert, hideAlert} from "./show_allert_pop_up.js";
import {displayImage} from "./show_image_pop_up.js";

// Разрешенные форматы
const allowedFormats = ["image/jpeg", "image/png"];
const maxSize = 5 * 1024 * 1024; // 5MB
const minWidth = 4000;
const minHeight = 4000;


// Проверка и обработка файла
export function processFile(file, id = "NaN", alertBox) {

    // Проверка формата
    if (!allowedFormats.includes(file.type)) {
        showAlert(alertBox, "Формат файла должен быть JPG или PNG.");
        return;
    }

    // Проверка размера
    if (file.size > maxSize) {
        showAlert(alertBox, "Размер файла должен быть меньше 5MB.");
        return;
    }

    // Проверка разрешения изображения
    const img = new Image();
    img.onload = function () {
        if (this.width > minWidth || this.height > minHeight) {
            showAlert(alertBox,
                `Разрешение изображения должно быть меньше ${minWidth}×${minHeight} пикселей.`
            );
        } else {
            hideAlert(alertBox);


            displayImage(URL.createObjectURL(file), id);

        }
    };


    img.onerror = function () {
        showAlert("Не удалось загрузить изображение. Попробуйте другой файл.");
    };
    img.src = URL.createObjectURL(file);
}

