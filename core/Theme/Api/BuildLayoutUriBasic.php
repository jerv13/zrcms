<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\ContentResourceUri\Api\BuildCmsUri;
use Zrcms\Core\Theme\Model\LayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildLayoutUriBasic implements BuildLayoutUri
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

    public function __invoke(
        int $siteId,
        string $themeName,
        string $layoutName,
        array $options = []
    ): string
    {
        $path = $themeName . '/' . $layoutName;

        $cmsUri =  $this->buildCmsUri->__invoke(
            $siteId,
            LayoutProperties::URI_NAMESPACE,
            $path,
            $options
        );
    }
}
