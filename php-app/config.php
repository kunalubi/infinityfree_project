<?php
function base_url($path = '') {
    // LIVE SERVER
    if (strpos($_SERVER['HTTP_HOST'], 'kunal12.infinityfreeapp.com') !== false) {
        $base = 'https://kunal12.infinityfreeapp.com/';
    }
    // LOCALHOST
    else {
        $base = 'http://localhost/htdocs/';
    }
    return $base . ltrim($path, '/');
}
?>