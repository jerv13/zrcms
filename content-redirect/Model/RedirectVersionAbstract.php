<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentRedirect\Fields\FieldsRedirectVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectVersionAbstract extends ContentVersionAbstract implements RedirectVersion
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws ContentVersionInvalid
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        Param::assertNotEmpty(
            $properties,
            FieldsRedirectVersion::REQUEST_PATH
        );

        Param::assertNotEmpty(
            $properties,
            FieldsRedirectVersion::REDIRECT_PATH
        );

        $siteCmsResourceId = Param::get(
            $properties,
            FieldsRedirectVersion::SITE_CMS_RESOURCE_ID,
            null
        );

        if (!is_string($siteCmsResourceId) && !is_null($siteCmsResourceId)) {
            throw new ContentVersionInvalid(
                'SiteCmsResourceId must be string or null'
            );
        }

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * if string, then applies to that site
     * if null, then applies to ALL sites
     *
     * @return string|null
     */
    public function getSiteCmsResourceId()
    {
        return $this->getProperty(
            FieldsRedirectVersion::SITE_CMS_RESOURCE_ID,
            null
        );
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->getProperty(
            FieldsRedirectVersion::REQUEST_PATH,
            null
        );
    }

    /**
     * @return string
     */
    public function getRedirectPath(): string
    {
        return $this->getProperty(
            FieldsRedirectVersion::REDIRECT_PATH,
            null
        );
    }
}
