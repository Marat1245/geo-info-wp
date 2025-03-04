const Config = {
    containerPopUp: '.edit_img_pop_up',
    photoButtonSelector: '.crop_img *',
    closeSelectors: '.pop_up_bg, .pop_up_close *, .btn_edit_img *, .btn_edit_back, .btn_edit_back *',
}

export function ShowEditImg() {
    document.addEventListener("click", function(event) {
        const containerPopUp = document.querySelector(Config.containerPopUp)

        if (event.target.matches(Config.photoButtonSelector)) {
            containerPopUp.classList.add('show_pop_up');
        } else if (event.target.matches(Config.closeSelectors)) {

            containerPopUp.classList.remove('show_pop_up');
        }
    });
}
