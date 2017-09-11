<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectCmsResourceAbstract extends CmsResourceAbstract implements RedirectCmsResource
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            PropertiesRedirectCmsResource::REQUEST_PATH
        );

        parent::__construct(
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
     * @throws ContentVersionNotExistsException
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof RedirectVersion) {
            throw new ContentVersionNotExistsException(
                'Missing required: ' . PropertiesRedirectCmsResource::CONTENT_VERSION
            );
        }
    }
}
