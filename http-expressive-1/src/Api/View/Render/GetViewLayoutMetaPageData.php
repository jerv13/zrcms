<?php

namespace Zrcms\HttpExpressive1\Api\View\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive1\Model\RequestedPage;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutMetaPageData implements GetViewLayoutTags
{
    const RENDER_TAG_META_PAGE_DATA = 'head';

    protected $renderTag;

    protected $isAllowed;

    protected $resourceId;

    protected $privilege;

    /**
     * @param RenderTag   $renderTag
     * @param IsAllowed   $isAllowed
     * @param string      $resourceId
     * @param string|null $privilege
     */
    public function __construct(
        RenderTag $renderTag,
        IsAllowed $isAllowed,
        string $resourceId,
        $privilege = null
    ) {
        $this->renderTag = $renderTag;
        $this->isAllowed = $isAllowed;
        $this->resourceId = $resourceId;
        $this->privilege = $privilege;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        // if admin
        $isAllowed = $this->isAllowed->__invoke(
            $request,
            $this->resourceId,
            $this->privilege
        );
        if (!$isAllowed) {
            return [];
        }

        $siteResource = $view->getSiteCmsResource();
        $siteVersion = $view->getSite();
        $pageResource = $view->getPageContainerCmsResource();
        $pageVersion = $view->getPage();

        /** @var RequestedPage $requestedPage */
        $requestedPagePath = $view->getProperty(
            RequestedPage::PROPERTY_PATH,
            null
        );

        if (empty($requestedPagePath)) {
            throw new \Exception('RequestedPage data is required to render');
        }

        // BC for RCM
        $content = [
            'site' => [
                'id' => $siteResource->getId(),
                'title' => $siteVersion->getProperty(PropertiesSiteVersion::TITLE, '')
            ],
            'page' => [
                'revision' => $pageVersion->getId(),
                'type' => 'n', // @todo @pageType
                'name' => $pageResource->getPath(),//BC
                'path' => $pageResource->getPath(),
                'id' => $pageResource->getId(),
                'title' => $pageVersion->getTitle(),
                'keywords' => $pageVersion->getKeywords(),
                'description' => $pageVersion->getDescription(),
                'siteId' => $siteResource->getId()
            ],
            'requestedPage' => [
                'name' => $requestedPagePath,//BC
                'path' => $requestedPagePath,
                'revision' => '', //BC
                'type' => 'n' // @todo @pageType
            ]
        ];

        $tagData = [
            'tag' => 'meta',
            'attributes' => [
                'name' => 'keywords',
                'content' => json_encode($content),
            ],
        ];

        return [
            self::RENDER_TAG_META_PAGE_DATA => $this->renderTag->__invoke($tagData)
        ];
    }

}
