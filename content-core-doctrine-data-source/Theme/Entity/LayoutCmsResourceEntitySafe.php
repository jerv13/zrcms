<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutCmsResourceEntitySafe extends LayoutCmsResourceEntity
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

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->id = Param::getString(
            $properties,
            PropertiesLayoutCmsResource::ID,
            ''
        );

        $this->contentVersionId = Param::getString(
            $properties,
            PropertiesLayoutCmsResource::CONTENT_VERSION_ID,
            ''
        );

        $this->published = Param::getBool(
            $properties,
            PropertiesLayoutCmsResource::PUBLISHED,
            true
        );
    }
}
