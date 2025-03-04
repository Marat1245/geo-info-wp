import { getCurrentBlock } from "./get_current_block.js";
import {checkLastParagraph} from "./create_paragraph.js";
import {captionViewModel} from "./caption.js";
import {imgBlock} from "./component/img_block.js";
export function insertImg(editor){

    document.addEventListener("imageCropped", (e) => {
        // Получаем переданные данные из e.detail
        let croppedImageDataURL = e.detail.croppedImageDataURL;
        let edit = e.detail.edit;
        let imageContainer = e.detail.imageContainer;


        insertCroppedImage(editor, croppedImageDataURL, imageContainer, edit);
        checkLastParagraph(editor);
        captionViewModel();

    });
}

export const insertCroppedImage = (editor, croppedImageDataURL, imageContainer = false, edit = "") => {

    if(imageContainer && edit === true){
        const image = Object.values(imageContainer)[0].querySelector("img");
        image.src = croppedImageDataURL;

    }else {
        let currentBlock = getCurrentBlock(editor);

        let imageContainer = imgBlock(croppedImageDataURL);
        // Вставляем после текущего блока или в конец редактора
        if (currentBlock) {
            currentBlock.replaceWith(imageContainer);
            console.log(imageContainer)

        } else {
            editor.appendChild(imageContainer);

        }
    }


};





