<?php
	/**
	 * 求给定时间之前最近一个周日
	 */
	$datetime = new DateTime("2016-03-02");
	$strDateEnd = $datetime->modify((0 - $datetime->format("w")) . " day")->format("Y-m-d");
	echo $strDateEnd;
	die();

	// 新建时间 + 时区
	// $timezone = new DateTimeZone('Asia/ShangHai');
	// $datetime = new DateTime("2015-11-12 21:21:12", $timezone);

	// 新建时间 + 设置时区
	$datetime = new DateTime("2015-11-12 21:21:12");
	$datetime->setTimezone(new DateTimeZone('America/New_York'));

	// 输出时间
	echo $datetime->format("Y-m-d");

	// 时间间隔类
	// P开头, 日期和时间T隔开 Y M D W H M S
	$interval = new DateInterval('P2D');
	$datetime->add($interval);
	// $datetime->sub($interval);

	echo $datetime->format("Y-m-d");