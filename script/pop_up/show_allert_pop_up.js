
// Отобразить подсказку
export function showAlert(alertBox, message) {
    $(alertBox).text(message).fadeIn();
}

// Скрыть подсказку
export function hideAlert(alertBox) {
    $(alertBox).fadeOut();
}
