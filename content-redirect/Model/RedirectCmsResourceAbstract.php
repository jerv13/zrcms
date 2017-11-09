<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectCmsResourceAbstract extends CmsResourceAbstract implements RedirectCmsResource
{
    protected $siteCmsResourceId;
    protected $requestPath;

    /**
     * @param string|null                    $id
     * @param bool                           $published
     * @param RedirectVersion|ContentVersion $contentVersion
     * @param string                         $createdByUserId
     * @param string                         $createdReason
     * @param string|null                    $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
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
     * @return string|null
     */
    public function getSiteCmsResourceId()
    {
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }

    /**
     * @param RedirectVersion|ContentVersion $contentVersion
     * @param string                         $modifiedByUserId
     * @param string                         $modifiedReason
     * @param string                         $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate
    ) {
        $this->siteCmsResourceId = $contentVersion->getSiteCmsResourceId();
        $this->requestPath = $contentVersion->getRequestPath();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param RedirectVersion $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof RedirectVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . RedirectVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getRequestPath())) {
            throw new ContentVersionInvalid(
                'RequestPath can not be empty'
            );
        }
    }
}
