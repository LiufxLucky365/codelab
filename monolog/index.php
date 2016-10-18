<?php
require_once('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('warning.log', Logger::WARNING));

$errHandler = new StreamHandler('error.html', Logger::ERROR);
$errHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
$log->pushHandler($errHandler);

$log->pushProcessor(function ($record) {
    $record['extra']['dummy'] = 'Hello world!';

    return $record;
});

// add records to the log
$log->addWarning('this is warning');
$log->addError('this is error', array(
    'test' => 1
));