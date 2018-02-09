<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\Content;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayout;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        array $properties
    ) {

        Property::assertHas(
            $properties,
            FieldsLayout::HTML,
            get_class($this)
        );

        parent::__construct(
            $properties
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->findProperty(
            FieldsLayout::HTML,
            ''
        );
    }
}
