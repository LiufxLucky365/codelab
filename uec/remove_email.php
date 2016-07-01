<?php
    $resFile   = new SplFileObject('/Users/liufuxin/Downloads/Pengalaman Pengguna.html', 'rb');

    $new_content = '';

    while (!$resFile->eof()) {
        $content = $resFile->current();
        $resFile->next();

        echo preg_replace("/([a-zA-Z0-9\-_]+)\@([a-zA-Z0-9\-_]+)\.([a-zA-Z0-9\-_]+)/"," ",$content);
    }