<?php

namespace Siarko\ConfigCache\Provider;

use Siarko\CacheFiles\Api\CacheSetInterface;
use Siarko\ConfigCache\Api\Provider\CachedConfigProviderInterface;
use Siarko\ConfigFiles\Api\Provider\ConfigProviderInterface;

/**
 * This class represents the cached config provider implementation. It supports operations to
 * check if a config type exists, clear all cached configs or only one type, and get config by type.
 */
class CachedConfigProvider implements CachedConfigProviderInterface
{

    /**
     * @param ConfigProviderInterface $configProvider
     * @param CacheSetInterface $cache
     * @param string|null $providerType - Overwrite if you want to use different provider type than cache type
     */
    public function __construct(
        private readonly ConfigProviderInterface $configProvider,
        private readonly CacheSetInterface $cache,
        private readonly ?string $providerType = null
    )
    {
    }

    /**
     * Check if config type exists
     * @param string $type
     * @return bool
     */
    public function exists(string $type): bool
    {
        return $this->cache->exists($type);
    }

    /**
     * Clear all cached configs or only one type
     * @param string|null $type
     * @return void
     */
    public function clear(?string $type): void
    {
        $this->cache->clear($type);
    }

    /**
     * Get config by type
     * @param string $type
     * @return array
     */
    public function fetch(string $type): array
    {
        if($this->exists($type)){
            return $this->cache->get($type);
        }
        $config = $this->configProvider->fetch($this->providerType ?? $type);
        $this->cache->set($type, $config);
        return $config;
    }
}