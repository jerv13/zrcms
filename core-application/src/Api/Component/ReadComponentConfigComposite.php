<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigComposite implements ReadComponentConfig
{
    const DEFAULT_CACHE_KEY = 'ZrcmsReadComponentConfigComposite';

    protected $serviceLocator;
    protected $readComponentConfigServiceNames;

    /**
     * @param ContainerInterface $serviceLocator
     * @param array              $readComponentConfigServiceNames
     */
    public function __construct(
        $serviceLocator,
        array $readComponentConfigServiceNames
    ) {
        $this->serviceLocator = $serviceLocator;
        $this->readComponentConfigServiceNames = $readComponentConfigServiceNames;
    }

    /**
     * @param string $componentConfigLocation
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigLocation,
        array $options = []
    ): array{
        foreach ($this->readComponentConfigServiceNames as $readComponentConfigServiceName) {
            /** @var ReadComponentConfig $readComponentConfig */
            $readComponentConfig = $this->serviceLocator->get($readComponentConfigServiceName);
            try {
                $componentConfig = $readComponentConfig->__invoke($options);
            } catch (CanNotReadComponentConfig $e) {
                continue;
            }

            return $componentConfig;
        }

        throw new CanNotReadComponentConfig(
            'No valid component config readers for config location: ' . $componentConfigLocation
        );
    }
}
