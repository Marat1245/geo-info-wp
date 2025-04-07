export const checkInput = function () {


    $('.edit_save_btn button').on('click', function (e) {
        e.preventDefault(); // Предотвращаем стандартное поведение кнопки

        checkAllertInput(this);
    });
}



export function checkAllertInput(element) {
    let allFieldsValid = true;



    let $formWrap = $(element).closest("form"); // Находим ближайшую форму
    let $formVisible = $formWrap.find(".form_one:visible"); // Ищем все видимые элементы .form_one
    let $bgAllert = $formWrap.find('.edit_input_allert');

    $($bgAllert).empty();

    $formVisible.each(function () {
        let $form = $(this); // Текущая видимая форма
     
        $form.find('input[required], textarea[required]').each(function () {


            if ($(this).val().trim() === '') {
                allFieldsValid = false;

                // Получаем текст предыдущего элемента (метки) без "*"
                const fieldName = $(this).prev('label').text().replace('*', '').trim();

                // Подсвечиваем поле с ошибкой
                $(this).css({ border: "1px red solid" });

                // Добавляем сообщение об ошибке
                $($bgAllert).append(`<p>Поле "${fieldName}" обязательно для заполнения.</p>`);

                // Стили для сообщений
                $($bgAllert).find("p").css('color', 'var(--color_text_dark)');
                $($bgAllert).css('background', 'var(--color_background_grey)');
                $($bgAllert).show();


            } else {

                $(this).css({ border: "1px var(--color_stroke_grey) solid" })


            }

        });

        $form.find('select[required]').each(function () {
            const $select = $(this);  // Получаем текущий элемент select

            // Проверяем значение только текущего select
            if ($select.val() === null || $select.val() === "") {
                allFieldsValid = false;

                // Получаем текст предыдущего элемента (метки) без "*"
                const fieldName = $select.prev('label').text().replace('*', '').trim();

                // Подсвечиваем поле с ошибкой
                $select.css({ border: "1px red solid" });

                // Добавляем сообщение об ошибке
                $($bgAllert).append(`<p>Поле "${fieldName}" обязательно для заполнения.</p>`);

                // Стили для сообщений
                $($bgAllert).find("p").css('color', 'var(--color_text_dark)');
                $($bgAllert).css('background', 'var(--color_background_grey)');
                $($bgAllert).show();
            } else {
                // Если поле заполнено, подсвечиваем его как правильное
                $select.css({ border: "1px var(--color_stroke_grey) solid" });
            }
        });

    });



    // Если все поля заполнены правильно
    if (allFieldsValid) {
        $($bgAllert).css('background', 'var(--color_background_green)');
        $($bgAllert).html('<p>Все сохранено успешно!</p>');
        $($bgAllert).find("p").css('color', 'white');
        $($bgAllert).show();
        $('input[required], textarea[required]').css({ border: "1px var(--color_stroke_grey) solid" })

    } else {
        // $($bgAllert).html('<p>Данные не сохранились</p>');
        // $($bgAllert).css('background', 'var(--color_background_red)');
        // $($bgAllert).find("p").css('color', 'white');
        // $($bgAllert).show();

    }
}


