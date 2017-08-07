<?php

namespace Zrcms\ContentCore\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigBasicAbstract;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
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
