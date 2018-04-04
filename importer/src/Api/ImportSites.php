<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSites
{
    protected $importUtilities;
    protected $importSite;

    public function __construct(
        ImportUtilities $importUtilities,
        ImportSite $importSite
    ) {
        $this->importUtilities = $importUtilities;
        $this->importSite = $importSite;
    }

    /**
     * @param array  $sitesData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return SiteCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $sitesData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importUtilities->log(
            LogLevel::INFO,
            'Import Sites:',
            $options
        );

        $sites = [];

        foreach ($sitesData as $siteData) {
            $sites[] = $this->importSite->__invoke(
                $siteData,
                $createdByUserId,
                $createdReason,
                $options
            );
        }

        return $sites;
    }
}
