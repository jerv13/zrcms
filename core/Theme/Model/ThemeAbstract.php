<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Core\Theme\Exception\DefaultLayoutMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeAbstract extends ContentAbstract implements Theme
{
    protected $name;

    protected $directory;

    protected $layouts;

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
        $this->name = Param::getRequired(
            $properties,
            ThemeProperties::NAME
        );

        $this->directory = Param::getRequired(
            $properties,
            ThemeProperties::DIRECTORY
        );

        $this->addLayouts(
            Param::getRequired(
                $properties,
                ThemeProperties::LAYOUTS
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * Unique Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Directory where files are located
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * List of Layouts
     *
     * @return array
     */
    public function getLayouts(): array
    {
        return $this->layouts;
    }

    /**
     * @param string      $name
     * @param Layout|null $default
     *
     * @return Layout|null
     */
    public function getLayout(
        string $name,
        Layout $default = null
    ) {
        if ($this->hasLayout(Layout::DEFAULT_NAME)) {
            return $this->layouts[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasLayout(
        string $name
    ): bool
    {
        return array_key_exists($name, $this->layouts);
    }

    /**
     * @return Layout
     * @throws DefaultLayoutMissingException
     */
    public function getDefaultLayout()
    {
        if (!$this->hasLayout(Layout::DEFAULT_NAME)) {
            throw new DefaultLayoutMissingException(
                "Default layout is missing for theme " . $this->getName()
            );
        }

        return $this->getLayout(Layout::DEFAULT_NAME);
    }

    /**
     * @param array $layouts
     *
     * @return void
     */
    protected function addLayouts(array $layouts)
    {
        foreach ($layouts as $layout) {
            $this->addLayout($layout);
        }
    }

    /**
     * @param Layout $layout
     *
     * @return void
     */
    protected function addLayout(Layout $layout)
    {
        $this->layouts[$layout->getName()] = $layout;
    }
}
