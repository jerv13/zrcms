<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\CoreApplication\Api\Component\AssertValidReaderScheme;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;

/**
 * @deprecated BC ONLY
 * @author     James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFileBc extends ReadComponentConfigJsonFile implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'block-json-bc';
    const READER_SCHEME = 'block-json-bc';

    protected $prepareComponentConfig;

    /**
     * @param PrepareComponentConfigBlock $prepareComponentConfig
     */
    public function __construct(
        PrepareComponentConfigBlock $prepareComponentConfig
    ) {
        $this->prepareComponentConfig = $prepareComponentConfig;
    }

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        AssertValidReaderScheme::invoke(static::READER_SCHEME, $componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $jsonFilePath = $componentConfigUriParts['path'];

        $componentConfig = parent::__invoke($componentConfigUri, $options);

        $componentConfig = FixBlockConfigTypeCategoryCollisionBc::invoke(
            $componentConfig,
            $componentConfig
        );

        $componentConfig[FieldsComponentConfig::TYPE] = 'block';
        $componentConfig[FieldsComponentConfig::CONFIG_URI] = $componentConfigUri;

        return $this->prepareComponentConfig->__invoke(
            $componentConfig
        );
    }
}
