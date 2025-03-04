import { imaskSetting } from "./imask.js";
import { checkInput } from "./check_input.js";
import { addNewInputs } from "./add_new_input.js";
import { deletNewInput } from "./delet_new_input.js"
import { selectorDate } from "./selector_date_input.js"
import { restoreSavedData } from "./restore_input.js";
import { countInput } from "./count_input.js";
import { btnSwitcher } from "../button/btn_switcher.js";
import { grabBlock } from "../grab_block.js";
import { runInput } from "./input_list/main.js";

$(document).ready(function () {
    // sessionStorage.clear();
    imaskSetting();
    checkInput();
    addNewInputs();

    deletNewInput();
    $("form").on("click", ".add_new_btn", function (e) {
        e.preventDefault();
        // 
        selectorDate();
    });
    selectorDate();
    restoreSavedData();

    countInput();

    btnSwitcher(".switch_wrap_btn button ", ".edit_switch_block", ".edit_switch_content");
    grabBlock();
    runInput();
})