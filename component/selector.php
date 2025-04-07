<?php
function renderSelector($isMyPost)
{
    $template_uri = get_template_directory_uri(); // Получаем путь к шаблону

    $liList = '
        <ul>
            <li data-li="link"><img src="' . $template_uri . '/img/icons/link_20.svg" alt="">Скопировать ссылку</li>
            <li data-li="link"><img src="' . $template_uri . '/img/icons/vk_20.svg" alt="">Vk</li>
            <li data-li="link"><img src="' . $template_uri . '/img/icons/telegram_20.svg" alt="">Telegram</li>
            <li data-li="link"><img src="' . $template_uri . '/img/icons/viber_20.svg" alt="">Viber</li>
            <li data-li="link"><img src="' . $template_uri . '/img/icons/whatsapp_20.svg" alt="">WhatsApp</li>
        </ul>';



    ?>



    <div class="selector">
        <?php if ($isMyPost): ?>
            <div class="selector_first">
                <ul>
                    <li data-li="share">
                        <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/dark_share_20.svg"
                                alt="">Поделиться</div>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_right_20.svg" alt="">
                    </li>
                    <li><img src="<?php echo get_template_directory_uri(); ?>/img/icons/user-plus_20.svg" alt="">Подписаться
                    </li>
                    <li><img src="<?php echo get_template_directory_uri(); ?>/img/icons/Warning_outline_20.svg"
                            alt="">Пожаловаться</li>
                </ul>
            </div>
            <div class="selector_second">
                <div class="back_list">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_left_20.svg" alt="">Поделиться
                    <span class="back_list_empty"></span>
                </div>
                <?php echo $liList; ?>
            </div>
        <?php else: ?>
            <?php echo $liList; ?>
        <?php endif; ?>
    </div>

    <?php
}
?>