<?php
/**
 * Контроллер для обработки лайков комментариев
 * Обрабатывает AJAX-запросы для добавления/удаления лайков
 */
class CommentLikeController {   
    /**
     * Обработчик для авторизованных пользователей
     * Управляет добавлением и удалением лайков комментариев
     */
    public static function handle_like() {
        // Очищаем буфер вывода для предотвращения добавления лишних символов в JSON
        ob_clean();
        
        // Устанавливаем заголовок ответа как JSON с указанием кодировки
        header('Content-Type: application/json; charset=UTF-8');

        // Проверяем, передан ли ID комментария и является ли он числом
        if (!isset($_POST['comment_id']) || !is_numeric($_POST['comment_id'])) {
            // Если ID некорректный, возвращаем ошибку
            echo json_encode(array(
                'success' => false,
                'data' => array(
                    'message' => 'Invalid comment ID'
                )
            ));
            exit; // Прерываем выполнение скрипта
        }

        // Проверяем, авторизован ли пользователь
        if (!is_user_logged_in()) {
            // Если пользователь не авторизован, возвращаем ошибку
            echo json_encode(array(
                'success' => false,
                'data' => array(
                    'message' => 'Требуется авторизация'
                )
            ));
            exit;
        }

        // Получаем ID комментария из POST-запроса
        $comment_id = intval($_POST['comment_id']);
        // Получаем ID текущего пользователя
        $user_id = get_current_user_id();

        try {
            // Пытаемся переключить состояние лайка через модель
            $result = CommentLikeModel::toggle_like($comment_id, $user_id);
            // В случае успеха возвращаем положительный результат
            echo json_encode(array(
                'success' => true,
                'data' => $result
            ));
        } catch (Exception $e) {
            // В случае ошибки возвращаем сообщение об ошибке
            echo json_encode(array(
                'success' => false,
                'data' => array(
                    'message' => 'Произошла ошибка при обработке запроса'
                )
            ));
        }
        exit;
    }

    /**
     * Обработчик для неавторизованных пользователей
     * Возвращает сообщение о необходимости авторизации
     */
    public static function handle_unauthorized() {
        // Очищаем буфер вывода
        ob_clean();
        
        // Устанавливаем заголовок ответа
        header('Content-Type: application/json; charset=UTF-8');
        // Возвращаем сообщение о необходимости авторизации
        echo json_encode(array(
            'success' => false,
            'data' => array(
                'message' => 'Требуется авторизация'
            )
        ));
        exit;
    }
}

// Удаляем все существующие обработчики для наших действий
// Это предотвращает возможные конфликты с другими плагинами
remove_all_actions('wp_ajax_comment_controller');
remove_all_actions('wp_ajax_nopriv_comment_controller');

// Регистрируем обработчик для авторизованных пользователей
add_action('wp_ajax_comment_controller', array('CommentLikeController', 'handle_like'));
// Регистрируем обработчик для неавторизованных пользователей
add_action('wp_ajax_nopriv_comment_controller', array('CommentLikeController', 'handle_unauthorized'));