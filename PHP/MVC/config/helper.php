<?php
require_once __DIR__ . '/config.php';

function asset($path) {
    return BASE_URL . '/public/' . ltrim($path, '/');
}
?>