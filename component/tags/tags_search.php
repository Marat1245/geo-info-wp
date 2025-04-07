<?php
$previousPage = $_SERVER['HTTP_REFERER'] ?? home_url('/');
$postType = get_post_type();
$namePage = "";
if ($postType == 'post') {
    $namePage = 'Предпринты';
} else if ($postType == 'post_users') {
    $namePage = 'Стена';
} else if ($postType == 'news') {
    $namePage = 'Новости';
}

?>

<div class="title_for_section__wrap ">
    <div class="title_for_section">
        <div class="title_for_section__left">
            <a href="<?= htmlspecialchars($previousPage); ?>"><button class="stroke_btn small_icon"
                    id="search_back"><img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_left_20.svg"
                        alt=""></button></a>
            <h1><?= $namePage ?></h1>
        </div>

        <div class="search_wrap">
            <button class="stroke_btn small_text " id="delet_tag"><img src="./img/icons/delete_20.svg" alt=""></button>

            <div class="tags_input_wrap">
                <input name="tags" type="text" placeholder="Теги" readonly>
                <div>
                    <button class="flat small_icon"><img
                            src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg"
                            alt=""></button>
                </div>
                <div class="" id="tags_list">
                    <ul>

                    </ul>
                </div>

            </div>

            <button class="flat small_icon" id="search_enabled"><img
                    src="<?php echo get_template_directory_uri(); ?>/img/icons/search_28.svg" alt=""></button>
        </div>
        <div class="search_input_wrap">

            <input name="search" type="text" placeholder="Поиск">
            <button class="full_dark small_icon" id="search_disabled"><img
                    src="<?php echo get_template_directory_uri(); ?>/img/icons/search_white_20.svg" alt=""></button>
            <button class="stroke_btn small_icon" id="search_back"><img
                    src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_up_20.svg" alt=""></button>

        </div>
    </div>

</div>