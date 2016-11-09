<?php
$census = [];
$resFile = new SplFileObject("poi_suspected_census.txt", "r");
while (!$resFile->eof()) {
    $line = $resFile->current();
    @list($tag, $num) = explode("\t", $line);
    $tagList = explode(";", $tag);
    @$census[trim($tagList[0])] += $num;

    $resFile->next();
}

asort($census);
foreach ($census as $tag => $count) {
    printf("%-10d%s \n", $count, $tag);
}