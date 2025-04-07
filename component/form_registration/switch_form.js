document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector('.registration-form[data-sign="up"]');
    if (!loginForm) {
        return;
    }
    const registerForm = document.querySelector('.registration-form[data-sign="in"]');
    if (!registerForm) {
        return;
    }
    // Кнопка "Зарегистрироваться" в форме входа
    const switchToRegisterBtn = loginForm.querySelector('button.flat');
    // Кнопка "Уже есть аккаунт? Войти" в форме регистрации
    const switchToLoginBtn = registerForm.querySelector('button.flat');

    // Проверяем состояние формы, если оно есть в localStorage
    const activeForm = localStorage.getItem('activeForm');

    if (activeForm === 'register') {
        // Если форма регистрации была активна, показываем её
        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';
    } else {
        // Если форма входа была активна, показываем её
        loginForm.style.display = 'flex';
        registerForm.style.display = 'none';
    }

    switchToRegisterBtn.addEventListener('click', function () {
        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';
        localStorage.setItem('activeForm', 'register'); // Сохраняем состояние
    });

    switchToLoginBtn.addEventListener('click', function () {
        registerForm.style.display = 'none';
        loginForm.style.display = 'flex';
        localStorage.setItem('activeForm', 'login'); // Сохраняем состояние
    });
});
