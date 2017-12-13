<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigApplicationConfig implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'app-config';
    const READER_SCHEME = 'app-config';

    /**
     * @var array
     */
    protected $applicationConfig;

    /**
     * @param array $applicationConfig
     */
    public function __construct(
        array $applicationConfig
    ) {
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig|\Exception
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        AssertValidReaderScheme::invoke(static::READER_SCHEME, $componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $appConfigPath = $componentConfigUriParts['path'];

        $componentConfig = $this->getValueFromConfigPath(
            $this->applicationConfig,
            $appConfigPath
        );

        if (!is_array($componentConfig)) {
            throw new \Exception("Config location ({$appConfigPath}) not found");
        }

        Param::assertHas(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $componentConfig[FieldsComponentConfig::CONFIG_URI] = $componentConfigUri;

        return $componentConfig;
    }

    /**
     * @param array  $array
     * @param string $configKey
     *
     * @return array|mixed|null
     */
    protected function getValueFromConfigPath(
        array &$array,
        string $configKey
    ) {
        $parents = explode('.', $configKey);

        $ref = &$array;

        foreach ((array)$parents as $parent) {
            if (is_array($ref) && array_key_exists($parent, $ref)) {
                $ref = &$ref[$parent];
            } else {
                return null;
            }
        }

        return $ref;
    }
}
