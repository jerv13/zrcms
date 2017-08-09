<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HeadSection extends Content
{
    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return array
     */
    public function getSections(): array;

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getSection(string $name, $default = null);
}
