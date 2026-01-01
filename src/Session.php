<?php

date_default_timezone_set('Europe/Rome');

session_set_cookie_params([
    'lifetime' => 7200,
    'path' => '/',
    'domain' => '', // opzionale
    'secure' => false, // true se usi HTTPS
    'httponly' => true
]);

session_start();
