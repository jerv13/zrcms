<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Uri\Api\BuildCmsUri;

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
            'container',
            $containerPath,
            $options
        );
    }
}
