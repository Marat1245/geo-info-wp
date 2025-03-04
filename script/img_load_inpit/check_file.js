import { processFile } from "./check_load_input.js";

// Заносит введенные данные в переменные
export function checkFile(files, $area) {
    // Проверка на тип файла
    const alertBox = $(".edit_input_allert");
    processFile(files[0], alertBox, function (result) {

        if (result) {
            const areaImg = $area.parents(".edit_image_container");


            areaImg.css({
                display: "none",
            });
            areaImg.after(`<div class="edit_image_loaded_wrap add_block_for_copy">
                        <div class="edit_image_loaded">
                            <img src="./img/diplom_01.png" alt="">
                        </div>
                        <div class="edit_image_wrap">
                            <button class="small_text stroke_btn"><span>Изменить</span></button>
                            <button class="small_icon stroke_btn"><img src="./img/icons/delete_20.svg"
                                    alt=""></button>
                        </div>
                       

                    </div>`);
            areaImg.next().css({ display: "flex" });
        }
    });



}
