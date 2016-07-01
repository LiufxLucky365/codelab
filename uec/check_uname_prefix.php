<?php
/**
 * 检查用户名前缀
 * 1. 字母加数字的组合
 */

$arrTest = array(
	'a', 'a1', '1', '', ' ', ' a1', '  1', 'a 1',
);

function match($strUname) {
	$strPattern = "/^([a-zA-Z\s]+)(\d+)$/i";

	$intMatch = preg_match($strPattern, $strUname, $match);
	if ($intMatch > 0) {
		echo $strUname . " -|" . $match[1] . "|\n";
	}
}

foreach ($arrTest as $test) {
	match($test);
}