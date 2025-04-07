<?php
/* Template Name: Страница востановления пароля */
get_header();


$login = isset($_GET['login']) ? sanitize_user($_GET['login']) : '';
$key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
$user = $login ? get_user_by('login', $login) : false;
$show_reset_form = !$key;
?>
<div class="seamless_bg">

    <div class="seamless_bg_grad login_page"></div>
    <div class="login">

        <?php if ($show_reset_form): ?>
            <div class="reset_password registration-form">
                <h2>Востановить пароль</h2>
                <p>На вашу почту придет письмо с ссылкой для востановления</p>
                <form method="post" action="">
                    <div class="form_input_wrapper">
                        <input type="email" name="email" id="email" placeholder="Почта" required autocomplete="email">
                        <div class="error_messeges"></div>
                    </div>
                    <?php if (!empty($_SESSION['error_message_reset'])): ?>
                        <div class="error-message">
                            <?php echo $_SESSION['error_message_reset']; ?>
                        </div>
                        <?php $_SESSION['error_message_reset'] = ''; ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error_message_reset_success'])): ?>
                        <div class="success-message">
                            <?php echo $_SESSION['error_message_reset_success']; ?>
                        </div>
                        <?php $_SESSION['error_message_reset_success'] = ''; ?>
                    <?php endif; ?>
                    <div class="form_timer"><span>Повторно отправить письмо через </span><span>00:00</span> </div>
                    <button type="submit" name="custom_reset" class="normal_text primary">Отправить
                        письмо</button>

                    <a href="/log-in">
                        <button type="button" class="normal_text flat">Зарегистрироваться или войти</button>
                    </a>
                </form>
            </div>
        <?php elseif ($user && check_password_reset_key($key, $login)): ?>
            <div class="reset_password registration-form">
                <h2>Новый пароль</h2>
                <form method="post" action="">
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
                    <?php if (!empty($_SESSION['error_message_reset'])): ?>
                        <div class="error-message">
                            <?php echo $_SESSION['error_message_reset']; ?>
                        </div>
                        <?php $_SESSION['error_message_reset'] = ''; ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error_message_reset_success'])): ?>
                        <div class="success-message">
                            <?php echo $_SESSION['error_message_reset_success']; ?>
                        </div>
                        <?php $_SESSION['error_message_reset_success'] = ''; ?>
                    <?php endif; ?>
                    <button type="submit" name="custom_save_new_password" class="normal_text primary" disabled>Сохранить и
                        войти</button>

                    <a href="/log-in">
                        <button type="button" class="normal_text flat">Зарегистрироваться или войти</button>
                    </a>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();



