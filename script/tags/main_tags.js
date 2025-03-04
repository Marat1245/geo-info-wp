// import { addTag } from './list_tags.js';
import { setTag } from "./set_tags.js";
import { showList } from "./show_list_tags.js";
import { choseTags } from "./chose_tags.js";
import { manageDelete } from "./manage_delete.js";
$(document).ready(function () {

    setTag();
    showList();
    choseTags();
    manageDelete();
});