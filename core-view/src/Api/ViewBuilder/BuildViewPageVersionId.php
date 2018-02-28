<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetThemeName;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewPageVersionId implements BuildView
{
    const ATTRIBUTE_VIEW_PAGE_VERSION_ID = 'zrcms-view-page-version-id';

    const DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID = 'TEMP-PAGE-FOR-VERSION';

    protected $published = null; // AKA Any

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
     * @param string               $pageCmsResourceTempId
     */
    public function __construct(
        GetSiteCmsResource $getSiteCmsResource,
        GetThemeName $getThemeName,
        FindPageVersion $findPageVersion,
        GetLayoutName $getLayoutName,
        GetLayoutCmsResource $getLayoutCmsResource,
        string $pageCmsResourceTempId = self::DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID
    ) {
        $this->getSiteCmsResource = $getSiteCmsResource;
        $this->getThemeName = $getThemeName;
        $this->findPageVersion = $findPageVersion;
        $this->getLayoutName = $getLayoutName;
        $this->getLayoutCmsResource = $getLayoutCmsResource;
        $this->pageCmsResourceTempId = $pageCmsResourceTempId;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View {
        $uri = $request->getUri();

        $siteCmsResource = $this->getSiteCmsResource->__invoke(
            $uri->getHost(),
            $this->published
        );

        $themeName = $this->getThemeName->__invoke(
            $siteCmsResource
        );

        $pageVersionId = $request->getAttribute(
            self::ATTRIBUTE_VIEW_PAGE_VERSION_ID,
            null
        );

        $pageVersion = $this->findPageVersion->__invoke(
            $pageVersionId,
            $this->published
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
            $this->published
        );

        return ViewBasic::build(
            $siteCmsResource,
            $pageCmsResource,
            $layoutCmsResource,
            Property::getString(
                $options,
                self::OPTION_VIEW_STRATEGY
            ),
            Property::getArray(
                $options,
                self::OPTION_VIEW_PROPERTIES,
                []
            ),
            Property::getString(
                $options,
                self::OPTION_VIEW_ID,
                null
            )
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
