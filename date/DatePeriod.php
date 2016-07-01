<?php
/**
 * 时间段
 */
$start = new DateTime("2015-11-16 00:00:00");
$end = new DateTime("2015-11-16 05:00:00");
$interval = new DateInterval("PT1H");

// 指定轮询次数
$period = new DatePeriod($start, $interval, 3);

// 指定结束时间
$period = new DatePeriod($start, $interval, $end);

// 指定不包含起始
// $period = new DatePeriod($start, $interval, $end, DatePeriod::EXCLUDE_START_DATE);

foreach ($period as $datetime) {
	echo $datetime->format("Y-m-d H:i:s") , PHP_EOL;
}