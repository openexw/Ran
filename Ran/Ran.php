<?php
/**
 * 框架核心类
 */

final class Ran {
    public static function run() {
        self::_set_count();
        self::_create_dir();
        self::_import_file();
        Application::run();
    }

    /**
     * 设置常量
     */
    private static function _set_count(){
        $path = str_replace('\\', '/', __FILE__);
        // 框架根目录
        define("RAN_PATH", dirname($path));
        // 框架配置文件
        define("CONFIG_PATH", RAN_PATH."/Config");
        // Data目录
        define("DATA_PATH", RAN_PATH."/DATA");
        // lib目录
        define("LIB_PATH", RAN_PATH."/Lib");
        define("CORE_PATH", LIB_PATH."/Core");
        define("FUNCTION_PATH", LIB_PATH."/Function");

        //
        define('ROOT_PATH', dirname(RAN_PATH));
        // 应用目录
        define("APP_PATH", ROOT_PATH . "/" . APP_NAME);
//        echo  APP_PATH;

        define('APP_CONFIG_PATH', APP_PATH . "/Config");
        define('APP_CONTROLLER_PATH', APP_PATH . "/Controller");
        define('APP_TPL_PATH', APP_PATH . "/Tpl");
        define('APP_PUBLIC_PATH', APP_TPL_PATH . "/public");
    }

    /*
     * 创建模块目录结构
     */
    private static function _create_dir() {
        $arr = [
            APP_PATH,
            APP_CONFIG_PATH,
            APP_CONTROLLER_PATH,
            APP_TPL_PATH,
            APP_PUBLIC_PATH
        ];

        foreach ($arr as $v) {
            is_dir($v) || mkdir($v, 0777, true);
        }
    }

    /**
     * 载入核心文件
     */
    private static function _import_file() {
        $fileArr = [
            FUNCTION_PATH.'/functions.php',
            CORE_PATH.'/Controller.php',
            CORE_PATH.'/Application.class.php',
        ];

        foreach ($fileArr as $v) {
            require_once $v;
        }
    }
}

