<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Block\Model\BlockBasic;
use Zrcms\CoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlocks
{
    const CACHE_KEY = 'ZrcmsBlockConfigJson';
    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @var PrepareBlockConfig
     */
    protected $prepareBlockConfig;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ReadBlockConfig
     */
    protected $readBlockConfig;

    /**
     * @param array              $registryConfig
     * @param PrepareBlockConfig $prepareBlockConfig
     * @param Cache              $cache
     * @param ReadBlockConfig    $readBlockConfig
     */
    public function __construct(
        array $registryConfig,
        PrepareBlockConfig $prepareBlockConfig,
        Cache $cache,
        ReadBlockConfig $readBlockConfig
    ) {
        $this->registryConfig = $registryConfig;
        $this->prepareBlockConfig = $prepareBlockConfig;
        $this->cache = $cache;
        $this->readBlockConfig = $readBlockConfig;
    }

    /**
     * hasCache
     *
     * @return bool
     */
    protected function hasCache()
    {
        return ($this->cache->has(self::CACHE_KEY));
    }

    /**
     * getCache
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->cache->get(self::CACHE_KEY);
    }

    /**
     * setCache
     *
     * @param array $configs
     *
     * @return void
     */
    protected function setCache($configs)
    {
        $this->cache->set(self::CACHE_KEY, $configs);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ) {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $blockConfigs = $this->readConfigs(
            $this->registryConfig
        );

        $configs = [];

        foreach ($blockConfigs as $blockConfig) {
            $config = $this->prepareBlockConfig->__invoke(
                $blockConfig
            );

            $configs[] = new BlockBasic(
                $config,
                $config[BlockConfigFields::CREATED_BY_USER_ID],
                $config[BlockConfigFields::CREATED_REASON]
            );
        }

        $this->setCache($configs);

        return $configs;
    }

    /**
     * @param array $blockPaths
     *
     * @return array
     * @throws \Exception
     */
    protected function readConfigs(array $blockPaths)
    {
        $blockConfigs = [];

        foreach ($blockPaths as $blockName => $blockDirectory) {
            $blockConfig = $this->readBlockConfig->__invoke($blockDirectory);

            if (!array_key_exists(BlockConfigFields::NAME, $blockConfig)) {
                throw  new \Exception(
                    'Block name is required for: ' . json_encode($blockConfig)
                );
            }

            $blockName = $blockConfig[BlockConfigFields::NAME];
            if (array_key_exists($blockName, $blockConfigs)) {
                throw  new \Exception(
                    'Duplicate block name configured.'
                );
            }
            $blockConfigs[$blockName] = $blockConfig;
        }

        return $blockConfigs;
    }
}
