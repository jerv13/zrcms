<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentRegistry;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @todo   Implement this
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadLayoutComponentRegistry
{
    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        $defaultComponentConfReaderServiceAlias = ReadLayoutComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasLayout::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
