export const comment_template = (comment) => {
    // Заменяем переносы строк на <br>
    const formattedContent = comment.content.replace(/\n/g, '<br>');

    return `
        <div class="user_comment" data-comment-id="${comment.id}">
            <div class="user_comment_info">
                <img class="comment_avatar" src="${input_comment.templateUrl}/img/icons/user_24.svg" alt="Аватар пользователя">
                <span class="comment_name">${comment.author}</span>
                <span class="comment_time card_caption_text">${comment.date}</span>
            </div>
            <div class="comment_text" data-collapsed="false">
                <span>${formattedContent}</span>
                <span class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span>
            </div>
            <div class="comment_control">
                
                    <button class="small_text flat text_icon_btn answer_comment">
                        <span class="card_caption_text">Ответить</span>
                    </button>
                    <button class="small_text flat text_icon_btn like-comment-button ${comment.my_likes}" data-comment-id="${comment.id}">
                        <img class="like-icon" 
                            src="${input_comment.templateUrl}/img/icons/${comment.my_likes === 'liked' ? 'button_heart_act_20.svg' : 'button_heart_20.svg'}" 
                            alt="${comment.my_likes === 'liked' ? 'Пользователь поставил лайк' : 'Лайк'}" 
                            data-default-icon="${input_comment.templateUrl}/img/icons/button_heart_20.svg" 
                            data-active-icon="${input_comment.templateUrl}/img/icons/button_heart_act_20.svg">
                        <span class="card_caption_text like-count" style="display: ${comment.likes > 0 ? 'flex' : 'none'}">
                            ${comment.likes}
                        </span>
                    </button>
                
                <div class="selector_wrap">
                    <button class="flat  micro">
                        <img src="${input_comment.templateUrl}/img/icons/point_menu_20.svg" alt="">
                    </button>
                    <div class="selector" style="display: none;">
                        ${comment.user_id === input_comment.currentUserId ? `
                            <ul>
                                <li data-li="" class="edit-comment">
                                    <img src="${input_comment.templateUrl}/img/icons/Edit_20.svg" alt="">
                                    Редактировать комментарий
                                </li>
                                <li data-li="" class="delete-comment">
                                    <img src="${input_comment.templateUrl}/img/icons/delete_20.svg" alt="">
                                    Удалить комментарий
                                </li>
                            </ul>
                        ` : `
                            <ul>
                                <li data-li="">
                                    <img src="${input_comment.templateUrl}/img/icons/Warning_outline_20.svg" alt="">
                                    Пожаловаться
                                </li>
                            </ul>
                        `}
                    </div>
                </div>
            </div>
            <div class="delete_comment_wrap comment-restore" style="display: none;">
                <div>Комментарий удалён</div>
                <button class="small_text flat text_icon_btn restore_comment"><span class="card_caption_text">Восстановить</span>

            </div>
        </div>
    `;
};