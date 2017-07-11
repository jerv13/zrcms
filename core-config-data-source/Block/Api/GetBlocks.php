<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\BlockBasic;
use Zrcms\Core\Cache\Service\Cache;
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
     * @param array              $registryConfig
     * @param PrepareBlockConfig $prepareBlockConfig
     * @param Cache              $cache
     */
    public function __construct(
        array $registryConfig,
        PrepareBlockConfig $prepareBlockConfig,
        Cache $cache
    ) {
        $this->registryConfig = $registryConfig;
        $this->prepareBlockConfig = $prepareBlockConfig;
        $this->cache = $cache;
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
                $config[BlockConfigFields::CONFIG],
                $config[BlockConfigFields::DIRECTORY],
                $config[BlockConfigFields::RENDERER],
                $config[BlockConfigFields::CACHE],
                $config[BlockConfigFields::FIELDS],
                $config[BlockConfigFields::CONFIG],
                $config,
                $config[BlockConfigFields::CREATED_BY_USER_ID],
                $config[BlockConfigFields::CREATED_REASON]
            );
        }

        $this->setCache($configs);

        return $configs;
    }

    /**
     * readConfigs
     *
     * @param array $blockPaths
     *
     * @return array
     */
    protected function readConfigs(array $blockPaths)
    {
        $blockConfigs = [];

        foreach ($blockPaths as $blockPath) {
            $blockDir = $blockPath;
            $configFileName = $blockDir . '/block.json';
            $configFileContents = file_get_contents($configFileName);
            $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);
            $config['directory'] = realpath($blockDir);
            $blockConfigs[$config['name']] = $config;
        }

        return $blockConfigs;
    }
}
