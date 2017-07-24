<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\PropertiesBlockVersionEntity;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends \Zrcms\ContentCore\Container\Model\ContainerAbstract implements ContainerVersion
{
    /**
     * @var BlockVersion[]
     */
    protected $blockVersionsData = [];

}
