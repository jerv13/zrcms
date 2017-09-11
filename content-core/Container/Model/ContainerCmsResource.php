<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResource extends CmsResource
{
    /**
     * @return ContainerVersion|ContentVersion
     */
    public function getContentVersion();

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string;

    /**
     * @return string
     */
    public function getPath(): string;
}
