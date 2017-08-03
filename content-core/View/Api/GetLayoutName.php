<?php

namespace Zrcms\ContentCore\View\Api;

use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutName
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
    ): string;
}
