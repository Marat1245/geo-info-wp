document.addEventListener("DOMContentLoaded", function () {
    const resendEmailButton = document.getElementById('resend-email');
    if (!resendEmailButton) {
        return; // Если кнопка не найдена, выходим из функции
    }

    resendEmailButton.addEventListener('click', function () {
        this.disabled = true; // Деактивируем кнопку, чтобы предотвратить повторные клики
        // Получаем user_id и activation_key из URL
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('user_id');
        const activationKey = urlParams.get('key');

        console.log('userId:', userId);
        console.log('activationKey:', activationKey);

        if (userId && activationKey) {
            // Отправляем запрос на сервер для повторной отправки письма
            fetch(resend_email.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'resend_activation_email',
                    user_id: userId,
                    activation_key: activationKey,
                    nonce: resend_email.nonce,
                })
            })
                .then(response => response.json())  // Пытаемся распарсить ответ как JSON
                .then(data => {
                    if (data.success) {
                        const container = document.querySelector('.activation-container');
                        container.innerHTML = '<h2>Письмо отправлено повторно!</h2>';
                    } else {
                        alert('Не удалось отправить письмо. Попробуйте снова.');
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка. Попробуйте снова.');
                    this.disabled = false;
                });
        } else {
            alert('Некорректные параметры. Пожалуйста, попробуйте снова.');
            this.disabled = false;
        }
    });
});
