<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestByPageVersion implements GetViewByRequest
{
    const OPTION_PAGE_VERSION_ID = 'page-version-id';

    const DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID = 'TEMP-PAGE-FOR-VERSION';

    protected $getSiteCmsResource;
    protected $getThemeName;
    protected $findPageVersion;
    protected $getLayoutName;
    protected $getLayoutCmsResource;
    protected $buildView;
    protected $pageCmsResourceTempId;

    /**
     * @param GetSiteCmsResource   $getSiteCmsResource
     * @param GetThemeName         $getThemeName
     * @param FindPageVersion      $findPageVersion
     * @param GetLayoutName        $getLayoutName
     * @param GetLayoutCmsResource $getLayoutCmsResource
     * @param BuildView            $buildView
     * @param string               $pageCmsResourceTempId
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        FindPageVersion $findPageVersion,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        BuildView $buildView,
        string $pageCmsResourceTempId = self::DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->findPageVersion = $findPageVersion;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->buildView = $buildView;
        $this->pageCmsResourceTempId = $pageCmsResourceTempId;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws LayoutNotFound
     * @throws PageNotFound
     * @throws SiteNotFound
     * @throws ThemeNotFound
     * @throws InvalidGetViewByRequest
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View {
        $pageVersionId = Property::get(
            $options,
            self::OPTION_PAGE_VERSION_ID,
            null
        );

        if ($pageVersionId === null) {
            throw new InvalidGetViewByRequest(
                static::class . ' requires pageVersionId '
            );
        }

        $uri = $request->getUri();

        $publishedOnly = Property::get(
            $options,
            GetViewByRequestBasic::OPTION_PUBLISHED_ONLY,
            GetViewByRequestBasic::DEFAULT_PUBLISHED_ONLY
        );

        $published = true;

        if ($publishedOnly !== true) {
            $published = null;
        }

        $siteCmsResource = $this->getSiteCmsResource->__invoke(
            $uri->getHost(),
            $published
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageVersion = $this->findPageVersion->__invoke(
            $pageVersionId
        );

        if (empty($pageVersion)) {
            throw new PageNotFound(
                'Page version not found: (' . $pageVersionId . ')'
            );
        }

        $tempId = $this->buildTempPageCmsResourceId($pageVersionId);

        $pageCmsResource = new PageCmsResourceBasic(
            $tempId,
            false,
            $pageVersion,
            $tempId, // @todo Use current user
            $tempId // @todo some reason
        );

        $siteVersion = $siteCmsResource->getContentVersion();

        $layoutName = $this->getLayoutName->__invoke(
            $siteVersion,
            $pageVersion
        );

        $layoutCmsResource = $this->getLayoutCmsResource->__invoke(
            $themeName,
            $layoutName,
            $published
        );

        return $this->buildView->__invoke(
            $request,
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource,
            $options
        );
    }

    /**
     * @param string $versionId
     *
     * @return string
     */
    protected function buildTempPageCmsResourceId(
        string $versionId
    ): string {
        return $this->pageCmsResourceTempId . ':' . $versionId;
    }
}
