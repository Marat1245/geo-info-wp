<?php

class CountAllComments {
     // Функция для рекурсивного подсчета всех вложенных комментариев
    public static function countTotalCommentsInFirstFive($comments, $count_comments = null) {
        if ($count_comments) {
            $firstFive = array_slice($comments, 0, $count_comments); // Берем первые 5 родительских комментариев
        } else {
            $firstFive = $comments;
        }
        $totalCount = 0;
    
        
        foreach ($firstFive as $comment) {
            $totalCount += 1; // Учитываем сам родительский комментарий
        
            if (isset($comment['children']) && is_array($comment['children'])) {
                $totalCount += self::countAllComments($comment['children']); // Добавляем вложенные
            }
        }

        return $totalCount;
    }

    // Функция для рекурсивного подсчета всех вложенных комментариев
    public static function countAllComments($comments) {
        $count = count($comments);
        foreach ($comments as $comment) {
            if (isset($comment['children']) && is_array($comment['children'])) {
                $count += self::countAllComments($comment['children']);
            }
        }
        return $count;
    }

}

