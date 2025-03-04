export function openList() {
    $(document).on("click", ".wrap_input_selector", function () {
        $(".t_list_input").css({ display: 'none' });
        $(this).find(".t_list_input").css({ display: 'flex' });
        $("body").addClass("wrap_input_selector_hidden")
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".wrap_input_selector").length || $(e.target).closest("li").length) {
            $(".t_list_input").css({ display: 'none' });

            $("body").removeClass("wrap_input_selector_hidden")
        }
    });
}