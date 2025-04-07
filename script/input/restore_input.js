// Восстановление данных при добавлении новой формы
export const restoreSavedData = function () {
    // Восстанавливаем форму из sessionStorage
    $(document).on("click", ".restore_inputs button", function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение кнопки

        $(this).closest(".restore_inputs").prev(".form_one").css({ display: "flex" });
        $(this).closest(".restore_inputs").remove();

    });
}