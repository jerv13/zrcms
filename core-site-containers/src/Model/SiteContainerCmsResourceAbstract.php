<?php

namespace Zrcms\CoreSiteContainer\Model;

use Zrcms\Core\Exception\ContentVersionInvalid;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreContainer\Model\ContainerCmsResourceAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteContainerCmsResourceAbstract extends ContainerCmsResourceAbstract
{
    /**
     * @param null|string                         $id
     * @param bool                                $published
     * @param SiteContainerVersion|ContentVersion $contentVersion
     * @param string                              $createdByUserId
     * @param string                              $createdReason
     * @param string|null                         $createdDate
     *
     * @throws ContentVersionInvalid
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @param SiteContainerVersion $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof SiteContainerVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . SiteContainerVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getSiteCmsResourceId())) {
            throw new ContentVersionInvalid(
                'SiteCmsResourceId can not be empty'
            );
        }

        if (empty($contentVersion->getName())) {
            throw new ContentVersionInvalid(
                'Name can not be empty'
            );
        }
    }
}
