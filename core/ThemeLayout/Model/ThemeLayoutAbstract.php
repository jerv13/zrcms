<?php

namespace Zrcms\Core\ThemeLayout\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ThemeLayoutAbstract extends ContentAbstract implements ThemeLayout
{
    protected $themeName;
    protected $name;
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
            ThemeLayoutProperties::THEME_NAME
        );

        $this->name = Param::getRequired(
            $properties,
            ThemeLayoutProperties::NAME
        );

        $this->html = Param::getRequired(
            $properties,
            ThemeLayoutProperties::HTML
        );

        $this->id = $this->themeName . '/' . $this->name;

        parent::__construct(
            $properties,
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
