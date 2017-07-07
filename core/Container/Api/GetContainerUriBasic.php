<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Uri\Api\BuildCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerUriBasic implements GetContainerUri
{
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
     * @param string $containerName
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $containerName,
        array $options = []
    ): string
    {
        return $this->buildCmsUri->__invoke(
            $siteId,
            'container',
            $containerName,
            $options
        );
    }
}
