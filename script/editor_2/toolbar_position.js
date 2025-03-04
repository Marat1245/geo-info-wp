export class ToolbarViewModel {
    constructor() {
        this.toolbar = document.querySelector("#toolbar");
        this.init();
    }

    init() {
        document.addEventListener("click", this.handleTextSelection.bind(this));
    }

    handleTextSelection() {
        const selection = window.getSelection();

        if (selection.toString().trim()) {
            const range = selection.getRangeAt(0);
            const rect = range.getBoundingClientRect();
            this.showToolbar(rect);
        } else {
            this.hideToolbar();
        }
    }

    showToolbar(rect) {
        const screenMiddle = window.innerWidth / 2;
        const toolbarWidth = this.toolbar.offsetWidth || 100; // Задаем примерную ширину, если она еще не вычислена
        let leftPosition;
        if (rect.left + rect.width / 2 < screenMiddle) {
            // Текст в левой части экрана - показываем слева
            leftPosition = rect.left + window.scrollX - 20;
        } else {
            // Текст в правой части экрана - показываем справа
            leftPosition = rect.right + window.scrollX - toolbarWidth + 20;
        }

        this.toolbar.classList.add("active_toolbar");
        this.toolbar.style.top = `${rect.top - 80 + window.scrollY}px`;
        this.toolbar.style.left = `${Math.max(10, leftPosition)}px`; // Не даем выйти за границы слева
    }

    hideToolbar() {
        this.toolbar.classList.remove("active_toolbar");
    }
}


