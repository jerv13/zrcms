<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourcePublishHistory extends CmsResource
{
    /**
     * @return string
     */
    public function getCmsResourceId(): string;

    /**
     * @return string
     */
    public function getAction(): string;
}
