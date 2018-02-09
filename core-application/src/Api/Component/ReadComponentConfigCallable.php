<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigCallable implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'callable-service';
    const READER_SCHEME = 'callable-service';

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
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        AssertValidReaderScheme::invoke(static::READER_SCHEME, $componentConfigUri);

        $callableServiceName = parse_url($componentConfigUri, PHP_URL_PATH);

        $callableService = $this->serviceContainer->get($callableServiceName);

        $componentConfig = $callableService->__invoke();

        $componentConfig[FieldsComponentConfig::CONFIG_URI] = $callableServiceName;

        Property::assertHas(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $componentConfig[FieldsComponentConfig::CONFIG_URI] = $callableServiceName;

        return $componentConfig;
    }
}
