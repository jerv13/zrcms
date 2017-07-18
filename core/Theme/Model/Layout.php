<?php

namespace Zrcms\Core\Theme\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Layout
{
    const DEFAULT_NAME = 'default';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
