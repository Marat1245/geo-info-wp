<?php
/* Template Name: Страница регистрации и входа */
get_header();


?>
<div class="seamless_bg">

    <div class="seamless_bg_grad login_page"></div>
    <div class="login">


        <div class="registration-form" data-sign="in">
            <h2>Регистрация</h2>

            <div class="social-login">

                <!-- <a class="social-btn vk"><img src="< get_template_directory_uri(); ?>/img/icons/vk.svg" alt="">

                </a>
                <a class="social-btn google"><img src="< get_template_directory_uri(); ?>/img/icons/google.svg"
                        alt=""></a>
                <a class="social-btn yandex"><img src="< get_template_directory_uri(); ?>/img/icons/yandex.svg"
                        alt=""></a> -->
            </div>

            <div class="form_separat">
                <div class="separat_line"></div>
                <p class="separat_text">Или введите</p>
                <div class="separat_line"></div>
            </div>

            <form method="post" action="">
                <div class="form_input_wrapper">
                    <input type="text" name="username" id="username" placeholder="Логин" required>
                    <div class="error_messeges"></div>
                </div>
                <div class="form_input_wrapper">
                    <input type="email" name="email" id="email" placeholder="Почта" required autocomplete="email">
                    <div class="error_messeges"></div>
                </div>


                <div class="password-container form_input_wrapper">
                    <input class="input_password" type="password" name="password" id="password" placeholder="Пароль"
                        required autocomplete="new-password">
                    <span class="toggle-password">
                        <img class="eye-password"
                            src="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            alt="Показать пароль"
                            data-default-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            data-active-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-act.svg">
                    </span>
                    <div class="error_messeges"></div>
                    <div id="password-strength"></div>
                </div>

                <div class="password-container form_input_wrapper">
                    <input class="input_password" type="password" name="password_confirm" id="password_confirm"
                        placeholder="Повторите пароль" required autocomplete="new-password">
                    <span class="toggle-password">
                        <img class="eye-password"
                            src="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            alt="Показать пароль"
                            data-default-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            data-active-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-act.svg">
                    </span>
                    <div class="error_messeges"></div>
                </div>

                <p class="policy card_caption_text">Оставляя свой email, вы соглашаетесь с <a
                        class="link_tag card_caption_text policy" href="/privacy-policy">Политикой
                        конфиденциальности</a>
                </p>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="error-message">
                        <?php echo $_SESSION['error_message']; ?>
                    </div>
                    <?php
                    $_SESSION['error_message'] = ''; // Удаляем сообщение после вывода
                    $_SESSION['error_message'] = ''; // Удаляем сообщение после вывода 
                    // ?>
                <?php endif; ?>

                <button type="submit" name="custom_registration" class="normal_text primary reg_btn"
                    disabled="true">Регистрация</button>

                <button type="button" class="normal_text flat">Уже есть аккаунт? Войти</button>
            </form>
        </div>



        <div class="login-form registration-form" data-sign="up">
            <h2>Войти</h2>

            <div class="social-login">

            </div>

            <div class="form_separat">
                <div class="separat_line"></div>
                <p class="separat_text">Или введите</p>
                <div class="separat_line"></div>
            </div>

            <form method="post" action="">
                <div class="form_input_wrapper">
                    <input type="text" name="username" id="username_login" placeholder="Логин или почта" required>
                    <div class="error_messeges"></div>
                </div>

                <div class="password-container form_input_wrapper">
                    <input class="input_password" type="password" name="password" id="password_login"
                        placeholder="Пароль" required autocomplete="current-password">
                    <span class="toggle-password">
                        <img class="eye-password"
                            src="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            alt="Показать пароль"
                            data-default-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-def.svg"
                            data-active-icon="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled-act.svg">
                    </span>
                </div>

                <?php if (!empty($_SESSION['error_message_login'])): ?>
                    <div class="error-message">
                        <?php echo $_SESSION['error_message_login']; ?>
                    </div>
                    <?php $_SESSION['error_message_login'] = ''; ?>
                <?php endif; ?>

                <button type="submit" name="custom_login" class="normal_text primary log_btn" disabled>Войти</button>

                <button type="button" class="normal_text flat">Зарегистрироваться</button>
                <a href="/reset-password">
                    <button type="button" class="normal_text flat">Востановить пароль</button>
                </a>
            </form>

        </div>




    </div>


</div>


<?php


get_footer();
