<?php
function time_ago_short($time) {
    // Получаем текущий часовой пояс WordPress
    $timezone = wp_timezone();
    
    // Конвертируем время в объект DateTime
    $date = new DateTime($time, $timezone);
    $now = new DateTime('now', $timezone);
    
    // Вычисляем разницу
    $diff = $now->getTimestamp() - $date->getTimestamp();
    
    if ($diff < 0) {
        $diff = abs($diff);
    }
    
    if ($diff < 60) {
        return 'только что';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . 'м';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . 'ч';
    } else {
        return floor($diff / 86400) . 'д';
    }
}