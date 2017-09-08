<?php

namespace Zrcms\HttpExpressive1\Api\View\Render;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithOriginalUri;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutMetaPageData implements GetViewLayoutTags
{
    const RENDER_TAG_META_PAGE_DATA = 'meta-page-data';

    /**
     * @var RenderTag
     */
    protected $renderTag;

    /**
     * @var IsAllowed
     */
    protected $isAllowed;

    /**
     * @var array
     */
    protected $aclOptions;

    /**
     * /**
     * @param RenderTag $renderTag
     * @param IsAllowed $isAllowed
     * @param array     $aclOptions
     */
    public function __construct(
        RenderTag $renderTag,
        IsAllowed $isAllowed,
        array $aclOptions
    ) {
        $this->renderTag = $renderTag;
        $this->isAllowed = $isAllowed;
        $this->aclOptions = $aclOptions;
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
            $this->aclOptions
        );

        if (!$isAllowed) {
            return [];
        }

        $siteResource = $view->getSiteCmsResource();
        $siteVersion = $view->getSite();
        $pageResource = $view->getPageContainerCmsResource();
        $pageVersion = $view->getPage();
        $layoutResource = $view->getLayoutCmsResource();

        $originalPath = $this->getOriginalPath($request);

        if (empty($originalPath)) {
            throw new \Exception('Original path is required to render');
        }

        // @BC for RCM
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
                'name' => $originalPath,//BC
                'path' => $originalPath,
                'revision' => '', //BC
                'type' => 'n' // @todo @pageType
            ]
        ];

        $tagData = [
            'tag' => 'meta',
            'attributes' => [
                'name' => 'zrcms-page-data',
                'property' => 'rcm:page', // @BC this is for old admin screens
                'site-id' => $siteResource->getId(),
                'page-id' => $pageResource->getId(),
                'page-requested-path' => $originalPath,
                'page-path' => $pageResource->getPath(),
                'theme' => $layoutResource->getThemeName(),
                'layout' => $layoutResource->getName(),
                'content' => json_encode($content),
            ],
        ];

        return [
            self::RENDER_TAG_META_PAGE_DATA => $this->renderTag->__invoke($tagData)
        ];
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function getOriginalPath(
        ServerRequestInterface $request
    ) {
        $originalUri = $request->getAttribute(
            RequestWithOriginalUri::ATTRIBUTE_ORIGINAL_URI,
            null
        );

        if ($originalUri instanceof UriInterface) {
            return $originalUri->getPath();
        }

        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
