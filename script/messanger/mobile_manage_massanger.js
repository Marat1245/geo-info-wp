export function mobileManageMes() {

    let size = false;
    let heightBody = $("body").width();

    // Обработчик для события изменения размера окна
    $(window).on("resize", function () {
        heightBody = $("body").width();

        // Проверка, если ширина меньше 680px
        if (heightBody < 640) {
            size = true;
            $(".user_messages").css({ display: "none" });
            $(".have_messeges_wrap").css({ display: "block" });

        } else {
            size = false;
            $(".have_messeges_wrap, .user_messages").css({ display: "block" });
        }

        // Логика, которая будет выполняться только если ширина меньше 680px
        if (size) {
            let chatListItem = $(".chat_list_wrap .chat_item");

            chatListItem.click(function () {
                
                $(".user_messages").css({ display: "block" });
                $(".have_messeges_wrap").css({ display: "none" });
            });

            $("#back_chat_list").click(function () {
                $(".user_messages").css({ display: "none" });
                $(".have_messeges_wrap").css({ display: "block" });
            });
        }
    });

    // Важно добавить начальную проверку при загрузке страницы
    $(window).trigger('resize');
}
