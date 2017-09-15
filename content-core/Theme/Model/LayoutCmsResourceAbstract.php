<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract
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
            PropertiesLayoutCmsResource::THEME_NAME,
            PropertyMissingException::build(
                PropertiesLayoutCmsResource::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesLayoutCmsResource::NAME,
            PropertyMissingException::build(
                PropertiesLayoutCmsResource::NAME,
                $properties,
                get_class($this)
            )
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
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->getProperty(
            PropertiesLayoutCmsResource::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getProperty(
            PropertiesLayoutCmsResource::NAME,
            ''
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
        if (!$contentVersion instanceof LayoutVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . LayoutVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
