<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\Content;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayout;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract extends ContentAbstract
{
    /**
     * @param array  $properties
     */
    public function __construct(
        array $properties
    ) {

        Param::assertHas(
            $properties,
            FieldsLayout::HTML,
            PropertyMissing::buildThrower(
                FieldsLayout::HTML,
                $properties,
                get_class($this)
            )
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
        return $this->getProperty(
            FieldsLayout::HTML,
            ''
        );
    }
}
