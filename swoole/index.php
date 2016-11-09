<?php
    swoole_event_add(STDIN, function () {
        $data = fread(STDIN, 1024);
        $fp = fopen("pipe", "a+");
        fwrite($fp, $data);
    });

    swoole_event_add(fopen("pipe", "a+"), function ($fp) {
        $data = fread($fp, 1024);
        fwrite($fp, "");
        file_put_contents("php://stdout", $data);
    });

    //while (1) {
    //    sleep(1);
    //}

    //swoole_process::wait();