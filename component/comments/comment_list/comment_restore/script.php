<?php 

    
    require get_template_directory() . '/component/comments/comment_list/comment_restore/CommentRestoreView.php';
    require get_template_directory() . '/component/comments/comment_list/comment_restore/CommentRestoreController.php';
    require get_template_directory() . '/component/comments/comment_list/comment_restore/CommentRestoreModel.php';

   
    function enqueue_comment_restore_script() {
        wp_enqueue_script('comment_restore', get_template_directory_uri() . '/component/comments/comment_list/comment_restore/comment_restore.js', array('jquery'), '1.0', true);
        
        // Добавляем данные для AJAX
        wp_localize_script('comment_restore', 'comment_actions', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('comment_actions_nonce')
        ));
    }
    add_action('wp_enqueue_scripts', 'enqueue_comment_restore_script');


