<?php

namespace Zrcms\ContentCore\Theme\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigByStrategyAbstract;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentConfigByStrategy
    extends ReadComponentConfigByStrategyAbstract
    implements ReadLayoutComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadLayoutComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasLayout::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
