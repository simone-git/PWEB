<?php

namespace Library;


class Utils {
    public static function hasValue($var) {
        return isset($var) && $var !== '';
    }

    public static function reqInput() {  // Non funziona
        return json_decode(file_get_contents('php://input'), true);
    }
}