export function showMoreBtn(){


    // Функция для проверки высоты и скрытия/показа элементов
    function checkHeights(blockSelector, wrapSelector, size) {
        const block = document.querySelector(blockSelector);
        const wrap = document.querySelector(wrapSelector);
        const nextElement = wrap?.nextElementSibling;

        if (block && wrap && nextElement) {
            const shouldHide = block.offsetHeight <= size;
            if (shouldHide) {
                nextElement.classList.add('hidden');
            }

        }
    }

    // Дебаунсинг функции для оптимизации события resize
    let resizeTimeout;
    function debounceResize() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            checkHeights('.profile_skills', '.profile_skills_wrap', 112);
            checkHeights('.profile_text', '.profile_text_wrap', 96);
        }, 200); // 200 мс — оптимальное время дебаунса
    }

    // Проверка высот при загрузке страницы
    checkHeights('.profile_skills', '.profile_skills_wrap', 112);
    checkHeights('.profile_text', '.profile_text_wrap', 96);

    // Проверка высот при изменении размера окна (с дебаунсом)
    window.addEventListener('resize', () => {
        debounceResize();
    });
}