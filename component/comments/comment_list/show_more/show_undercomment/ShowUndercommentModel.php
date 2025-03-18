<?php 

class ShowUndercommentModel {
    const LOAD_MORE_COUNT = 10; // Количество комментариев для подгрузки
    public static function get_undercomments($post_id, $comment_id, $offset, $limit = self::LOAD_MORE_COUNT) {
        // Получаем подкомментарии для определенного комментария
        $undercomments = get_comments(array(
            'post_id' => $post_id,  // Используем переданный параметр $post_id
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => 'approve',
        ));
    
        // Группируем комментарии по parent_id
        $undercomment_tree = [];
        foreach ($undercomments as $undercomment) {
            // Группируем комментарии по parent_id
            $undercomment_tree[$undercomment->comment_parent][] = $undercomment;
        }
        $count = 0;  
        // Функция для рекурсивного обхода дерева с учетом лимита
        function paginate_comments($parent_id, &$tree, &$count, $limit) {
            $result = [];
           
            if (!isset($tree[$parent_id])) return $result;           
            foreach ($tree[$parent_id] as $comment) {                                
               
                $result[] = $comment;
                $count++;
    
                // Добавляем вложенные комментарии, если они есть
                if (!empty($tree[$comment->comment_ID])) {
                   
                    $result = array_merge($result, paginate_comments($comment->comment_ID, $tree, $count, $limit));
                }
            }
            return $result;
        }
     
        $undercommentsPaginate = paginate_comments($comment_id, $undercomment_tree, $count, self::LOAD_MORE_COUNT);
        $total_count = count($undercommentsPaginate);

       
        // Теперь мы можем обработать итоговые комментарии с учетом сдвига
        $final_comments = [];
        $count = 0;

        // Сначала пропускаем комментарии, если offset больше 0
        foreach ($undercommentsPaginate as $undercomment) {
            if ($count >= $offset && $count < ($offset + self::LOAD_MORE_COUNT)) {
                $final_comments[] = $undercomment;
             
            }
            $count++;
        }

        
        $undercommentsList = array();
        
        foreach ($final_comments as $undercomment) {           
            
            // Подгружаем текущий комментарий
            $undercommentsList[] = array(
                'id' => $undercomment->comment_ID,
                'author' => $undercomment->comment_author,
                'content' => $undercomment->comment_content,
                'date' => time_ago_short($undercomment->comment_date),
                'user_id' => $undercomment->user_id,
                'is_deleted' => $undercomment->comment_approved === 'trash' ? 'display: none;' : '',
                'parent' => $undercomment->comment_parent,
                'comment_class' => $undercomment->comment_approved === 'trash' ? 'user_comment comment-deleted' : 'user_comment',
                'total_count' => $total_count,
                'loadedCommentsCount' => $offset + self::LOAD_MORE_COUNT,
            );
        }

       return $undercommentsList;
    }
}