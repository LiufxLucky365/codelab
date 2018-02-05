<?php
	$arr = array('A', 'B');
	$arr = array_flip(array_change_key_case(array_flip($arr), CASE_LOWER));
	print_r($arr);