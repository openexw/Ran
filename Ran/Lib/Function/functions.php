<?php

/**
 * 打印函数
 * @param $arr
 */
function P($arr){
   echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

/**

 */
/**
 * 1. 加载配置项
 * C($sysConfig) C($userConfig) 先加载系统再加载用户
 * 2. 读取配置项
 * C('CODE_LEN')
 * 3. 临时动态改变配置项
 * C('CODE_LEN', 20)
 * 4. 获取所有配置项
 * C()
 * @param null $var 变量
 * @param null $value 值
 *
 */
function C($var=null, $value=null){
    static $config = array();

    // 加载配置项
    if (is_array($var)) {
        $config = array_merge($config, array_change_key_case($var, CASE_UPPER));
        return;
    }

    // 读取配置项
    if (is_string($var)) {
        $var = strtoupper($var);
        // 两个参数传递
        if (!is_null($value)) {
            $config[$var] = $value;
            return;
        }

        return isset($config[$var]) ? $config[$var] : null;
    }

    // 读取所有配置项
    if (is_null($var) && is_null($value)) {
        return $config;
    }
}