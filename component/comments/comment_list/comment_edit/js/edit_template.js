export const edit_template = (currentContent, comment_edit, commentId) => {
    return `
         <div contenteditable="true" 
                 data-placeholder="Написать комментарий"
                 class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"
                 data-max-length="2500">${currentContent}</div>
            <div class="comment_char_counter" style="display: none;">
                <span class="current_chars">0</span>/2500
            </div>
            <div class="comment_right_block">
                <button type="button" class="flat small_icon cancel_edit">
                    <img src="${comment_edit.templateUrl}/img/icons/close_20.svg" alt="Отменить">
                </button>
                <button type="submit" class="flat small_icon save_edit" data-comment-id="${commentId}">
                    <img src="${comment_edit.templateUrl}/img/icons/leter_36.svg" 
                         alt="Сохранить"
                         data-default-icon="${comment_edit.templateUrl}/img/icons/leter_36.svg" 
                         data-active-icon="${comment_edit.templateUrl}/img/icons/leter_act_36.svg">
                </button>
            </div>
    `;
}
