import { showAlert, hideAlert } from "./allert_load_input.js";
// import { displayImage } from "./show_image_load.js";
// Разрешенные форматы
const allowedFormats = ["image/jpeg", "image/png"];
const maxSize = 5 * 1024 * 1024; // 5MB
const minWidth = 2400;
const minHeight = 2400;


// Проверка и обработка файла
export function processFile(file, alertBox, callback) {


    // Проверка формата
    if (!allowedFormats.includes(file.type)) {
        showAlert(alertBox, "Формат файла должен быть JPG или PNG.");
        callback(false);
        return;
    }

    // Проверка размера
    if (file.size > maxSize) {

        showAlert(alertBox, "Размер файла должен быть меньше 5MB.");
        callback(false);
        return;
    }

    // Проверка разрешения изображения
    const img = new Image();
    img.onload = function () {
        if (this.width > minWidth || this.height > minHeight) {
            showAlert(alertBox,
                `Разрешение изображения должно быть меньше ${minWidth}×${minHeight} пикселей.`
            );
            callback(false);
        } else {
            hideAlert(alertBox);
            // displayImage(URL.createObjectURL(file), id);
            // img.src = URL.createObjectURL(file);
            callback(true);
        }
    };


    img.onerror = function () {
        showAlert("Не удалось загрузить изображение. Попробуйте другой файл.");
    };
    img.src = URL.createObjectURL(file);
}