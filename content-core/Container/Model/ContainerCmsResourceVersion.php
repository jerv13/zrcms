<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return ContainerCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return ContainerVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
