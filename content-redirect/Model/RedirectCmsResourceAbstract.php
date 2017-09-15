<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectCmsResourceAbstract extends CmsResourceAbstract implements RedirectCmsResource
{
    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param array          $properties
     * @param string         $createdByUserId
     * @param string         $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            PropertiesRedirectCmsResource::REQUEST_PATH
        );

        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string|null
     */
    public function getSiteCmsResourceId()
    {
        return $this->getProperty(
            PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID,
            null
        );
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->getProperty(
            PropertiesRedirectCmsResource::REQUEST_PATH,
            null
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
        if (!$contentVersion instanceof RedirectVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . RedirectVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
