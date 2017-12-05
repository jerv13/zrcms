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
     * @param string              $configReaderServiceAliasNamespace
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $configReaderServiceAliasNamespace = ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER,
        string $defaultComponentConfigReaderServiceName = ReadComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            $configReaderServiceAliasNamespace,
            $defaultComponentConfigReaderServiceName
        );
    }
}
