export function scaleImg(editor) {
    editor.addEventListener("click", function (e) {
        const imgWrap = e.target.closest('.image-container');
        const btn = e.target.closest('.width_img'); // Улучшенная проверка

        if (!imgWrap || !btn) return;

        imgWrap.classList.toggle('min_width'); // Упрощенный toggle


    });
}
