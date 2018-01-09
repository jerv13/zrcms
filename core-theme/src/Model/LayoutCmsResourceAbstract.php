<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\ContentVersionInvalid;
use Zrcms\Core\Model\CmsResourceAbstract;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract
{
    protected $themeName;
    protected $name;
    protected $html;

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
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param LayoutVersion|ContentVersion $contentVersion
     * @param string                       $modifiedByUserId
     * @param string                       $modifiedReason
     * @param string|null                  $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->themeName = $contentVersion->getThemeName();
        $this->name = $contentVersion->getName();
        $this->html = $contentVersion->getHtml();

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

        if (empty($contentVersion->getName())) {
            throw new ContentVersionInvalid(
                'Name can not be empty'
            );
        }
    }
}
