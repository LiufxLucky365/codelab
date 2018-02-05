<?php
/**
 * 我的电子书整理工具
 * # 1. 归档download中的epub mobi pdf格式文件，到ebook目录
 * 2. 文件放到后缀名命名的目录里
 */

// 目标目录
$TARGET_PATH = "/Users/liufuxin/Downloads";

// 目标后缀
$TARGET_EXT = array('epub', 'mobi', 'pdf',);

$objTarget = new FilesystemIterator($TARGET_PATH);

foreach ($objTarget as $objFile) {
	if (!$objFile->isDir()) {
		$strExt = $objFile->getExtension();
		
		// 创建后缀目录
		$strExtPath = $TARGET_PATH . "/" . $strExt;
		$objExtPath = new SplFileInfo($strExtPath);
		if (!$objExtPath->isDir()) {
			mkdir($strExtPath);
		}

		// 移动文件
		rename($objFile->getRealPath(), $strExtPath . "/" . $objFile->getFilename());
	}
}