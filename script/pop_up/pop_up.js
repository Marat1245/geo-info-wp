
import DragDrop from "./drag_drop.js";
import ShowPopUp from "./show_pop_up.js";
import { processFile } from "./check_file.js";

document.addEventListener("DOMContentLoaded", () => {
    ShowPopUp();

    const fileInput = document.getElementById("fileInput");
    if (!fileInput) {return}
    const uploadButtons = document.querySelectorAll(".btn_input_img, .edit_image_container");
    const alertBox = document.querySelector(".pop_up_allert");
    const buttons = document.querySelectorAll("button.edit_photo_btn, li[data-block='img']");
    let selectedId = "";

    /**
     * Обработчик выбора изображения через input[type="file"]
     */
    const handleFileSelect = (event) => {
        const file = event.target.files[0];
        event.target.value = "";
        if (file) processFile(file, selectedId, alertBox);
    };

    /**
     * Обработчик Drag & Drop загрузки файлов
     */
    const handleDragDrop = (files) => {
        if (files.length > 0) processFile(files[0], selectedId, alertBox);
    };

    /**
     * Инициализация событий для кнопок редактирования фото
     */
    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            selectedId = button.getAttribute("id") || "";
            DragDrop.init(".pop_up_container", handleDragDrop);
        });
    });

    /**
     * Инициализация событий для кнопок загрузки
     */
    uploadButtons.forEach((button) => {
        button.addEventListener("click", () => fileInput.click());
    });

    fileInput.addEventListener("change", handleFileSelect);
});
