<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
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
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        AssertValidReaderScheme::invoke(self::READER_SCHEME, $componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $jsonFilePath = $componentConfigUriParts['path'];
        $parentComponentConfigUri = 'json:' . $jsonFilePath;

        $componentConfig = parent::__invoke($componentConfigUri, $options);

        $componentConfig = FixBlockConfigTypeCategoryCollisionBc::invoke(
            $componentConfig
        );

        return $this->prepareComponentConfig->__invoke(
            $componentConfig
        );
    }
}
