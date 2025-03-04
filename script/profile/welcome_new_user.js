export function welcomeNewUser() {
    const profileColumWrap = document.querySelector('.profile_colum_wrap_my .profile_colum');


    // Проверяем, если нужный элемент существует
    if (!profileColumWrap) return;

    // Вставка контента
    const welcomeText = `
        <div class="profile_block profile_welcome">
            <img src="./img/logo_main.svg" alt="">
            <p class="profile_text">
                Мы рады, что Вы стали зарегистрированным пользователем. ГеоИнфо – это не просто журнал или информационное агентство. Это <span class="text_orange">экосистема,</span> которая позволит вам получать нужную и <span class="text_orange">проверенную информацию, общаться с коллегами, искать необходимые для работы связи</span> среди других пользователей, а также <span class="text_orange">показывать свои компетенции и опыт.</span> Ваш личный кабинет – Ваша страница достижений. А что из этого показать другим – решаете только Вы.
            </p>
            <button class="stroke_btn small_text"><span>Закрыть</span></button>
        </div>
    `;

    // Вставляем контент в начало блока
    profileColumWrap.insertAdjacentHTML('afterbegin', welcomeText);

    const welcomeButton = document.querySelector('.profile_welcome button');
    // Обработчик для кнопки "Закрыть"
    welcomeButton.addEventListener('click', () => {
        const profileWelcome = welcomeButton.closest('.profile_welcome');
        if (profileWelcome) {
            profileWelcome.style.display = 'none';
        }
    });
}
