<?php

namespace Zrcms\Core\Theme\Model;

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
            PropertiesLayout::HTML
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
