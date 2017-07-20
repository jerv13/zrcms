<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\ContainerRevision ;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageContainerRevision extends ContainerRevision
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getKeywords(): string;
}
