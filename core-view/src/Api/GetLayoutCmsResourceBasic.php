<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Exception\LayoutNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutCmsResourceBasic implements GetLayoutCmsResource
{
    protected $findLayoutCmsResourceByThemeNameLayoutName;

    /**
     * @param FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
     */
    public function __construct(
        FindLayoutCmsResourceByThemeNameLayoutName $findLayoutCmsResourceByThemeNameLayoutName
    ) {
        $this->findLayoutCmsResourceByThemeNameLayoutName = $findLayoutCmsResourceByThemeNameLayoutName;
    }

    /**
     * @param string $themeName
     * @param string $layoutName
     *
     * @return LayoutCmsResource
     * @throws LayoutNotFound
     */
    public function __invoke(
        string $themeName,
        string $layoutName
    ): LayoutCmsResource {
        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = $this->findLayoutCmsResourceByThemeNameLayoutName->__invoke(
            $themeName,
            $layoutName
        );

        if (empty($layoutCmsResource)) {
            throw new LayoutNotFound(
                'Layout not found: (' . $layoutName . ')'
                . ' with theme name: (' . $themeName . ')'
            );
        }

        return $layoutCmsResource;
    }
}
