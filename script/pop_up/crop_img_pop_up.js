let cropperInstance = null; // Хранение текущего экземпляра Cropper
let edit_crop = false;
let { imageContainer } = {};
export function enableCropping(id, idImg = "image",  options = {} ) {
    const image = document.getElementById(idImg);
    imageContainer = options;
    if (!image) return;
    if (idImg !== "image") {
        edit_crop = true;
    }
    // Уничтожаем предыдущий экземпляр Cropper, если он существует
    destroyCropper();

    // Определяем соотношение сторон
    const aspectRatios = {
        screen: 16 / 9,
        avatar: 1 / 1,
        default: null
    };

    // Создаем новый экземпляр Cropper
    cropperInstance = new Cropper(image, {
        aspectRatio: aspectRatios[id] ?? aspectRatios.default, // Выбираем подходящий аспект
        autoCropArea: 1,
        viewMode: 1,
        ready() {
            adjustCropBoxSize();

        },

    });



    const cropButtons = document.querySelectorAll(".btn_load_img, .btn_edit_img");

    cropButtons.forEach(cropButton => {

        cropButton.removeEventListener("click", handleCrop); // Удаляем старый обработчик
        cropButton.addEventListener("click", handleCrop);
    });

}

// Функция удаления текущего экземпляра Cropper
function destroyCropper() {
    if (cropperInstance) {
        cropperInstance.destroy();
        cropperInstance = null;
    }
}


// Функция корректировки размеров кроп-бокса
function adjustCropBoxSize() {
    if (!cropperInstance) return;

    const cropBoxData = cropperInstance.getCropBoxData();
    const containerData = cropperInstance.getContainerData();

    cropperInstance.setCropBoxData({
        left: 0,
        top: 0,
        width: containerData.width,
        height: containerData.height
    });
}

// Функция обработки обрезки изображения
function handleCrop() {
    if (!cropperInstance) return;

    const croppedCanvas = cropperInstance.getCroppedCanvas();
    if (!croppedCanvas) return;

    const croppedImageDataURL = croppedCanvas.toDataURL("image/png");

    // Создаем и вызываем событие imageCropped, передавая Base64-данные
    document.dispatchEvent(new CustomEvent("imageCropped", {  detail: {
            croppedImageDataURL,
            edit: edit_crop,
            imageContainer: imageContainer
        }  }));
}
