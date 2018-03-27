<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Page extends Content
{
    const DEFAULT_CONTAINER_NAME = 'content';
    const CONTAINER_CONTEXT = 'page';

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
