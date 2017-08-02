<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Api\ReadComponentConfigBasicAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentConfigBasic
    extends ReadComponentConfigBasicAbstract
    implements ReadViewRenderDataGetterComponentConfig
{
    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultComponentConfigReaderServiceName = ReadViewRenderDataGetterComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $serviceContainer,
            $defaultComponentConfigReaderServiceName
        );
    }
}
