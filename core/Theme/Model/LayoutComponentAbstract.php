<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutComponentAbstract extends ComponentAbstract implements LayoutComponent
{
    /**
     * @var string
     */
    protected $themeName;

    /**
     * @var string
     */
    protected $html;

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

        $this->themeName = Param::getRequired(
            $properties,
            PropertiesLayoutComponent::THEME_NAME
        );

        $this->html = Param::getRequired(
            $properties,
            PropertiesLayoutComponent::HTML,
            false
        );

        parent::__construct(
            $properties = [],
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
