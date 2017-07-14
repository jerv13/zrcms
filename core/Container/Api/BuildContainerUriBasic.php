<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\ContentResourceUri\Api\BuildCmsUri;
use Zrcms\Core\Container\Model\ContainerProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildContainerUriBasic implements BuildContainerUri
{
    /**
     * @var BuildCmsUri
     */
    protected $buildCmsUri;

    /**
     * @param BuildCmsUri $buildCmsUri
     */
    public function __construct(
        BuildCmsUri $buildCmsUri
    ) {
        $this->buildCmsUri = $buildCmsUri;
    }

    /**
     * @param int    $siteId
     * @param string $containerPath
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $containerPath,
        array $options = []
    ): string
    {
        return $this->buildCmsUri->__invoke(
            $siteId,
            ContainerProperties::URI_NAMESPACE,
            $containerPath,
            $options
        );
    }
}
