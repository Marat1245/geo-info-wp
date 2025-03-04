// Инициализация модуля для конкретной зоны

// Drop Area Handler Module
const DragDrop = {

    init: function (dropArea, onFileDrop) {
        this.dropArea = $(dropArea); // получили зону которую хотим назначить
        this.onFileDrop = onFileDrop; // 


        // Привязка событий ко всем зонам drop
        this.bindEvents();

        return this;
    },

    bindEvents: function () {
        // Привязываем события dragover, dragleave и drop ко всем зонам
        this.dropArea.each((_, area) => {
            const $area = $(area);
            $area.on("dragover", this.handleDragOver.bind(this, $area));
            $area.on("dragleave", this.handleDragLeave.bind(this, $area));
            $area.on("drop", this.handleDrop.bind(this, $area));
        });
    },

    handleDragOver: function ($area, event) {
        event.preventDefault();
        $area.addClass("dragover");
    },

    handleDragLeave: function ($area) {
        $area.removeClass("dragover");
    },

    handleDrop: function ($area, event) {
        event.preventDefault();
        $area.removeClass("dragover");
        let lastDroppedFile = null;

        const files = event.originalEvent.dataTransfer.files;

        if (files.length > 0 && typeof this.onFileDrop === "function") {
            this.onFileDrop(files, $area);  // Передаем файл и текущую зону
            lastDroppedFile = files[0];

        }

    },
    // Возвращаем последний файл
    getLastDroppedFile: function () {
        return this.lastDroppedFile;
    },
};




export default DragDrop;




