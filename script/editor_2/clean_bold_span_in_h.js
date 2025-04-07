
// Удаляем в Н2 и Н3 все span с классом .bold
export const cleanBoldSpans = (element) => {
    if (element.tagName !== "H2" && element.tagName !== "H3"){
        return
    }
    if (element.tagName === "H2" || element.tagName === "H3") {
        let boldSpans = element.querySelectorAll("span.bold");

        boldSpans.forEach(span => {
            let parent = span.parentNode;

            // Заменяем span его текстовым содержимым
            while (span.firstChild) {
                parent.insertBefore(span.firstChild, span);
            }

            // Удаляем пустой span
            parent.removeChild(span);
        });
    }
    if (element.tagName === "LI" || element.tagName === "P") {
        let li = element.querySelectorAll("li");
       
        // li.forEach(item => {
        //     let parent = item.parentNode;
        //
        //     // Заменяем span его текстовым содержимым
        //     while (item.firstChild) {
        //         parent.insertBefore(item.firstChild, item);
        //     }
        //
        //     // Удаляем пустой span
        //     parent.removeChild(item);
        // });
    }
};