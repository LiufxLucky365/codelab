<?php
	$testCh = "测试字符串";
	$testEn = "test string";

	echo strlen($testCh), PHP_EOL;	// 15
	echo strlen($testEn), PHP_EOL;	// 11

	echo mb_strlen($testCh), PHP_EOL;	// 5