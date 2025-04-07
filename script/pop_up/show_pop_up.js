const Config = {
    containerPopUp: '.editor_pop_up',
    photoButtonSelector: '.edit_photo_btn *, .editor_img_btn *',
    imgBlockSelector: 'li[data-block="img"]',
    closeSelectors: '.pop_up_bg, .pop_up_close *, .btn_load_img *, .btn_load_img',
}

function ShowPopUp(config = Config) {
    document.addEventListener("click", function (event) {
        const containerPopUp = document.querySelector(config.containerPopUp)

        if ((event.target.matches(config.photoButtonSelector) || event.target.closest(config.imgBlockSelector)) && containerPopUp) {
            containerPopUp.classList.add('show_pop_up');
        } else if ((event.target.matches(config.closeSelectors)) && containerPopUp) {

            containerPopUp.classList.remove('show_pop_up');
        }
    });
}

export default ShowPopUp;
