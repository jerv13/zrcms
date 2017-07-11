<?php

namespace Zrcms\RcmPluginCompatibility\Block\Internal;

use Zrcms\Core\Block\Api\FindBlocksBy;

class ConfigRepository
{
    const CACHE_KEY = 'ConfigRepositoryBc';

    /**
     * @var array
     */
    protected $pluginConfig;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ConfigFields
     */
    protected $configFields;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var $originalFindBlocksBy
     */
    protected $originalFindBlocksBy;

    /**
     * Constructor.
     *
     * @param                      $pluginConfig
     * @param Cache $cache
     * @param ConfigFields $configFields
     * @param $originalFindBlocksBy $$originalFindBlocksBy
     */
    public function __construct(
        $config,
        $cache,
        ConfigFields $configFields,
        FindBlocksBy $originalFindBlocksByServiceToWrap
    ) {
        $this->pluginConfig = $config['rcmPlugin'];
        $this->cache = $cache;
        $this->configFields = $configFields;
        $this->originalFindBlocksBy = $originalFindBlocksByServiceToWrap;
    }

    /**
     * hasCache
     *
     * @return bool
     */
    protected function hasCache()
    {
        return ($this->cache->hasItem(self::CACHE_KEY));
    }

    /**
     * getCache
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->cache->getItem(self::CACHE_KEY);
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
        $this->cache->setItem(self::CACHE_KEY, $configs);
    }

    /**
     * getConfigs
     *
     * @return array|mixed
     */
    protected function getConfigs()
    {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $pluginConfigs = $this->pluginConfig;

        $configs = [];

        foreach ($pluginConfigs as $name => $pluginConfig) {
            $config = $this->configFields->convertBc(
                $name,
                $pluginConfig
            );

            $configs[] = new ConfigBasic($config);
        }

        $newConfigs = $this->originalFindBlocksBy->__invoke([]);

        $configs = array_merge($configs, $newConfigs);

        $this->setCache($configs);

        return $configs;
    }





    /////BELOW CODE WAS FROM AN OLDER ABSTRACT CLASS





//    /**
//     * getConfigs
//     *
//     * @return array of Config
//     */
//    abstract protected function getConfigs();

    /**
     * search
     *
     * @param array $criteria
     *
     * @return array
     */
    protected function search(array $criteria = [])
    {
        $configs = $this->getConfigs();

        $result = [];

        foreach ($configs as $config) {
            if ($this->filter($config, $criteria)) {
                $result[] = $config;
            }
        }

        return $result;
    }

    /**
     * filter
     *
     * @param Config $config
     * @param array $criteria
     *
     * @return bool
     */
    protected function filter(Config $config, array $criteria = [])
    {
        $count = count($criteria);
        $default = new \stdClass();
        $countResult = 0;
        foreach ($criteria as $key => $value) {
            $configValue = $config->get($key, $default);
            if ($configValue === $value) {
                $countResult++;
            }
        }

        return ($countResult === $count);
    }

    /**
     * find
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return array
     * @throws \Exception
     */
    public function find(array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        // @todo implement these
        if ($orderBy !== null || $limit !== null || $offset !== null) {
            throw new \Exception('orderBy, limit and offset not yet implemented');
        }

        if (empty($criteria)) {
            return $this->getConfigs();
        }

        return $this->search($criteria);
    }

    /**
     * findOne
     *
     * @param array $criteria
     *
     * @return Config|null
     */
    public function findOne(array $criteria = [])
    {
        $result = $this->search($criteria);

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }

    /**
     * @param int $name
     * @return Config|null
     */
    public function findById($id)
    {
        return $this->findOne(['name' => $id]);
    }
}
