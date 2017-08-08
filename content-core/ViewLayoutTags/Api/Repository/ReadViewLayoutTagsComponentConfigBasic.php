<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigBasicAbstract;
use Zrcms\ContentCore\ViewLayoutTags\Model\ServiceAliasViewLayoutTags;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadViewLayoutTagsComponentConfig
{
    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultComponentConfigReaderServiceName = ReadViewLayoutTagsComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $getServiceFromAlias,
            ServiceAliasViewLayoutTags::NAMESPACE_COMPONENT_VIEW_RENDER_TAGS_GETTER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
