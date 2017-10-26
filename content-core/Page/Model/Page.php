<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Page extends Content
{
    const DEFAULT_CONTAINER_NAME = 'content';

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getKeywords(): string;

    /**
     * @return array
     */
    public function getContainersData(): array;

    /**
     * @param string $name
     *
     * @return array|null
     */
    public function findContainerData(string $name = Page::DEFAULT_CONTAINER_NAME);

    /**
     * @return Container[]
     */
    public function getContainers(): array;

    /**
     * @param string $name
     *
     * @return Container|null
     */
    public function findContainer(string $name = Page::DEFAULT_CONTAINER_NAME);
}
