<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreSite\Model\SiteVersion;
use Zrcms\CoreTheme\Model\LayoutComponent;

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
