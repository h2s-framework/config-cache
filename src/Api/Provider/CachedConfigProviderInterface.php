<?php

namespace Siarko\ConfigCache\Api\Provider;

use Siarko\ConfigFiles\Api\Provider\ConfigProviderInterface;

interface CachedConfigProviderInterface extends ConfigProviderInterface
{

    /**
     * Check if config type exists
     * @param string $type
     * @return bool
     */
    public function exists(string $type): bool;

    /**
     * Clear all cached configs or only one type
     * @param string|null $type
     * @return void
     */
    public function clear(?string $type): void;
}