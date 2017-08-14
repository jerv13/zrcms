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
        $requestedPage = $view->getProperty(
            RequestedPage::PROPERTY_NAME,
            null
        );

        if (empty($requestedPage)) {
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
                'name' => $pageResource->getPath(),
                'id' => $pageResource->getId(),
                'title' => $pageVersion->getTitle(),
                'keywords' => $pageVersion->getKeywords(),
                'description' => $pageVersion->getDescription(),
                'siteId' => $siteResource->getId()
            ],
            'requestedPage' => $requestedPage->__toArray()
        ];

        $tagData = [
            'tag' => 'meta',
            'attributes' => [
                'name' => 'keywords',
                'content' => $content
            ],
        ];

        /*
         <meta property="rcm:page" content="{&quot;site&quot;:{&quot;id&quot;:1,&quot;title&quot;:&quot;Reliv International&quot;},&quot;page&quot;:{&quot;revision&quot;:109737,&quot;type&quot;:&quot;n&quot;,&quot;name&quot;:&quot;my-portal&quot;,&quot;id&quot;:3731,&quot;title&quot;:&quot;My Reliv Distributor Portal&quot;,&quot;keywords&quot;:&quot;Reliv International Portal&quot;,&quot;description&quot;:&quot;Discover Reliv, the Nutritional Epigenetics Company.&quot;,&quot;siteId&quot;:1},&quot;requestedPage&quot;:{&quot;name&quot;:&quot;my-portal&quot;,&quot;type&quot;:&quot;n&quot;,&quot;revision&quot;:null}}">
         */

        return [
            self::RENDER_TAG_META_PAGE_DATA => $this->renderTag->__invoke($tagData)
        ];
    }

}
