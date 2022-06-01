<?php

use App\Cache\CacheWorker;

require_once '../vendor/autoload.php';

$method = $argv[2];

switch ($method) {
    case 'add':
        if (!isset($argv[3], $argv[4])) {
            echo "введите все значения";
            exit(1);
        }

        $result = CacheWorker::addValue($argv[3], $argv[4]);
        break;
    case 'delete':
        if (!isset($argv[3])) {
            echo "введите все значения";
            exit(1);
        }

        $result = CacheWorker::deleteValue($argv[3]);
        break;
    default:
        echo "введите корректное название метода";
        exit(1);
}

echo $result;