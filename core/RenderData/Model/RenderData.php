<?php

namespace Zrcms\Core\RenderData\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderData
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
