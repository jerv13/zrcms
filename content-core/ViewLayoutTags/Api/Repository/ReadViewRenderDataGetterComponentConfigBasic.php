<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigBasicAbstract;
use Zrcms\ContentCore\ViewLayoutTags\Model\ServiceAliasViewLayoutTagsGetter;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsGetterComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadViewLayoutTagsGetterComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadViewLayoutTagsGetterComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasViewLayoutTagsGetter::NAMESPACE_COMPONENT_VIEW_RENDER_TAGS_GETTER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
