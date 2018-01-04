<?php

namespace Zrcms\CoreView\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ComponentAbstract;
use Zrcms\CoreView\Fields\FieldsViewLayoutTagsComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewLayoutTagsComponentAbstract extends ComponentAbstract
{
    /**
     * @param string      $type
     * @param string      $name
     * @param string      $configUri
     * @param string      $moduleDirectory
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __construct(
        string $type,
        string $name,
        string $configUri,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Param::assertHas(
            $properties,
            FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            get_class($this)
        );

        parent::__construct(
            $type,
            $name,
            $configUri,
            $moduleDirectory,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getViewLayoutTagsGetter(): string
    {
        return Param::getString(
            $this->properties,
            FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            ''
        );
    }
}
