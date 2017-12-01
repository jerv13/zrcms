<?php

namespace Zrcms\ContentCore\Theme\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigByStrategyAbstract;
use Zrcms\ContentCore\Theme\Model\ServiceAliasTheme;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentConfigByStrategy
    extends ReadComponentConfigByStrategyAbstract
    implements ReadThemeComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadThemeComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasTheme::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
