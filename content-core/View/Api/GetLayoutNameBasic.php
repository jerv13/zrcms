<?php

namespace Zrcms\ContentCore\View\Api;

use Zrcms\ContentCore\Page\Model\PageVersion;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;
use Zrcms\ContentCore\Site\Fields\FieldsSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;
use Zrcms\ContentCore\Theme\Model\LayoutComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutNameBasic implements GetLayoutName
{
    /**
     * @param SiteVersion $siteVersion
     * @param PageVersion $pageVersion
     * @param array       $options
     *
     * @return string
     */
    public function __invoke(
        SiteVersion $siteVersion,
        PageVersion $pageVersion,
        array $options = []
    ): string
    {
        $layoutName = $pageVersion->getProperty(
            FieldsPageVersion::LAYOUT
        );

        if (!empty($layoutName)) {
            return $layoutName;
        }

        $layoutName = $siteVersion->getProperty(
            FieldsSiteVersion::LAYOUT
        );

        if (!empty($layoutName)) {
            return $layoutName;
        }

        return LayoutComponent::PRIMARY_NAME;
    }
}
