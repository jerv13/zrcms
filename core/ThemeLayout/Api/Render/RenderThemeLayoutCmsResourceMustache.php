<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Phly\Mustache\Mustache;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\ThemeLayout\Model\ThemeLayout;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutCmsResource;
use Zrcms\Mustache\StringResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderThemeLayoutCmsResourceMustache implements RenderThemeLayoutCmsResource
{
    /**
     * @param ThemeLayoutCmsResource|CmsResource $layoutCmsResource
     * @param array                              $renderData ['templateTag' => '{html}']
     * @param array                              $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var ThemeLayout $layout */
        $layout = $layoutCmsResource->getContent();

        $resolver = new StringResolver();
        $resolver->addTemplate('template', $layout->getHtml());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
