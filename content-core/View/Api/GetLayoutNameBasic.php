<?php

namespace Zrcms\ContentCore\View\Api;

use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;
use Zrcms\ContentCore\Theme\Model\LayoutComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutNameBasic implements GetLayoutName
{
    /**
     * @param SiteVersion          $siteVersion
     * @param PageContainerVersion $pageContainerVersion
     * @param array                $options
     *
     * @return string
     */
    public function __invoke(
        SiteVersion $siteVersion,
        PageContainerVersion $pageContainerVersion,
        array $options = []
    ): string
    {
        $layoutName = $pageContainerVersion->getProperty(
            PropertiesPageContainerVersion::LAYOUT
        );

        if (!empty($layoutName)) {
            return $layoutName;
        }

        $layoutName = $siteVersion->getProperty(
            PropertiesSiteVersion::LAYOUT
        );

        if (!empty($layoutName)) {
            return $layoutName;
        }

        return LayoutComponent::PRIMARY_NAME;
    }
}
