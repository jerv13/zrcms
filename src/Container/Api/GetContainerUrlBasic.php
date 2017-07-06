<?php

namespace Rcms\Core\Container\Api;

use Rcms\Core\Url\Api\BuildCmsUrl;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerUrlBasic implements GetContainerUrl
{
    protected $buildCmsUrl;

    /**
     * @param BuildCmsUrl $buildCmsUrl
     */
    public function __construct(
        BuildCmsUrl $buildCmsUrl
    ) {
        $this->buildCmsUrl = $buildCmsUrl;
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
        return $this->buildCmsUrl->__invoke(
            $siteId,
            'container',
            $containerName,
            $options
        );
    }
}
