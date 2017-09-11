<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\ContentAbstract;
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
            PropertiesLayout::HTML,
            PropertyMissingException::build(
                PropertiesLayout::HTML,
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
            PropertiesLayout::HTML,
            ''
        );
    }
}
