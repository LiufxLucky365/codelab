<?php
	$testStr = "a一共六个字符";
	$strLen = mb_strlen($testStr);
	var_dump($strLen);

	$strLen = strlen($testStr);
	var_dump($strLen);
