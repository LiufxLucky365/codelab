<?php
/**
 * 测试进程内通信-信号
 *
 * 主进程生成三个进程, 然后输出三个子进程退出信号, 然后退出
 */

$workerNum = 3;
$workers = [];

function genProcess($workerNum) {
    for ($i = 0; $i < $workerNum; $i++) {
        yield new swoole_process(function(swoole_process $process) {
            // 子进程监听退出信号
            swoole_process::signal(SIGTERM, function($sig) use ($process) {
                echo "from son: {$process->pid} exit" . PHP_EOL;
                $process->exit();
            });
        });
    }
}

foreach (genProcess($workerNum) as $process) {
    $process->start();
    $workers[$process->pid] = $process;
}

/**
 * 父进程监听子进程退出信号
 */
swoole_process::signal(SIGCHLD, function($sig) {
    // 必须为false，非阻塞模式
    while($ret =  swoole_process::wait(false)) {
        echo "from parent: {$ret['pid']} {$ret['signal']}" . PHP_EOL;
    }
});