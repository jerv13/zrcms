<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResource extends CmsResource
{
    /**
     * @return string
     */
    public function getSiteId(): string;

    /**
     * @return string
     */
    public function getPath(): string;
}
