<?php

namespace Kernel\Application\Cache;

use RuntimeException;

abstract class CacheFileManager
{
    protected static string $cacheDir;

    /**
     * @throws RuntimeException
     */
    public static function init(string $cacheDir = APP_ROOT.'/tmp/cache'): void
    {
        static::$cacheDir = $cacheDir;

        if (! file_exists(static::$cacheDir)) {
            mkdir(static::$cacheDir, 0755, true);
        }

        if (! is_writable(static::$cacheDir)) {
            throw new RuntimeException('Cache directory is not writable: '.static::$cacheDir);
        }
    }

    /**
     * Retrieve an item from cache, or compute and store it.
     */
    public static function remember(string $key, callable $callback, int $ttl = 3600): mixed
    {
        $data = static::get($key);
        if ($data === null) {
            $data = $callback();
            static::set($key, $data, $ttl);
        }

        return $data;
    }

    /**
     * Store an item in cache.
     */
    public static function set(string $key, mixed $data, int $ttl = 3600): bool
    {
        $file = static::$cacheDir.'/'.md5($key).'.cache';

        $payload = [
            'data'       => $data,
            'expiration' => time() + $ttl,
        ];

        return file_put_contents($file, json_encode($payload)) !== false;
    }

    /**
     * Retrieve an item from cache, or null if missing/expired.
     */
    public static function get(string $key): mixed
    {
        $file = static::$cacheDir.'/'.md5($key).'.cache';

        if (! file_exists($file)) {
            return null;
        }

        $payload = json_decode(file_get_contents($file), true);

        if (json_last_error() !== JSON_ERROR_NONE || ! isset($payload['expiration'])) {
            return null;
        }

        if ($payload['expiration'] <= time()) {
            unlink($file);
            return null;
        }

        return $payload['data'];
    }

    /**
     * Remove an item from cache.
     */
    public static function forget(string $key): bool
    {
        $file = static::$cacheDir.'/'.md5($key).'.cache';

        if (file_exists($file)) {
            return unlink($file);
        }

        return false;
    }
}
