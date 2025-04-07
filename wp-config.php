<?php
// Включаем отладочное логирование
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);


// Включаем Gzip-сжатие через PHP
if (extension_loaded('zlib') && !ob_start("ob_gzhandler")) {
    ob_start();
}