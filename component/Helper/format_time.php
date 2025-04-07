<?php
function time_ago_short($time)
{

    // Проверяем, что $time содержит полную дату и время
    if (strlen($time) <= 10) {
        $time .= ' 00:00:00'; // Добавляем время по умолчанию, если его нет
    }

    // Получаем текущий часовой пояс WordPress
    $timezone = wp_timezone();

    // Конвертируем время в объект DateTime
    try {
        $date = new DateTime($time, $timezone);
    } catch (Exception $e) {
        // Если возникла ошибка (неверный формат даты)
        return date('j M, H:i', strtotime($time)); // Альтернативное преобразование
    }

    $now = new DateTime('now', $timezone);

    // Вычисляем разницу в секундах
    $diff = $now->getTimestamp() - $date->getTimestamp();

    // Если дата в будущем (на всякий случай)
    if ($diff < 0) {
        $diff = abs($diff);
    }

    if ($diff < 60) {
        return 'только что';
    } elseif ($diff < 3600) { // до 1 часа
        return floor($diff / 60) . 'м';
    } elseif ($diff < 86400) { // до 24 часов
        return floor($diff / 3600) . 'ч';
    } else { // больше 1 дня
        // Форматируем дату как "19 дек, 22:12"
        $day = $date->format('j'); // День без ведущего нуля
        $month = $date->format('M'); // Краткое название месяца

        // Русские сокращения месяцев
        $months_ru = [
            'Jan' => 'янв',
            'Feb' => 'фев',
            'Mar' => 'мар',
            'Apr' => 'апр',
            'May' => 'мая',
            'Jun' => 'июн',
            'Jul' => 'июл',
            'Aug' => 'авг',
            'Sep' => 'сен',
            'Oct' => 'окт',
            'Nov' => 'ноя',
            'Dec' => 'дек'
        ];

        $month_ru = $months_ru[$month] ?? $month;
        $time = $date->format('H:i'); // Время в 24-часовом формате

        return $day . ' ' . $month_ru . ', ' . $time;
    }
}