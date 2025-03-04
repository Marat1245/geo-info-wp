export const selectorDate = function () {
    const currentYear = new Date().getFullYear();
    const minYear = 1900;

    // Получаем все элементы с классами work_start и work_end
    const workStartSelects = document.getElementsByClassName("work_start");
    const workEndSelects = document.getElementsByClassName("work_end");

    // Проходим по всем элементам с классом work_end и добавляем опцию "По настоящее время"

    Array.from(workEndSelects).forEach(select => {
        const currentTimeOption = new Option("По настоящее время", "current");
        select.add(currentTimeOption);
    });

    // Добавляем опции для годов от текущего года до минимального
    for (let year = currentYear; year >= minYear; year--) {



        // Добавляем опции в каждый элемент с классом work_start
        Array.from(workStartSelects).forEach(select => {
            const optionStart = new Option(year, year);

            select.add(optionStart);
        });

        // Добавляем опции в каждый элемент с классом work_end
        Array.from(workEndSelects).forEach(select => {

            const optionEnd = new Option(year, year);
            select.add(optionEnd);
        });
    }
};
