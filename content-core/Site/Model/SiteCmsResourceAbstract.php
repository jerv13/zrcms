<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteCmsResourceAbstract extends CmsResourceAbstract
{
    protected $host;
    protected $themeName;
    protected $locale;

    /**
     * @param string|null                $id
     * @param bool                       $published
     * @param SiteVersion|ContentVersion $contentVersion
     * @param string                     $createdByUserId
     * @param string                     $createdReason
     * @param string|null                $createdDate
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
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param SiteVersion|ContentVersion $contentVersion
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
        $this->host = $contentVersion->getHost();
        $this->themeName = $contentVersion->getThemeName();
        $this->locale = $contentVersion->getLocale();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param SiteVersion $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof SiteVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . SiteVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getHost())) {
            throw new ContentVersionInvalid(
                'Host can not be empty'
            );
        }

        if (empty($contentVersion->getThemeName())) {
            throw new ContentVersionInvalid(
                'ThemeName can not be empty'
            );
        }

        if (empty($contentVersion->getLocale())) {
            throw new ContentVersionInvalid(
                'Locale can not be empty'
            );
        }
    }
}
