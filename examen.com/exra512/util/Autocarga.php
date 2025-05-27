<?php
// Yahya Limouni | 12

namespace exra512\util;

use Exception;

class Autocarga {
    public static function registerAutoload(): void {
        if( !spl_autoload_register(self::class . "::autoload") ) {
            throw new Exception("An issue has occured while loading the script");
        }
    }

    private static function autoload($class): void {
        $clean_class = str_replace('\\', '/', $class);
        $full_path = $_SERVER['DOCUMENT_ROOT'] . "/{$clean_class}.php";

        if( !file_exists($full_path) ){
            throw new Exception("Unfound file '$full_path'");
        }
        require_once($full_path);
    }
}

?>