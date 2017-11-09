<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract
{
    protected $themeName;
    protected $name;

    /**
     * @param string|null                  $id
     * @param bool                         $published
     * @param LayoutVersion|ContentVersion $contentVersion
     * @param string                       $createdByUserId
     * @param string                       $createdReason
     * @param string|null                  $createdDate
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
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param LayoutVersion|ContentVersion $contentVersion
     * @param string                       $modifiedByUserId
     * @param string                       $modifiedReason
     * @param string                       $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate
    ) {
        $this->themeName = $contentVersion->getThemeName();
        $this->name = $contentVersion->getName();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param LayoutVersion $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof LayoutVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . LayoutVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getThemeName())) {
            throw new ContentVersionInvalid(
                'ThemeName can not be empty'
            );
        }

        if (empty($contentVersion->getThemeName())) {
            throw new ContentVersionInvalid(
                'Name can not be empty'
            );
        }
    }
}
