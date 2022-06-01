<?php

namespace App\Cache;

use App\Cache\Adapters\AdapterRedis;
use Redis;
use Throwable;

final class CacheWorker
{
    /**
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    public static function addValue(string $key, string $value): string
    {
        $store = self::getCache();

        try {
            $store->set($key, $value, 3600);
        } catch (Throwable $exception) {

            return $exception;
        }

        return "success\n";
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function deleteValue(string $key): string
    {
        $store = self::getCache();

        try {
            $store->delete($key);
        } catch (Throwable $exception) {

            return $exception->getMessage();
        }

        return "success\n";
    }

    /**
     * @return array
     */
    public static function getAllKeyValues(): array
    {
        $keys = self::getCache()->keys('*');

        $data = [];

        foreach ($keys as $key) {
            $data[$key] = self::getCache()->get($key);
        }

        return $data;
    }

    /**
     * @return CacheInterface
     */
    private static function getCache(): CacheInterface {

        if (!isset($GLOBALS['cache_system'])) {

            // создаем соединение
            $store = new Redis();
            $store->connect('redis');

            $client = new AdapterRedis($store);

            $GLOBALS['cache_system'] = new Scache($client);
        }

        return $GLOBALS['cache_system'];
    }
}