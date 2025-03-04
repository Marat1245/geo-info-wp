$(document).ready(function () {
    $('.comment_text').on('click', function () {
        const comment = $(this).closest('.comment_text');
        // const isCollapsed = comment.attr('data-collapsed') === 'true';

        // comment.attr('data-collapsed', isCollapsed ? 'false' : 'true');
        // $(this).closest('span').text(isCollapsed ? ' ' : 'еще');
        comment.attr('data-collapsed', 'false');
        $(this).children('span').css({ display: "none" })
        // if (isCollapsed) {
        //     comment.attr('data-collapsed', 'false');
        //     $(this).children('span').css({ display: "none" })
        // } else {
        //     comment.attr('data-collapsed', 'true');
        //     $(this).children('span').css({ display: "block" })
        // }
    });
});


$(document).ready(function () {
    // let $textarea = $('.textarea_comment');
    // let $charCount = $('.char_count');

    // Функция для обновления высоты и количества символов
    function updateTextarea() {
        let $textarea = $(this);  // Используем текущий textarea, на котором сработал input
        let $charCount = $textarea.closest('.comment_input_wrap').find('.char_count');

        const currentLength = $textarea.val().length;
        let textareaHeight = 32;
        let width = $textarea.width();
        let simbolInTextarea = width * 0.085;
        // Обновляем количество символов
        $charCount.text(currentLength);

        // Рассчитываем, сколько раз нужно увеличить высоту
        const linesToAdd = Math.floor(currentLength / simbolInTextarea);

        // Обновляем высоту
        $textarea.height(textareaHeight + linesToAdd * textareaHeight);


    }

    // Слушаем событие ввода в textarea
    $('.textarea_comment').on('input', updateTextarea);
});

$(document).ready(function () {
    $(".answer_comment").on("click", function () {
        let answerInput = $(this).closest('.user_comment').find('.comment_input_wrap_inner');
        if (answerInput.css("display") === "none") {
            answerInput.css("display", "block");  // Показываем
        } else {
            answerInput.css("display", "none");  // Скрываем
        }
    })
});
$(document).ready(function () {
    $(".user_comment_under_more").on("click", function () {
        $(this).closest('.user_comment').next('.user_comment_under').css("display", "flex");
        $(".user_comment_under_more").css("display", "none");
    })
});




$(document).ready(function () {
    function updatePlaceholder() {
        const $textarea = $('.comment_input_wrap  .textarea_comment');
        if ($(window).width() < 480) {
            $textarea.attr('placeholder', 'Комментировать');
        } else {
            $textarea.attr('placeholder', 'Написать комментарий');
        }
    }

    // Проверяем при загрузке страницы
    updatePlaceholder();

    // Слушаем изменение размера окна
    $(window).on('resize', updatePlaceholder);
});

