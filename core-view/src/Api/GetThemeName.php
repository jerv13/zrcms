<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreView\Exception\ThemeNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetThemeName
{
    /**
     * @param SiteCmsResource $siteCmsResource
     *
     * @return string
     * @throws ThemeNotFound
     */
    public function __invoke(
        SiteCmsResource $siteCmsResource
    ): string;
}
