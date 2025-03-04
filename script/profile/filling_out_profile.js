export function fillingOutProfile() {

        const profileColumRight = document.querySelector('.profile_colum_wrap_my .profile_colum_right');
        if (!profileColumRight) return;

        // Вставка информации о профиле
        const profilePercent = `
        <div class="profile_right_block">
            <div class="profile_persent_wrap">
                <div class="profile_right_title">Заполните профиль</div>
                <div class="profile_persent_block">
                    <span>2%</span>
                    <div class="profile_persent_load"></div>
                </div>
                <ul class="profile_persent_list">
                    <li><a href="">ФИО <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                    <li><a href="">Должность <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                    <li><a href="">Общие сведения <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                    <li><a href="">Диплом и награды <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                    <li><a href="">Опыт работы <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                    <li><a href="">Доп образование <img src="./img/icons/Edit_20.svg" alt=""></a></li>
                </ul>
                <button class="stroke_btn micro"><span>Скрыть</span></button>
            </div>
        </div>
    `;
        profileColumRight.insertAdjacentHTML('afterbegin', profilePercent);

        // Обработчик для кнопки "Скрыть"
        const percentButton = document.querySelector('.profile_persent_wrap button');
        if (percentButton) {
            percentButton.addEventListener('click', () => {
                const profileRightBlock = percentButton.closest('.profile_right_block');
                if (profileRightBlock) {
                    profileRightBlock.style.display = 'none';
                }
            });
        }

}