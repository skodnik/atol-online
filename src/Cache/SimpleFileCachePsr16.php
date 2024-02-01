<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Реализация класса кеширования PSR16.
 *
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class SimpleFileCachePsr16 implements CacheInterface
{
    private string $cacheDirectory;

    public function __construct(string $cacheDirectory = __DIR__ . '/../../data/tmp/cache')
    {
        $this->cacheDirectory = rtrim($cacheDirectory, DIRECTORY_SEPARATOR);
        if (!is_dir($this->cacheDirectory)) {
            mkdir($this->cacheDirectory, 0777, true);
        }
    }

    public function get($key, $default = null): mixed
    {
        $file = $this->getCacheFile($key);

        if (file_exists($file) && is_readable($file)) {
            $content = file_get_contents($file);
            $data = unserialize($content);

            if ($data['expires_at'] === null || $data['expires_at'] > time()) {
                return $data['value'];
            }

            // Cache has expired, remove the file
            unlink($file);
        }

        return $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        $file = $this->getCacheFile($key);

        $data = [
            'value' => $value,
            'expires_at' => $ttl !== null ? time() + $ttl : null,
        ];

        $content = serialize($data);
        return (bool)file_put_contents($file, $content, LOCK_EX);
    }

    public function delete($key): bool
    {
        $file = $this->getCacheFile($key);

        if (file_exists($file)) {
            unlink($file);

            return true;
        }

        return false;
    }

    public function clear(): bool
    {
        $files = glob($this->cacheDirectory . DIRECTORY_SEPARATOR . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return true;
    }

    public function getMultiple($keys, $default = null): array
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    protected function getCacheFile($key): string
    {
        $hashedKey = hash('sha256', $key);

        return $this->cacheDirectory . DIRECTORY_SEPARATOR . $hashedKey . '.cache';
    }

    public function has($key): bool
    {
        $file = $this->getCacheFile($key);

        return file_exists($file) && is_readable($file);
    }
}
