<?php

namespace Zrcms\ContentCore\View\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigByStrategyAbstract;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigByStrategy
    extends ReadComponentConfigByStrategyAbstract
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
            ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER,
            $defaultComponentConfigReaderServiceName
        );
    }
}
