import DragDrop from "./drag_drop_load.js";
import { deletInput } from "./delet_loaded_input.js";
import { checkFile } from "./check_file.js";



$(document).ready(function () {
    // Инициализация DragDrop для всех элементов
    dragDrop()

    // Повторная инициализация после клонирования
    $("form").on("click", ".add_new_btn", function (e) {
        e.preventDefault();
        // Повторная инициализация DragDrop после клика
        dragDrop()
    });
    // Удаление загруженного изображения
    deletInput();

});

// Инициализация DragDrop
function dragDrop() {
    // Инициализация DragDrop для всех элементов
    DragDrop.init(".edit_image_container div", function (files, $area) {
        // Получаем файл и текущую зону
        checkFile(files, $area);

    });
}

$(document).ready(function () {

    let isClicked = false;
    $("form").on("click", ".edit_image_container, .edit_image_wrap button:first-child", function (e) {

        // Если уже произошел клик, пропускаем дальнейшую обработку
        if (isClicked) return;

        isClicked = true;
        let inputFile = null;

        if ($(this).hasClass("edit_image_container")) {
            inputFile = $(this).children(".input_for_file")[0]; // Получаем DOM-элемент

        } else {
            inputFile = $(this).parents(".edit_image_loaded_wrap").prev('.edit_image_container').children(".input_for_file")[0];
        }

        const inputClickEvent = new MouseEvent("click", {
            bubbles: true,  // событие будет всплывать
            cancelable: true, // событие можно отменить
        });

        // Остановим всплытие события, чтобы предотвратить зацикливание
        e.stopImmediatePropagation();

        // Инициализируем клик на input[type="file"]
        inputFile.dispatchEvent(inputClickEvent);

        // Сбрасываем флаг после завершения обработки
        setTimeout(() => {
            isClicked = false;
        }, 0); // Убираем блокировку сразу после завершения текущего цикла событий

    });

});


$(document).ready(function () {
    $("form").on("click", ".edit_image_container,  .edit_image_wrap button:first-child", function (e) {



        const fileInput = $(this).children(".input_for_file");
        const $area = $(this).find("div");

        $(fileInput).off("change").on("change", function () {

            let file = this.files
            if (file) {
                checkFile(file, $area);
            }
        });

    });
});













