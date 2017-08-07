<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigBasicAbstract;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ServiceAliasViewRenderDataGetter;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadViewRenderDataGetterComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadViewRenderDataGetterComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasViewRenderDataGetter::NAMESPACE_COMPONENT_VIEW_RENDER_DATA_GETTER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
