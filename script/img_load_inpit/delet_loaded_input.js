// При нажатие на удаление загруженного изображения, удаляет его и возвращает input для загрузки изображения

export function deletInput() {
    $("form").on("click", ".edit_image_wrap button:last-child", function (e) {
        e.preventDefault();
        $(this).parents(".edit_image_loaded_wrap").prev().css({ display: "flex" });
        $(this).parents(".edit_image_loaded_wrap").remove();
    });
} 