export const addNewInputs = function () {



    $(".add_new_btn button").on("click", function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение кнопки

        // Находим первый блок .form_one в форме
        var $form = $(this).closest("form"); // Находим ближайшую форму
        var $formOne = $form.find(".form_one:first"); // Первый .form_one
        var $formLast = $form.find(".form_one:last"); // Последний .form_one

        console.log($(this))
        // Клонируем этот первый блок
        var $newFormOne = $formOne.clone();

        // Генерация уникальной строки (хеш)
        function generateUniqueId() {
            return 'form_' + Math.random().toString(36).substr(2, 9);
        }

        // Герерируем хеш
        var formCount = generateUniqueId();

        // Добавляем data-form с уникальным значением
        $newFormOne.attr('data-form', formCount);

        // Очищаем значения в новом блоке
        $newFormOne.find("input, select").each(function () {
            $(this).val(""); // Сбрасываем значения input и select
            $(this).css({ border: "1px var(--color_stroke_grey) solid" });

        });
        $newFormOne.css({ display: "flex" });

        // Вставляем новый блок form_one после последнего блока
        $formLast.after($newFormOne);

        $(".edit_input_allert").css({ display: "none" });
    });

}