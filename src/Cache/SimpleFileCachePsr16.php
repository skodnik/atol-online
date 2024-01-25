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

    public function get($key, $default = null)
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

    public function set($key, $value, $ttl = null): void
    {
        $file = $this->getCacheFile($key);

        $data = [
            'value' => $value,
            'expires_at' => $ttl !== null ? time() + $ttl : null,
        ];

        $content = serialize($data);
        file_put_contents($file, $content, LOCK_EX);
    }

    public function delete($key): void
    {
        $file = $this->getCacheFile($key);

        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function clear(): void
    {
        $files = glob($this->cacheDirectory . DIRECTORY_SEPARATOR . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function getMultiple($keys, $default = null): array
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    public function setMultiple($values, $ttl = null): void
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function deleteMultiple($keys): void
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
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
