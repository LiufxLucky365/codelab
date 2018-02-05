<?php
	$testStr = "aÒ»¹²Áù¸ö×Ö·û";
	$strLen = mb_strlen($testStr, 'gbk');
	var_dump($strLen);

	$strLen = strlen($testStr);
	var_dump($strLen);

