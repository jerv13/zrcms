<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\ServiceAliasComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigByStrategy extends ReadComponentConfigByStrategyAbstract implements ReadComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasComponent::NAMESPACE_COMPONENT_CONFIG_READER,
            ReadComponentConfigJsonFile::SERVICE_ALIAS
        );
    }
}
