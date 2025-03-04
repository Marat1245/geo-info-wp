// // Восстановление данных при добавлении новой формы
// export const restoreSavedData = function () {
//     // Восстанавливаем форму из sessionStorage
//     $(document).on("click", ".restore_inputs button", function (event) {
//         event.preventDefault(); // Предотвращаем стандартное поведение кнопки



//         // Находим первый блок .form_one в форме
//         var $formOne = $("form .form_one:first");

//         // Клонируем этот первый блок
//         var $newFormOne = $formOne.clone();

//         // Пытаемся восстановить данные из sessionStorage, если они есть
//         const formHash = $(this).closest(".restore_inputs").attr("data_form"); // новый индекс формы
//         const savedData = JSON.parse(sessionStorage.getItem(`${formHash}`));


//         if (savedData) {

//             // Восстанавливаем данные в полях формы
//             $newFormOne.find("input, select").each(function () {
//                 const name = $(this).attr('name');

//                 if (savedData[name]) {
//                     $(this).val(savedData[name]); // Восстанавливаем значение из sessionStorage
//                 }
//                 $(this).css({ border: "1px var(--color_stroke_grey) solid" });

//             });
//             $newFormOne.attr("data-form", formHash);
//             console.log($newFormOne)
//         }

//         // Вставляем новый блок form_one на то место где кнопка востановить

//         $(this).closest(".restore_inputs").after($newFormOne);

//         $(".restore_inputs").remove();
//     });
// }


// Восстановление данных при добавлении новой формы
export const restoreSavedData = function () {
    // Восстанавливаем форму из sessionStorage
    $(document).on("click", ".restore_inputs button", function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение кнопки

        $(this).closest(".restore_inputs").prev(".form_one").css({ display: "flex" });
        $(this).closest(".restore_inputs").remove();

    });
}