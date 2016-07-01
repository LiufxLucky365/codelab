<?php
/**
 * 发现数据库中出现大量机器注册用户，特征为 xyz123，脚本的目的为:
 * 1. 找出作弊用户一个有多少个
 * 2. 他们都是哪些用户邀请的
 */

$timeStart = microtime();

try {
	$objPDO = new PDO("mysql:host=127.0.0.1;dbname=itest_offline;port=3306;charset=utf8;", 'root', '');
} catch (PDOException $e) {
	echo "pdo connect fail";
	exit;
}

$objStmt = $objPDO->query("select uid, uname, iuid, tel, email from user");

// fetchall内存不足
// $result = $objStmt->fetchAll();
// foreach ($result as $row) {
// 	print_r($result);
// }

$strPattern = "/^([a-zA-Z\s]+)(\d+)$/i";

$arrUnameGroup = array();
$arrIuidGroup = array();
$arrUsersTel = array();
$arrUsersEmail = array();

while (($row = $objStmt->fetch()) !== false) {
	$strUname = $row['uname'];

	@$arrUsersTel[$row['uid']] = $row['tel'];
	@$arrUsersEmail[$row['uid']] = $row['email'];

	$intMatch = preg_match($strPattern, $strUname, $match);
	if ($intMatch > 0) {
		$strPre = $match[1];
		$intIuid = $row['iuid'];

		@$arrIuidGroup[$row['iuid']][$strPre]++;
	}
}

unset($arrIuidGroup[0]);

$arrIuidGroup = array_map(function ($item) {
	$arrRet = array();
	foreach ($item as $pre => $i) {
		if ($i > 1) {
			$arrRet[$pre] = $i;
		}
	}

	if (count($arrRet) > 0) {
		return $arrRet;
	}
}, $arrIuidGroup);

foreach ($arrIuidGroup as $key => $value) {
	if (count($value) == 0) {
		unset($arrIuidGroup[$key]);
	}
}

// 整理用户信息
$arrUsers = array();

foreach ($arrIuidGroup as $uid => $arrCheat) {
	$arrUsers[$uid]['cheat_count'] = array_sum($arrCheat);
	$arrUsers[$uid]['cheat_detail'] = $arrCheat;
	@$arrUsers[$uid]['tel'] = $arrUsersTel[$uid];
	@$arrUsers[$uid]['email'] = $arrUsersEmail[$uid];
}

// 输出csv
foreach ($arrUsers as $uid => $detail) {
	echo $uid . "," . $detail['email'] . "," . $detail['tel'] . "," . $detail['cheat_count'] . "," . json_encode($detail['cheat_detail']) . "\n";
}

// asort($arrUnameGroup);
// print_r($arrUnameGroup);

// asort($arrIuidGroup);
// print_r($arrUsers);

// echo array_sum($arrUnameGroup) . "\n";

$intCost = microtime() - $timeStart;
// echo "\n$intCost";







