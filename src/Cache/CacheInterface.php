<?php

namespace App\Cache;

interface CacheInterface
{
    /**
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param $key
     * @param $value
     * @param $ttl
     *
     * @return mixed
     */
    public function set($key, $value, $ttl = null);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function delete($key);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @param $keys
     * @param $default
     *
     * @return mixed
     */
    public function getMultiple($keys, $default = null);

    /**
     * @param $values
     * @param $ttl
     *
     * @return mixed
     */
    public function setMultiple($values, $ttl = null);

    /**
     * @param $keys
     *
     * @return mixed
     */
    public function deleteMultiple($keys);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function has($key);

    /**
     * @param string $pattern
     *
     * @return mixed
     */
    public function keys(string $pattern);
}
