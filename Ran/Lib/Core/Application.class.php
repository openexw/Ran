<?php


final class Application {

    /**
     *
     */
    public static function run() {
        self::_init();
        self::_set_url(); // 设置路径
        spl_autoload_register(array(__CLASS__, 'autoload'));
        self::_create_dome();
        self::_app_run();
    }

    private static function autoload($className) {
        include APP_CONTROLLER_PATH.'/'.$className.'.class.php';
    }
    /***
     * 初始化框架
     * 1. 加载配置项
     * 2. 设置默认时区
     * 3. 开启Session
     */
    private static function _init() {
        // 1. 加载配置项
        // 加载系统配置
        C(include CONFIG_PATH.'/config.php');
        // 加载用户配置
        $userConfigPath = APP_CONFIG_PATH . '/config.php';

        $userConfig = <<<config
<?php
return array(
    //配置项=>值
);
config;
        // 判断用户配置文件是否存在，不存在写入初始值
        is_file($userConfigPath) || file_put_contents($userConfigPath, $userConfig);
        // 加载配置项
        C(include $userConfigPath);

        // 2. 设置默认时区
        date_default_timezone_set(C('DEFAULT_TIMEZONE'));

        // 3. 开启Session
        C('SESSION_AURO_START') && session_start();
    }

    /**
     * 设置路径
     */
    private static function _set_url() {
//        P($_SERVER);
        $path = 'http://'.$_SERVER['HTTP_HOST'] . '/' . $_SERVER['SCRIPT_NAME'];
        $path = str_replace('\\', '/', $path);
        define('__APP__', $path);
        define('__ROOT__', dirname(__APP__));
        define('__TPL__', __ROOT__.'/'.APP_NAME.'/Tpl');
        define('__PUBLIC__', __TPL__.'/public');
//        echo __APP__, __ROOT__;
    }

    /**
     * 创建默认控制器
     */
    private static function _create_dome() {
        $path = APP_CONTROLLER_PATH.'/IndexController.class.php';
        $str = <<<str
<?php

class IndexController extends Controller{
    public function index() {
        echo "index";
    }
}
str;
        is_file($path) || file_put_contents($path, $str);
    }

    /**
     * 实例化框架控制器
     */
    private static function _app_run() {
        $c = isset($_GET[C('VAR_CONTROLLER')]) ? $_GET['c'] : 'Index';
        $a = isset($_GET[C('VAR_ACTION')]) ? $_GET['a'] : 'Index';

        $c .='Controller';

        $obj = new $c();
        $obj->$a();

    }


}