<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerNamesByLayoutPageContainers implements GetContainerNamesByLayout
{
    const RENDER_TAG_PREFIX = 'page';

    protected $getTagNamesByLayout;

    /**
     * @param GetTagNamesByLayout $getTagNamesByLayout
     */
    public function __construct(
        GetTagNamesByLayout $getTagNamesByLayout
    ) {
        $this->getTagNamesByLayout = $getTagNamesByLayout;
    }

    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-name}']
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array {
        $layoutTags = $this->getTagNamesByLayout->__invoke(
            $layout,
            $options
        );

        $names = [];
        foreach ($layoutTags as $layoutTag) {
            $name = $this->getName($layoutTag);
            if ($name !== null) {
                $names[] = $name;
            }
        }

        return $names;
    }

    /**
     * @todo NOTE: this will only work with tags like page.{name}
     * @todo Not with page.something.{name}
     *
     * @param string $layoutTag
     *
     * @return bool
     */
    protected function getName(string $layoutTag)
    {
        $hasTag = (0 === strpos($layoutTag, self::RENDER_TAG_PREFIX));

        if (!$hasTag) {
            return null;
        }

        $parts = explode('.', $layoutTag);

        if (count($parts) !== 2) {
            // @todo error??
            return null;
        }

        return $parts[1];
    }
}
