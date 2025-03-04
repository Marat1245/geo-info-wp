export const imaskSetting = function () {
    const mobile_phone = document.getElementById('mobile_phone');
    const work_phone = document.getElementById('work_phone');
    const maskOptions = {
        mask: '+{7}(000)000-00-00'
    };

    // Проверка, если элемент существует, то применяем маску
    if (mobile_phone) {
        IMask(mobile_phone, maskOptions);
    }

    if (work_phone) {
        IMask(work_phone, maskOptions);
    }
};



