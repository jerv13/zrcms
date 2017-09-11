<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerCmsResourceAbstract extends CmsResourceAbstract
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
            PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID,
            PropertyMissingException::build(
                PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesContainerCmsResource::PATH,
            PropertyMissingException::build(
                PropertiesContainerCmsResource::PATH,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
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
            PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID,
            ''
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            PropertiesContainerCmsResource::PATH,
            ''
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
        if (!$contentVersion instanceof ContainerVersion) {
            throw new ContentVersionNotExistsException(
                'Missing required: ' . PropertiesContainerCmsResource::CONTENT_VERSION
            );
        }
    }
}
