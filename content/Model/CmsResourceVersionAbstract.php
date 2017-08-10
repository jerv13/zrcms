<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceVersionAbstract implements CmsResourceVersion
{
    /**
     * @var CmsResource
     */
    protected $cmsResource;

    /**
     * @var ContentVersion
     */
    protected $contentVersion;

    /**
     * @param CmsResource    $cmsResource
     * @param ContentVersion $contentVersion
     */
    public function __construct(
        CmsResource $cmsResource,
        ContentVersion $contentVersion
    ) {
        $this->cmsResource = $cmsResource;
        $this->contentVersion = $contentVersion;
    }

    /**
     * CmsResourceId
     *
     * @return string
     */
    public function getCmsResourceId(): string
    {
        return $this->getCmsResource()->getId();
    }

    /**
     * @return string
     */
    public function getVersionId(): string
    {
        return $this->getVersion()->getId();
    }

    /**
     * @return CmsResource
     */
    public function getCmsResource(): CmsResource
    {
        return $this->cmsResource;
    }

    /**
     * @return ContentVersion
     */
    public function getVersion(): ContentVersion
    {
        return $this->contentVersion;
    }
}
