<?php

namespace Zrcms\ContentCore\Basic\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigBasicAbstract;
use Zrcms\ContentCore\Basic\Model\ServiceAliasBasic;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadBasicComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadBasicComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasBasic::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
