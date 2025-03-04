export function allert_messanger() {
    const blockUser = $("li[data-li=block_user]");
    const allertWrap = $(".allert_wrap");
    const textarea = $("#user_messages")


    blockUser.click(function () {
        console.log("dddd");
        allertWrap.append(`<div class="allert allert_warning row">
                <p>Пользователь заблокирован</p>
                <button class="full_dark small_text"><span>Востановить</span></button>
            </div>`);

        textarea.prop("disabled", true);
    });
}