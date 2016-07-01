<?php
	$password = "password";

	// 生成hash cost因子大于10
	$pwdHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
	echo $pwdHash;

	// 比较
	$equal = password_verify($password, $pwdHash);
	var_dump($equal);

	// 判断是否需要rehash, 根据当前的配置
	$bolRehash = password_needs_rehash($pwdHash, PASSWORD_DEFAULT, ['cost' => 15]);
	var_dump($bolRehash);