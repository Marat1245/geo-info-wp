export function imgBlock(croppedImageDataURL) {
    // Создаем блок для вставки изображения и кнопки удаления
    const imageWrapper = document.createElement('div');
    imageWrapper.classList.add('image-container', 'tag_editor_wrap');
    imageWrapper.setAttribute("contentEditable", "false");

    const image = document.createElement('img');
    image.src = croppedImageDataURL;
    image.alt = 'Uploaded Image';
    image.classList.add('uploaded-image');

    const closeButton = document.createElement('div');
    closeButton.classList.add('close', 'delete_img');
    closeButton.innerHTML = '<img src="./img/icons/close_popup.svg" alt="Закрыть">';

    const cropImg = document.createElement('div');
    cropImg.classList.add('crop_img');
    cropImg.innerHTML = '<img src="./img/icons/crop_img.svg" alt="Редактировать изображение">';


    const widthImgWrap = document.createElement('div');
    widthImgWrap.classList.add('width_img_wrap');

    const widthImg = document.createElement('div');
    widthImg.classList.add('width_img', 'max_width_img');
    widthImg.innerHTML = '<img src="./img/icons/maximize.svg" alt="На всю ширину">';

    const minWidthImg = document.createElement('div');
    minWidthImg.classList.add('width_img', 'min_width_img');
    minWidthImg.innerHTML = '<img src="./img/icons/minimize.svg" alt="Исходный размер">';

    const captionWrapper = document.createElement('div');
    captionWrapper.setAttribute('contentEditable', 'true');
    captionWrapper.classList.add('input-caption', 'placeholder');
    captionWrapper.setAttribute('data-placeholder', 'Добавить описание');
    captionWrapper.setAttribute('spellCheck', 'false');
    captionWrapper.setAttribute('data-gramm', 'false');

    const caption = document.createElement('p');
    caption.innerHTML = '<br/>';

    captionWrapper.appendChild(caption);
    widthImgWrap.appendChild(widthImg);
    widthImgWrap.appendChild(minWidthImg);

    // Добавляем элементы в блок
    imageWrapper.appendChild(image);
    imageWrapper.appendChild(closeButton);
    imageWrapper.appendChild(cropImg);
    imageWrapper.appendChild(widthImgWrap);
    imageWrapper.appendChild(captionWrapper);

    // Возвращаем созданный блок
    return imageWrapper;
}
