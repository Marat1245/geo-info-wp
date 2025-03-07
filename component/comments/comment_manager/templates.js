import { ICONS } from './config.js';
import { escapeHtml, formatTimeAgo } from './utils.js';

export const createCommentHTML = (author, text, commentId, likesCount = 0, isLiked = false) => {
    const div = document.createElement('div');
    div.classList.add('comment');

    div.innerHTML = `
        <div class="user_comment"  data-id="${commentId}">
            <div class="user_comment_info">
                <img class="comment_avatar"
                     src="${ICONS.user}" alt="">
                <span class="comment_name">${escapeHtml(author)}</span>
                <span class="comment_time card_caption_text">${formatTimeAgo(new Date())}</span>
            </div>

            <div class="comment_text" data-collapsed="false">
                ${escapeHtml(text)}
                <span class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span>
            </div>

            <div class="comment_control">
                <div>
                    <button class="small_text flat text_icon_btn answer_comment">
                        <span class="card_caption_text">Ответить</span>
                    </button>
                    <button class="small_text flat text_icon_btn like-comment ${isLiked ? 'liked' : ''}">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.9 7.2005V7.20035C2.89985 6.32296 3.26233 5.47685 3.91486 4.85401C4.56831 4.2303 5.45763 3.8839 6.3838 3.90058L6.39422 3.90076L6.40465 3.90071C7.52948 3.8949 8.5966 4.35896 9.33725 5.1651L10 5.88646L10.6628 5.1651C11.4034 4.35896 12.4705 3.8949 13.5954 3.90071L13.6058 3.90076L13.6162 3.90058C14.5424 3.8839 15.4317 4.2303 16.0851 4.85401C16.7377 5.47685 17.1002 6.32296 17.1 7.20035V7.2005C17.1 8.9076 16.0495 10.5124 14.4538 12.0888C13.6691 12.864 12.7892 13.5971 11.9092 14.3024C11.662 14.5005 11.4126 14.6981 11.1652 14.8941C10.7667 15.2099 10.3734 15.5215 10.0026 15.8247C9.61017 15.5013 9.19253 15.1693 8.76984 14.8333C8.54496 14.6546 8.31865 14.4747 8.09394 14.2943C7.21351 13.5877 6.33324 12.8554 5.54786 12.0813C3.95099 10.5075 2.9 8.90824 2.9 7.2005Z" stroke="#BBBBBB" stroke-width="1.8"/>
                        </svg>
                        <span class="card_caption_text">${likesCount}</span>
                    </button>
                </div>

                <div class="selector_wrap">
                    <button class="flat small_icon menu-button" >
                        <img src="${ICONS.menu}" alt="">
                    </button>
                    <div class="selector" style="display: none;">
                        <ul>
                            <li class="edit-comment" >
                                <img src="${ICONS.edit}" alt="">
                                Редактировать
                            </li>
                            <li class="delete-comment">
                                <img src="${ICONS.warning}" alt="">
                                Удалить
                            </li>
                            <li data-li="">
                                <img src="${ICONS.warning}" alt="">
                                Пожаловаться
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `;
    return div;
}; 