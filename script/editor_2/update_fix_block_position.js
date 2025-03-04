export function updateFixBlockPosition() {
    function updatePosition() {
        const areaPost = document.querySelector(".area_create_post");
        const fixBlock = document.querySelector(".create_post_header");

        if (areaPost && fixBlock) {
            const rect = areaPost.getBoundingClientRect();

            const rightPosition = window.innerWidth - rect.right- 17;

            fixBlock.style.right = `${rightPosition}px`;
        }
    }
    updatePosition()
// Вызываем при загрузке и на ресайзе
    window.addEventListener("load", updatePosition);
    window.addEventListener("resize", updatePosition);

}
