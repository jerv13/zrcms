<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Api\AssertValidPath;
use Zrcms\ContentCore\Page\Exception\InvalidPath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageCmsResourceAbstract extends CmsResourceAbstract
{
    protected $siteCmsResourceId;
    protected $path;

    /**
     * @param null|string                $id
     * @param bool                       $published
     * @param PageVersion|ContentVersion $contentVersion
     * @param string                     $createdByUserId
     * @param string                     $createdReason
     * @param string|null                $createdDate
     *
     * @throws InvalidPath
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
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param PageVersion|ContentVersion $contentVersion
     * @param string                     $modifiedByUserId
     * @param string                     $modifiedReason
     * @param string|null                $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->siteCmsResourceId = $contentVersion->getSiteCmsResourceId();
        $this->path = $contentVersion->getPath();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof PageVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . PageVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getSiteCmsResourceId())) {
            throw new ContentVersionInvalid(
                'SiteCmsResourceId can not be empty'
            );
        }

        if (empty($contentVersion->getPath())) {
            throw new ContentVersionInvalid(
                'Path can not be empty'
            );
        }

        AssertValidPath::invoke($contentVersion->getPath());
    }
}
