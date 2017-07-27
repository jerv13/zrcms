<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract extends ContentAbstract implements Layout
{
    /**
     * @var string
     */
    protected $html;

    /**
     * @param array  $properties
     */
    public function __construct(
        array $properties
    ) {

        $this->html = Param::getRequired(
            $properties,
            PropertiesLayout::HTML,
            new PropertyMissingException(
                'Required property (' . PropertiesLayout::HTML. ') is missing in: '
                . get_class($this)
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
        return $this->html;
    }
}
