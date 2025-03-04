// Отобразить подсказку
export function showAlert(alertBox, message) {

    $(alertBox).text(message);
    $(alertBox).css({ display: "block", background: "var(--color_background_grey)" });
}

// Скрыть подсказку
export function hideAlert(alertBox) {

    $(alertBox).css({ display: "none", });
}
