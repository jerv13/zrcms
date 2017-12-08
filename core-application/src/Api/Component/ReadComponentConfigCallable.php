<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigCallable implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'callable-service';
    const READER_PROTOCOL = 'callable-service://';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param string $callableServiceName
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $callableServiceName,
        array $options = []
    ): array {
        AssertValidReaderProtocol::invoke(self::READER_PROTOCOL, $callableServiceName);

        $callableService = $this->serviceContainer->get($callableServiceName);

        $componentConfig = $callableService->__invoke();

        $componentConfig[FieldsComponentConfig::CONFIG_LOCATION] = $callableServiceName;

        Param::assertHas(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $componentConfig[FieldsComponentConfig::CONFIG_LOCATION] = $callableServiceName;

        return $componentConfig;
    }
}
