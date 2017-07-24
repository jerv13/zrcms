<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Api\ReadComponentConfigBasicAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadBlockComponentConfig
{
    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        $serviceContainer,
        $defaultComponentConfigReaderServiceName = ReadBlockComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $serviceContainer,
            $defaultComponentConfigReaderServiceName
        );
    }
}
