<?php

namespace Zrcms\ViewMetaPageData;

use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewMetaPageData\Api\View\Render\GetViewLayoutMetaPageData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Api ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            // @todo Real ACL??
                            IsAllowedAny::class,
                            [
                                'literal' => [
                                    //IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    //IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin',
                                ]
                            ],
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'view-layout-tags' => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => __DIR__ . '/../config/meta-page-data',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => GetViewLayoutMetaPageData::class
                ],
            ],
        ];
    }
}
