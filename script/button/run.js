import { moreBtn} from "./more_btn.js";
import {btnSwitcher} from "./btn_switcher.js";
import {showMoreBtn} from "./show_more_btn.js";

document.addEventListener("DOMContentLoaded", () => {
    moreBtn();

    btnSwitcher(
        ".profil_switch_wrap button",
        ".profile_right_block",
        ".profile_right_block_switch .profile_right_content"
    );
    showMoreBtn();
})