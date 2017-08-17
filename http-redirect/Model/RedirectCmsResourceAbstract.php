<?php

namespace Zrcms\HttpRedirect\Redirect\Model;

use Zrcms\Content\Model\CmsResourceAbstract;

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
        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string|null
     */
    public function siteCmsResourceId()
    {
        return $this->getProperty(
            PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID,
            null
        );
    }
}
