<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CoreSite\Model\SiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutName
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
    ): string;
}
