<?php

namespace Zrcms\Content\Model;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceVersion
{
    /**
     * CmsResourceId
     *
     * @return string
     */
    public function getCmsResourceId(): string;

    /**
     * @return string
     */
    public function getVersionId(): string;

    /**
     * @return CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return ContentVersion
     */
    public function getVersion(): ContentVersion;
}
