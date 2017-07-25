<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerCmsResourceAbstract extends CmsResourceAbstract implements ContainerCmsResource
{
    /**
     * @var string
     */
    protected $siteCmsResourceId;

    /**
     * @var string
     */
    protected $path;

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

        $this->siteCmsResourceId = Param::getRequired(
            $properties,
            PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID,
            new PropertyMissingException(
                'Required property (' . PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID . ') is missing in: '
                . get_class($this)
            )
        );

        $this->path = Param::getRequired(
            $properties,
            PropertiesContainerCmsResource::PATH,
            new PropertyMissingException(
                'Required property (' . PropertiesContainerCmsResource::PATH . ') is missing in: '
                . get_class($this)
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
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
