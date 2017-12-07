<?php

namespace Zrcms\Cache\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ClearZrcmsCachesBasic implements ClearZrcmsCaches
{
    protected $serviceContainer;
    protected $zrcmsCachesConfig;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $zrcmsCachesConfig
     */
    public function __construct(
        $serviceContainer,
        array $zrcmsCachesConfig
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->zrcmsCachesConfig = $zrcmsCachesConfig;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $allCleared = true;
        /** @var string $cacheServiceName */
        foreach ($this->zrcmsCachesConfig as $cacheServiceName) {
            $cache = $this->serviceContainer->get($cacheServiceName);
            if (!$cache->clear()) {
                $allCleared = false;
            }
        }

        return $allCleared;
    }
}
