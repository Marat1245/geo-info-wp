<?php
/**
 * Модель для управления лайками комментариев
 */
class CommentLikeModel {
    /**
     * Переключает состояние лайка для комментария
     * 
     * @param int $comment_id ID комментария
     * @param int $user_id ID пользователя
     * @return array Массив с количеством лайков и статусом лайка
     */
    
    public static function toggle_like($comment_id, $user_id) {
        // Получаем текущее количество лайков комментария
        // Если лайков нет, устанавливаем значение 0
        $likes = get_comment_meta($comment_id, 'comment_likes', true) ?: 0;

        // Получаем массив ID пользователей, которые лайкнули комментарий
        // Если массива нет, создаем пустой массив
        $liked_users = get_comment_meta($comment_id, 'liked_users', true) ?: array();

        // Проверяем, лайкнул ли уже этот пользователь комментарий
        if (in_array($user_id, $liked_users)) {
            // Если да - убираем лайк
            // Используем max() чтобы количество лайков не стало отрицательным
            $likes = max(0, intval($likes) - 1);
            // Удаляем ID пользователя из массива лайкнувших
            $liked_users = array_diff($liked_users, array($user_id));
            $is_liked = false;
        } else {
            // Если нет - добавляем лайк
            // Увеличиваем счетчик лайков
            $likes = intval($likes) + 1;
            // Добавляем ID пользователя в массив лайкнувших
            $liked_users[] = $user_id;
            $is_liked = true;
        }

        // Сохраняем обновленное количество лайков в метаданных комментария
        update_comment_meta($comment_id, 'comment_likes', $likes);
        // Сохраняем обновленный массив лайкнувших пользователей
        // array_values() используется для переиндексации массива
        update_comment_meta($comment_id, 'liked_users', array_values($liked_users));

        // Возвращаем результат операции
        return array(
            'likes' => $likes,      // Текущее количество лайков
            'is_liked' => $is_liked // Текущий статус лайка для пользователя
        );
    }
} 