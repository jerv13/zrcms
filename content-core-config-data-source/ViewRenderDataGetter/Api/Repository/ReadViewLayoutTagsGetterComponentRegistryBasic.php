<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfigJsonFile;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentRegistry;
use Zrcms\ContentCore\ViewLayoutTags\Model\ServiceAliasViewLayoutTagsGetter;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsGetterComponentRegistryBasic
    extends ReadComponentRegistryAbstract
    implements ReadViewLayoutTagsGetterComponentRegistry
{
    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        $defaultComponentConfReaderServiceAlias = ReadViewLayoutTagsGetterComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasViewLayoutTagsGetter::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
