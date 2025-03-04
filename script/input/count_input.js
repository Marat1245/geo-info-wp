export function countInput() {
    let count = 0;
    $(".add_new_btn").on("click", function () {

        // Находим первый блок .form_one в форме
        var $form = $(this).closest("form"); // Находим ближайшую форму

        count = $form.find(".form_one").length;
        console.log(count);

        if (count > 20) {
            $(".add_new_btn button").attr('disabled', true);
        } else {
            $(".add_new_btn button").removeAttr('disabled');
        }
    });

}