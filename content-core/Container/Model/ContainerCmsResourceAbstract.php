<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Container\Fields\FieldsContainerCmsResource;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerCmsResourceAbstract extends CmsResourceAbstract
{
    /**
     * @param string|null                     $id
     * @param bool                            $published
     * @param ContainerVersion|ContentVersion $contentVersion
     * @param array                           $properties
     * @param string                          $createdByUserId
     * @param string                          $createdReason
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
            FieldsContainerCmsResource::SITE_CMS_RESOURCE_ID,
            PropertyMissing::buildThrower(
                FieldsContainerCmsResource::SITE_CMS_RESOURCE_ID,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsContainerCmsResource::PATH,
            PropertyMissing::buildThrower(
                FieldsContainerCmsResource::PATH,
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
    public function getSiteCmsResourceId(): string
    {
        return $this->getProperty(
            FieldsContainerCmsResource::SITE_CMS_RESOURCE_ID,
            ''
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            FieldsContainerCmsResource::PATH,
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
        if (!$contentVersion instanceof ContainerVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . ContainerVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
