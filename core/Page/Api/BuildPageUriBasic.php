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
     * @param string $pagePath
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $pagePath,
        array $options = []
    ): string
    {
        return $this->buildCmsUri->__invoke(
            $siteId,
            'page',
            $pagePath,
            $options
        );
    }
}
