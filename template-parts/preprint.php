<?php
// Пример массива данных для постов
$posts = [
    [
        'title' => 'Как деградация строительной отрасли привела к массовым авариям на дамбах. Мнение проектировщика',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => '',
        'comments' => 22,
        'views' => 690,
        'img' => './img/predprint_01.png',
        'link' => './artical.php',
        'preprint' => true
    ],
    [
        'title' => 'Поверхности текучести и законы пластического течения',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => '',
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_02.png',
        'link' => '#',
        'preprint' => false
    ],
    [
        'title' => 'Росморпорт готов выделить
                                    более
                                    481 млн
                                    рублей на
                                    реконструкцию Южного мола в порту Махачкала',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_03.png',
        'link' => './artical.php',
        'preprint' => true
    ],
    [
        'title' => 'Еще один шаг к строительству
                                    линии
                                    метротрамвая в
                                    ЧелябинскеРосморпорт готов выделить
                                    более
                                    481 млн
                                    рублей на
                                    реконструкцию Южного мола в порту Махачкала',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_04.png',
        'link' => '#',
        'preprint' => false
    ],
    [
        'title' => 'Поверхности текучести и
                                    законы
                                    пластического
                                    течения',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_05.png',
        'link' => '#',
        'preprint' => false,
    ],
    [
        'title' => 'Как деградация строительной отрасли привела к массовым авариям на дамбах. Мнение проектировщика',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => '',
        'comments' => 22,
        'views' => 690,
        'img' => './img/predprint_01.png',
        'link' => '#',
        'preprint' => false,
    ],
    [
        'title' => 'Поверхности текучести и законы пластического течения',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => '',
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_02.png',
        'link' => '#',
        'preprint' => false,
    ],
    [
        'title' => 'Росморпорт готов выделить
                                    более
                                    481 млн
                                    рублей на
                                    реконструкцию Южного мола в порту Махачкала',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_03.png',
        'link' => './artical.php',
        'preprint' => true,
    ],
    [
        'title' => 'Еще один шаг к строительству
                                    линии
                                    метротрамвая в
                                    ЧелябинскеРосморпорт готов выделить
                                    более
                                    481 млн
                                    рублей на
                                    реконструкцию Южного мола в порту Махачкала',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_04.png',
        'link' => '#',
        'preprint' => false,
    ],
    [
        'title' => 'Поверхности текучести и
                                    законы
                                    пластического
                                    течения',
        'tags' => ['#Изыскания', '#Дискуссия профессионалов'],
        'date' => '27 сен',
        'likes' => 10,
        'comments' => 10,
        'views' => 20,
        'img' => './img/preprint_05.png',
        'link' => '#',
        'preprint' => false,
    ],
    
];

function showArticles ($limit = 5){

global $posts; // Делаем массив доступным внутри функции
$count = 0; // Счётчик постов
 foreach ($posts as $post) { 
        if ($limit > 0 && $count >= $limit) {
            break; // Останавливаем цикл, если достигли лимита
        }
        $count++;
        ?>
<div class="preprints paper">
    <div class="preprints_artical">
        <div class="preprints_artical_content">
            <div class="preprints_artical_top">
                <div class="preprints_title">
                    <a href="<?= $post['link']; ?>" class="link_grey_color"><?= $post['title']; ?></a>
                </div>
                <div class="preprints__tags">
                    <?php foreach ($post['tags'] as $tag): ?>
                    <a class="card_caption_text link_tag" href=""><?= $tag; ?></a>
                    <?php endforeach; ?>
                    <span class="card_caption_text">·</span>
                    <span class="card_caption_text"><?= $post['date']; ?></span>
                </div>
            </div>
            <div class="controle_bottom">
                <div class="sub_controller">
                    <button class="micro stroke_btn text_icon_btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/heart_20.svg" alt="">
                        <?php if ($post['likes'] > 0): ?>
                            <span class="card_caption_text"><?= $post['likes']; ?></span>
                        <?php endif; ?>
                    </button>
                    <button class="micro stroke_btn text_icon_btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">
                        <?php if ($post['comments'] > 0): ?>
                            <span class="card_caption_text"><?= $post['comments']; ?></span>
                        <?php endif; ?>
                        
                    </button>
                </div>
                <div class="view">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled.svg" alt="">
                    <?php if ($post['views'] > 0): ?>
                        <span class="view_count card_caption_text"><?= $post['views']; ?></span>
                    <?php endif; ?>
                   
                </div>
            </div>
        </div>
        <a class="preprints_artical_img_link" href="<?= $post['link']; ?>">
            <?php if ($post['preprint']): ?>
            <div class="preprint_bage">Препринт</div>
            <?php endif; ?>
            <img class="preprints_artical_img" src="<?= $post['img']; ?>" alt="">
        </a>
    </div>
</div>
<?php
    }
}
?>
