import { checkAllertInput } from "./check_input.js";

// Обработчик для кнопки удаления
export const deletNewInput = function () {
    $(document).on("click", ".form_one_delete", function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение кнопки
        


        // Находим родительский элемент .form_one, который содержит кнопку
        var $formOne = $(this).closest(".form_one");

        let hasData = saveData($formOne);

        if (hasData) {

            $formOne.css({ display: "none" });

            // Добавляем кнопку восстановления только если есть данные
            $formOne.after(`<div class="restore_inputs" data_form="">
                                <span>Данные удалены</span>
                                <button class="stroke_btn small_text"><span>Восстановить</span></button>
                            </div>`);
        } else {
            $formOne.remove();
        }

        checkAllertInput();
    });


}


function saveData($formOne) {
    let hasData = false;  // Флаг для проверки, есть ли данные

    $formOne.find("input, select").each(function () {
        const value = $(this).val(); // сохраняем данные каждого поля
        if (value) {
            hasData = true;  // Если хотя бы одно поле не пустое, устанавливаем флаг
        }
    });
    return hasData;
}




