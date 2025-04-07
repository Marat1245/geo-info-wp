document.addEventListener("DOMContentLoaded", function () {

    // 
    // Функция для повторного прикрепления событий после загрузки формы
    // 
    function attachFormListeners() {
        const form = document.querySelector("form");
        const passwordInput = document.querySelector("#password");
        if (!passwordInput) {
            return;
        }
        const confirmPasswordInput = document.querySelector("#password_confirm");
        const submitBtn = document.querySelector(".reg_btn");
        const usernameInput = document.querySelector("#username");
        const emailInput = document.querySelector("#email");

        const submitBtnLogin = document.querySelector(".log_btn");
        const usernameLogin = document.querySelector("#username_login");
        const passwordLogin = document.querySelector("#password_login");

        const new_password = document.querySelector("[name='custom_save_new_password']");
        // 
        // Добавляем обработчики для всех полей
        // 
        if (usernameInput) {
            usernameInput.addEventListener("input", validateForm);
        }
        if (emailInput) {
            emailInput.addEventListener("input", validateForm);
        }
        if (passwordInput) {
            passwordInput.addEventListener("input", validateForm);
        }
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener("input", validateForm);
        }
        if (usernameLogin) {
            usernameLogin.addEventListener("input", validateForm);
        }
        if (passwordLogin) {
            passwordLogin.addEventListener("input", validateForm);
        }

        function validateForm() {

            if (usernameInput) {
                const isValid = usernameInput.value.trim() !== "" &&
                    emailInput.value.trim() !== "" &&
                    passwordInput.value.trim() !== "" &&
                    confirmPasswordInput.value.trim() !== "" &&
                    passwordInput.value === confirmPasswordInput.value;
                submitBtn.disabled = !isValid;
            }

            if (usernameLogin) {
                const isLoginValid = usernameLogin.value.trim() !== "" &&
                    passwordLogin.value.trim() !== "";
                submitBtnLogin.disabled = !isLoginValid;
            }

            if (new_password) {
                const isLoginValid = passwordInput.value.trim() !== "" &&
                    confirmPasswordInput.value.trim() !== "";
                new_password.disabled = !isLoginValid;
            }
        }


        // 
        // Функция для смены состояния видимости пароля
        // 
        function togglePasswordVisibility() {
            // Получаем все инпуты с классом 'input_password'
            const passwordInputs = document.querySelectorAll('.input_password');
            // Получаем все иконки с классом 'eye-password'
            const eyeIcons = document.querySelectorAll('.eye-password');

            // Для каждого инпута и иконки
            passwordInputs.forEach((input, index) => {
                const icon = eyeIcons[index];  // Соответствующая иконка для текущего инпута
                if (input.type === 'password') {
                    input.type = 'text';  // Меняем тип поля на текст
                    icon.src = icon.dataset.activeIcon;  // Меняем иконку на активную
                } else {
                    input.type = 'password';  // Меняем тип поля на пароль
                    icon.src = icon.dataset.defaultIcon;  // Меняем иконку на дефолтную
                }
            });
        }


        // 
        // Добавляем обработчик клика на все элементы с классом '.toggle-password'
        // 

        document.querySelectorAll('.toggle-password').forEach(function (togglePassword) {
            togglePassword.addEventListener('click', togglePasswordVisibility);
        });

        //
        // Функция для проверки пароля на сложность
        //
        const strengthText = document.querySelector("#password-strength");

        passwordInput.addEventListener("input", function () {
            showPasswordStrength(passwordInput.value);
            validateForm();
        });

        function showPasswordStrength(password) {
            const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            const mediumRegex = /^(?=.*[a-z])(?=.*\d).{6,}$/;

            if (password.length === 0) {
                strengthText.textContent = '';
            } else if (strongRegex.test(password)) {
                strengthText.textContent = 'Пароль надёжный';
                strengthText.style.color = 'green';
            } else if (mediumRegex.test(password)) {
                strengthText.textContent = 'Пароль средний';
                strengthText.style.color = 'orange';
            } else {
                strengthText.textContent = 'Слабый пароль';
                strengthText.style.color = 'red';
            }
        }



    }
    attachFormListeners();
});


document.addEventListener("DOMContentLoaded", function () {
    const usernameInput = document.querySelector("#username");
    if (!usernameInput) {
        return;
    }
    const emailInput = document.querySelector("#email");
    const passwordInput = document.querySelectorAll(".input_password");


    // 
    // Функция для проверки ввода
    //     
    function restrictInputToEnglish(event) {
        // Регулярное выражение: английские буквы, цифры, @, _, = и другие спецсимволы
        const regex = /^[a-zA-Z0-9@._-]*$/;

        const inputField = event.target;
        const errorMessageDiv = inputField.closest('.form_input_wrapper').querySelector('.error_messeges');
        if (!errorMessageDiv) {
            return; // Если элемент не найден, выходим из функции
        }

        // Если введён текст не соответствует регулярному выражению
        if (!regex.test(inputField.value)) {
            inputField.value = inputField.value.replace(/[^a-zA-Z0-9@_=-]/g, ''); // Убираем все недопустимые символы
            showErrorMessage(errorMessageDiv, "Только английские буквы, цифры!");
        } else {
            clearErrorMessage(errorMessageDiv);
        }
    }


    // 
    // Функция для отображения ошибки
    // 
    function showErrorMessage(errorMessageDiv, message) {
        errorMessageDiv.textContent = message;
        errorMessageDiv.style.color = 'red';
    }


    // 
    // Функция для очистки ошибки
    // 
    function clearErrorMessage(errorMessageDiv) {
        errorMessageDiv.textContent = ''; // Очищаем сообщение об ошибке
    }


    // 
    // Добавляем обработчики для проверки ввода
    // 
    usernameInput.addEventListener("input", restrictInputToEnglish);


    passwordInput.forEach(function (input) {
        input.addEventListener("input", restrictInputToEnglish);
    });
});
