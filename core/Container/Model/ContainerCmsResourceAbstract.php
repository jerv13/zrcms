<?php

namespace Zrcms\Core\Container\Model;

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
    protected $siteId;

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
        // @todo might use getAndRemoveRequired
        $this->siteId = Param::getRequired(
            $properties,
            PropertiesContainerCmsResource::SITE_ID,
            new PropertyMissingException(
                'Required property (' . PropertiesContainerCmsResource::SITE_ID . ') is missing in: ' . get_class($this)
            )
        );

        // @todo might use getAndRemoveRequired
        $this->path = Param::getRequired(
            $properties,
            PropertiesContainerCmsResource::PATH,
            new PropertyMissingException(
                'Required property (' . PropertiesContainerCmsResource::PATH . ') is missing in: ' . get_class($this)
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
    public function getSiteId(): string
    {
        return $this->siteId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
