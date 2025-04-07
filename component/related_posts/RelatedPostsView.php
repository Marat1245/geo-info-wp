<?php
class RelatedPostsView
{
    public static function render($posts)
    {

        if (empty($posts))
            return '';

        ob_start();?>
        <div class="add_article">
            <div class="add_article_caption">Читайте также</div>

            <div class="add_article_scroll">  
        <?php
        foreach ($posts as $post): ?>

            <!-- <div class="add_article_content swiper-slide">
                <a href="< esc_url($post['link']) ?>" class="link_company">
                    <span class="add_article_title">< esc_html($post['title']) ?></span>

                </a>
                < if (!empty($post['image'])): ?>
                    <img src="< esc_url($post['image']) ?>" alt="< esc_attr($post['title']) ?>" class="add_article_img">
                < else: ?>
                    <span class="add_article_subtitle">< esc_html($post['description']) ?></span>
                < endif; ?>
            </div> -->

            <div class="add_article_content ">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= esc_url($post['image']) ?>" alt="<?= esc_attr($post['title']) ?>" class="add_article_img">
                <?php else: ?>              
                    <img src="<?= get_template_directory_uri(); ?>/img/plug.jpg" alt="Заглушка" class="add_article_img">
                <?php endif; ?>

                <a href="<?= esc_url($post['link']) ?>" class="link_company">
                    <span class="add_article_title"><?= esc_html($post['title']) ?></span>

                </a>
            
            </div>
        <?php endforeach;?>
        </div>
    </div>
        <?php 
        return ob_get_clean();
    }
}