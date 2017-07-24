<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteCmsResource extends CmsResource
{
    /**
     * @return string
     */
    public function getHost(): string;
}
