export function showList(
    listInput = "#tags_list",
    wrapInput = ".tags_input_wrap"
) {

    $(document).on("click", function (e) {

        if (!$(e.target).closest(wrapInput).length) {

            $(listInput).css("display", "none");

        }

    });
    $(wrapInput).on("click", "input, button", function () {
        console.log("click")
        // Найти текущий блок .skills_input_wrap
        const $currentWrap = $(this).closest(wrapInput);

        // Найти listInput внутри текущего блока
        const $listInput = $currentWrap.find(listInput);

        // Показать только текущий listInput
        $(listInput).css("display", "block");

    });



}