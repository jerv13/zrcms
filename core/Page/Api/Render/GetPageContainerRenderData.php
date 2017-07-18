<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Container\Api\Render\GetContainerRenderData;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderData implements GetPageRenderData
{
    /**
     * @var GetContainerRenderData
     */
    protected $getContainerRenderData;

    /**
     * @param GetContainerRenderData $getContainerRenderData
     */
    public function __construct(
        GetContainerRenderData $getContainerRenderData
    ) {
        $this->getContainerRenderData = $getContainerRenderData;
    }

    /**
     * @param Page|Content           $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $page,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [
            PageProperties::RENDER_TAG => $this->getContainerRenderData->__invoke(
                $page,
                $request
            )
        ];
    }
}
