<?php
function time_ago_short($time) {
    $diff = time() - strtotime($time);

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