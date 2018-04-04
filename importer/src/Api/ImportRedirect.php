<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportRedirect
{
    protected $importOptions;
    protected $findRedirectCmsResource;
    protected $insertRedirectVersion;
    protected $createRedirectCmsResource;

    /**
     * @param ImportUtilities           $importOptions
     * @param FindRedirectCmsResource   $findRedirectCmsResource
     * @param InsertRedirectVersion     $insertRedirectVersion
     * @param CreateRedirectCmsResource $createRedirectCmsResource
     */
    public function __construct(
        ImportUtilities $importOptions,
        FindRedirectCmsResource $findRedirectCmsResource,
        InsertRedirectVersion $insertRedirectVersion,
        CreateRedirectCmsResource $createRedirectCmsResource
    ) {
        $this->importOptions = $importOptions;
        $this->findRedirectCmsResource = $findRedirectCmsResource;
        $this->insertRedirectVersion = $insertRedirectVersion;
        $this->createRedirectCmsResource = $createRedirectCmsResource;
    }

    /**
     * @param array  $siteDataContainer
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return RedirectCmsResource|null
     * @throws \Exception
     */
    public function __invoke(
        array $siteDataContainer,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $id = Property::getString(
            $siteDataContainer,
            'id'
        );

        $published = Property::getBool(
            $siteDataContainer,
            'published',
            true
        );

        $properties = Property::getArray(
            $siteDataContainer,
            'properties',
            []
        );

        $siteCmsResourceId = Property::get(
            $properties,
            'siteCmsResourceId'
        );

        $requestPath = Property::getRequired(
            $properties,
            'requestPath'
        );

        $redirectPath = Property::getRequired(
            $properties,
            'redirectPath'
        );

        $existing = $this->findRedirectCmsResource->__invoke(
            $id
        );

        if (!empty($existing) && $this->importOptions->skipDuplicates($options)) {
            $this->importOptions->log(
                LogLevel::WARNING,
                'SKIP redirect - Already exists: ('
                . 'redirect Id: ' . $id . ' SiteID: ' . $siteCmsResourceId
                . ')',
                $options
            );

            return null;
        }

        $this->importOptions->log(
            LogLevel::INFO,
            'Import Redirect: ' . $id
            . ' RequestPath' . $requestPath
            . ' RedirectPath: ' . $redirectPath
            . ' SiteID: ' . $siteCmsResourceId,
            $options
        );

        $version = new RedirectVersionBasic(
            null,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $version = $this->insertRedirectVersion->__invoke(
            $version
        );

        $publishedRedirectCmsResource = $this->createRedirectCmsResource->__invoke(
            $id,
            $published,
            $version->getId(),
            $createdByUserId,
            $createdReason
        );

        if (!$published) {
            $this->importOptions->log(
                LogLevel::WARNING,
                'UNPUBLISH RedirectCmsResource ID: ' . $publishedRedirectCmsResource->getId(),
                $options
            );
        }

        return $publishedRedirectCmsResource;
    }
}
