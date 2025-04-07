document.addEventListener("DOMContentLoaded", function () {
    // Получаем высоту body
    let heightBody = document.body.scrollHeight;

    // Если высота body меньше 1500, добавляем padding-top к .seamless_bg_grad
    // if (heightBody < 1500) {
    //     const seamlessBgGrad = document.querySelector(".seamless_bg_grad");
    //     if (seamlessBgGrad) {
    //         seamlessBgGrad.style.paddingTop = "80vh";
    //     }
    // }

    // Проверяем наличие админ-панели WordPress и добавляем/удаляем класс
    const adminPanel = document.getElementById("wpadminbar");
    const seamlessBgGrad = document.querySelector(".seamless_bg_grad");

    if (seamlessBgGrad) {
        if (adminPanel) {
            seamlessBgGrad.classList.add("wp_admin_active");
        } else {
            seamlessBgGrad.classList.remove("wp_admin_active");
        }
    }
});
