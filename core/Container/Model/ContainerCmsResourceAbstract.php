<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\CmsResourceProperties;
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
     * @param string $contentRevisionId
     * @param array  $properties
     */
    public function __construct(
        string $contentRevisionId,
        array $properties = []
    ) {

        $this->siteId = Param::getAndRemoveRequired(
            $properties,
            ContainerCmsResourceProperties::SITE_ID,
            new PropertyMissingException(
                'Required property (' . ContainerCmsResourceProperties::SITE_ID . ') is missing in: '
                . get_class($this)
            )
        );

        $this->path = Param::getAndRemoveRequired(
            $properties,
            ContainerCmsResourceProperties::PATH,
            new PropertyMissingException(
                'Required property (' . ContainerCmsResourceProperties::PATH . ') is missing in: '
                . get_class($this)
            )
        );

        $this->contentRevisionId = $contentRevisionId;

        parent::__construct(
            $contentRevisionId,
            $properties = []
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
