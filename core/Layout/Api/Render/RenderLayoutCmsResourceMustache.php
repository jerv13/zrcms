<?php

namespace Zrcms\Core\Layout\Api\Render;

use Phly\Mustache\Mustache;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutCmsResource;
use Zrcms\Mustache\StringResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutCmsResourceMustache implements RenderLayoutCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param array                         $renderData ['templateTag' => '{html}']
     * @param array                         $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var Layout $layout */
        $layout = $layoutCmsResource->getContent();

        $resolver = new StringResolver();
        $resolver->addTemplate('template', $layout->getHtml());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
