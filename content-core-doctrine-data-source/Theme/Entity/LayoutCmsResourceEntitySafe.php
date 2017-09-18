<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Zrcms\ContentCore\Theme\Fields\FieldsLayoutCmsResource;
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
            FieldsLayoutCmsResource::ID,
            ''
        );

        $this->contentVersion = Param::getRequired(
            $properties,
            FieldsLayoutCmsResource::CONTENT_VERSION
        );

        $this->published = Param::getBool(
            $properties,
            FieldsLayoutCmsResource::PUBLISHED,
            true
        );
    }
}
