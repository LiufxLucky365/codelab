<?php
/**
 * 验证各种过滤器: 挑选最有用的
 */


// 移除字符: 只保留数字、字母 和 !#$%&'*+-=?^_`{|}~@.[].
$test = "!#$%&'*+-=?^_`{|}~@是的.[]g\tsdfsfs\ngGGGG3是21【】";
$test = str_replace(array("\t", "\n"), "", $test);
//$test = 'lllll';
//$email = filter_var($test, FILTER_SANITIZE_EMAIL);
var_dump($test);die();

// 验证合法邮箱
$email = filter_var($test, FILTER_VALIDATE_EMAIL);
var_dump($email);


// 检查浮点 false | value
// 类似的还有  FILTER_VALIDATE_INT 
$floatTest = "102.23";
$floatTest = filter_var($floatTest, FILTER_VALIDATE_FLOAT);
var_dump($floatTest);


/**
 * 检查ip 标记位: 
 * FILTER_FLAG_IPV4 ipv4格式
 * FILTER_FLAG_IPV6 ipv6格式
 * FILTER_FLAG_NO_PRIV_RANGE  10.0.0.0/8, 172.16.0.0/12 and 192.168.0.0/16  不允许私有地址
 */
$ip = "127.0.0.1";
$ip = filter_var($ip, FILTER_VALIDATE_IP);
var_dump($ip);


/**
 * 真值过滤器，挺有意思
 * FILTER_VALIDATE_BOOLEAN    
 * Returns TRUE for "1", "true", "on" and "yes". Returns FALSE otherwise.
 *
 * 标记位  FILTER_NULL_ON_FAILURE    
 * If FILTER_NULL_ON_FAILURE is set, FALSE is returned only for "0", "false", "off", "no", and "", and NULL is returned for all non-boolean values.
 */
$bol = "yes";
$bol = filter_var($bol, FILTER_VALIDATE_BOOLEAN);
var_dump($bol);

/**
 * 自定义
 */
$target = 'test';
$myFilter = function ($value) {
    return $value;
};

$a = filter_var($target, FILTER_CALLBACK, array('options' => $myFilter));
var_dump($a);



