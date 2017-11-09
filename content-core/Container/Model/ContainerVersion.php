<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerVersion extends Container, ContentVersion
{
    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string;

    /**
     * @return string
     */
    public function getPath(): string;
}
