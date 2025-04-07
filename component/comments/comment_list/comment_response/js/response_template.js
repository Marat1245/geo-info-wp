export const response_template = (parent_comment_id, comment_ajax, author_name) => {
    return `
        <div class="comment_response_form"  data-parent-id="${parent_comment_id}">
            <div class="comment_input_wrap">
                <div contenteditable="true" 
                     data-placeholder="Написать ответ"
                     class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"
                     data-max-length="2500"><div>${author_name},&nbsp;</div></div>
                <div class="comment_char_counter" style="display: none;">
                    <span class="current_chars">0</span>/2500
                </div>
                <div class="comment_right_block">
                    <button type="button" class="flat small_icon cancel_response">
                        <img src="${comment_ajax.templateUrl}/img/icons/close_20.svg" alt="Отменить">
                    </button>
                    <button type="submit" class="flat small_icon save_response" data-parent-id="${parent_comment_id}">
                        <img src="${comment_ajax.templateUrl}/img/icons/leter_36.svg" 
                             alt="Отправить"
                             data-default-icon="${comment_ajax.templateUrl}/img/icons/leter_36.svg" 
                             data-active-icon="${comment_ajax.templateUrl}/img/icons/leter_act_36.svg">
                    </button>
                </div>
                
            </div>
           
        </div>
    `;
}