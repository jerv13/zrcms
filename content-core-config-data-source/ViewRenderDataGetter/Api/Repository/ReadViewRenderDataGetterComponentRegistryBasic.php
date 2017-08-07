<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\ReadViewRenderDataGetterComponentConfigJsonFile;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\ReadViewRenderDataGetterComponentRegistry;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ServiceAliasViewRenderDataGetter;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentRegistryBasic
    extends ReadComponentRegistryAbstract
    implements ReadViewRenderDataGetterComponentRegistry
{
    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        $defaultComponentConfReaderServiceAlias = ReadViewRenderDataGetterComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasViewRenderDataGetter::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
