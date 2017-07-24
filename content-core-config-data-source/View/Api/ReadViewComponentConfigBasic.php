<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Api\ReadComponentConfigBasicAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadViewComponentConfig
{
    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultComponentConfigReaderServiceName = ReadViewComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $serviceContainer,
            $defaultComponentConfigReaderServiceName
        );
    }
}
