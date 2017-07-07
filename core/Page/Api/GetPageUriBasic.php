<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Uri\Api\BuildCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageUriBasic implements GetPageUri
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
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $path,
        array $options = []
    ): string
    {
        return $this->buildCmsUri->__invoke(
            $siteId,
            'page',
            $path,
            $options
        );
    }
}
