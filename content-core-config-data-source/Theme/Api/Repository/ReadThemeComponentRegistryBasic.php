<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentRegistry;
use Zrcms\ContentCore\Theme\Model\ServiceAliasTheme;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadThemeComponentRegistry
{
    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        $defaultComponentConfReaderServiceAlias = ReadThemeComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasTheme::NAMESPACE_COMPONENT_CONFIG_READER,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
