<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFileBc extends ReadComponentConfigJsonFile implements ReadComponentConfig
{
    public function __invoke(
        string $jsonFilePath,
        array $options = []
    ): array {
        $componentConfig = parent::__invoke($jsonFilePath, $options);

        $componentConfig = FixBlockConfigTypeCategoryCollisionBc::invoke(
            $componentConfig
        );

        $componentConfig[FieldsBlockComponentConfig::TYPE] = 'block';

        return $componentConfig;
    }
}
