<?php
/**
 * filter_input用法与filter_var基本一致，主要区别是
 * filter_input目标为检查用户输入$_ENV $_SERVER $_POST $_GET $_COOKIE
 * 注意: 直接解析http报文，动态设置的$_**不能识别

 *  INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV
 */

// 检查报文中是否存在键test
filter_has_var(INPUT_GET, 'test') ? 'Yes' : 'No';

// 检查email是否为合法邮箱
$_GET['email'] = "12@126.com";	// 无效
$bol = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
var_dump($bol);


// 批量操作 filter_input_array | filter_var_array
/* data actually came from POST
$_POST = array(
    'product_id'    => 'libgd<script>',
    'component'     => '10',
    'versions'      => '2.0.33',
    'testscalar'    => array('2', '23', '10', '12'),
    'testarray'     => '2',
);
*/
$args = array(
    'product_id'   => FILTER_SANITIZE_ENCODED,
    'component'    => array('filter'    => FILTER_VALIDATE_INT,
                            'flags'     => FILTER_REQUIRE_ARRAY, 
                            'options'   => array('min_range' => 1, 'max_range' => 10)
                           ),
    'versions'     => FILTER_SANITIZE_ENCODED,
    'doesnotexist' => FILTER_VALIDATE_INT,
    'testscalar'   => array(
                            'filter' => FILTER_VALIDATE_INT,
                            'flags'  => FILTER_REQUIRE_SCALAR,
                           ),
    'testarray'    => array(
                            'filter' => FILTER_VALIDATE_INT,
                            'flags'  => FILTER_REQUIRE_ARRAY,
                           )

);

// $myinputs = filter_var_array($variable, $args);
$myinputs = filter_input_array(INPUT_POST, $args);
var_dump($myinputs);