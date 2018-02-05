<?php
$strParseFilePath = './gradle_build_file';

$datetime1 = new DateTime('2009-10-11');
$datetime2 = new DateTime('2009-10-13');
$interval = $datetime1->diff($datetime2);
// echo $interval->format('%R%a days');
echo (new DateTime('2009-10-11'))->diff(new DateTime('2009-10-13'))->format('%a');

















