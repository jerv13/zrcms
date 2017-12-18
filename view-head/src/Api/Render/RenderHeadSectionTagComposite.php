<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagComposite implements RenderHeadSectionTag
{
    protected $serviceContainer;
    protected $renderHeadSectionTagConfig = [];

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $renderHeadSectionTagConfig
     */
    public function __construct(
        $serviceContainer,
        array $renderHeadSectionTagConfig
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->renderHeadSectionTagConfig = $renderHeadSectionTagConfig;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $sectionConfig
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string {
        $renderHeadSectionTagApiList = $this->getApiList();

        $html = null;

        /** @var RenderHeadSectionTag $renderHeadSectionTag */
        foreach ($renderHeadSectionTagApiList as $renderHeadSectionTag) {
            try {
                $html = $renderHeadSectionTag->__invoke(
                    $request,
                    $tag,
                    $sectionEntryName,
                    $sectionConfig,
                    $options
                );
            } catch (CanNotRenderHeadSectionTag $e) {
                continue;
            }
        }

        if ($html === null) {
            throw new CanNotRenderHeadSectionTag(
                'No RenderHeadSectionTag available for tag: ' . $tag . ' section name: ' . $sectionEntryName
            );
        }

        return $html;
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getApiList()
    {
        $queue = new \SplPriorityQueue();

        $apiList = [];

        foreach ($this->renderHeadSectionTagConfig as $renderHeadSectionTagServiceName => $priority) {
            $renderHeadSectionTag = $this->serviceContainer->get($renderHeadSectionTagServiceName);

            $this->assertValidRenderHeadSectionTag(
                $renderHeadSectionTagServiceName,
                $renderHeadSectionTag
            );

            $queue->insert($renderHeadSectionTag, $priority);
        }

        foreach ($queue as $item) {
            $apiList[] = $item;
        }

        return $apiList;
    }

    /**
     * @param string               $apiServiceName
     * @param RenderHeadSectionTag $renderHeadSectionTag
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidRenderHeadSectionTag(
        string $apiServiceName,
        $renderHeadSectionTag
    ) {
        if (!is_a($renderHeadSectionTag, RenderHeadSectionTag::class)) {
            throw new \Exception(
                $apiServiceName . ' must be instance of: ' . RenderHeadSectionTag::class
            );
        }
    }
}
