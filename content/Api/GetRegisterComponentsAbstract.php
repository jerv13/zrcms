<?php

namespace Zrcms\Content\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\ReadComponentRegistry;
use Zrcms\Content\Fields\FieldsComponent;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\Trackable;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class GetRegisterComponentsAbstract implements GetRegisterComponents
{
    /**
     * @var ReadComponentRegistry
     */
    protected $readComponentRegistry;

    /**
     * @todo Should we cache here??
     * Note: This cache is storing objects
     *
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var string
     */
    protected $defaultComponentClass;

    /**
     * @var string
     */
    protected $componentInterface;

    /**
     * @todo NOTE: Objects are being cached here, be careful
     *
     * @param ReadComponentRegistry $readComponentRegistry
     * @param Cache                 $cache
     * @param string                $cacheKey
     * @param string                $defaultComponentClass
     * @param string                $componentInterface
     *
     * @throws \Exception
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $cacheKey,
        string $defaultComponentClass,
        string $componentInterface = Component::class
    ) {
        $this->readComponentRegistry = $readComponentRegistry;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->defaultComponentClass = $defaultComponentClass;
        $this->componentInterface = $componentInterface;

        $this->assertValidClass(
            $defaultComponentClass
        );
    }

    /**
     * @param array $options
     *
     * @return Component[]
     */
    public function __invoke(
        array $options = []
    ): array
    {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $componentRegistry = $this->readComponentRegistry->__invoke();

        $configs = $this->buildComponentObjects(
            $componentRegistry
        );

        $this->setCache($configs);

        return $configs;
    }

    /**
     * hasCache
     *
     * @return bool
     */
    protected function hasCache()
    {
        return ($this->cache->has($this->cacheKey));
    }

    /**
     * getCache
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->cache->get($this->cacheKey);
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
        $this->cache->set($this->cacheKey, $configs);
    }

    /**
     * @param string $componentClass
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidClass(
        string $componentClass
    ) {
        if (!is_a($componentClass, $this->componentInterface, true)) {
            throw new \Exception(
                $componentClass . ' must be a ' . $this->componentInterface
            );
        }
    }

    /**
     * @param array $componentRegistry
     *
     * @return Component[]
     */
    protected function buildComponentObjects(
        array $componentRegistry
    ) {
        $configs = [];
        foreach ($componentRegistry as $componentConfig) {

            $configs[] = $this->buildComponentObject(
                $componentConfig
            );
        }

        return $configs;
    }

    /**
     * @param array $componentConfig
     *
     * @return Component
     */
    protected function buildComponentObject(
        array $componentConfig
    ) {
        $preparedConfig = $this->prepareConfig($componentConfig);
        $builtConfig = $this->buildSubComponents($preparedConfig);

        // Components might have special classes
        /** @var Component::class $componentClass */
        $componentClass = Param::get(
            $componentConfig,
            FieldsComponent::COMPONENT_CLASS,
            $this->defaultComponentClass
        );

        $this->assertValidClass($componentClass);
        //@todo get classification correctly
        return new $componentClass(
            Param::get(
                $builtConfig,
                FieldsComponentConfig::CLASSIFICATION,
                '@TODO get classification correctly'
            ),
            Param::getRequired(
                $builtConfig,
                FieldsComponentConfig::NAME
            ),
            Param::getRequired(
                $builtConfig,
                FieldsComponentConfig::CONFIG_LOCATION
            ),
            $builtConfig,
            Param::get(
                $builtConfig,
                FieldsComponentConfig::CREATED_BY_USER_ID,
                Trackable::UNKNOWN_USER_ID
            ),
            Param::get(
                $builtConfig,
                FieldsComponentConfig::CREATED_REASON,
                Trackable::UNKNOWN_REASON
            )
        );
    }

    /**
     * @param array $componentConfig
     *
     * @return array
     */
    protected function prepareConfig(array $componentConfig): array
    {
        // over-ride to prepare config
        return $componentConfig;
    }

    /**
     * @param array $componentConfig
     *
     * @return array
     */
    protected function buildSubComponents(array $componentConfig): array
    {
        // over-ride to build sub-components
        return $componentConfig;
    }
}
