<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSiteContainers
{
    protected $importOptions;
    protected $importSiteContainer;

    public function __construct(
        ImportOptions $importOptions,
        ImportSiteContainer $importSiteContainer
    ) {
        $this->importOptions = $importOptions;
        $this->importSiteContainer = $importSiteContainer;
    }

    /**
     * @param array  $siteContainersData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return SiteContainerCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $siteContainersData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import SiteContainers:',
            $options
        );

        $siteContainers = [];

        foreach ($siteContainersData as $siteContainerData) {
            $siteContainers[] = $this->importSiteContainer->__invoke(
                $siteContainerData,
                $createdByUserId,
                $createdReason,
                $options
            );
        }

        return $siteContainers;
    }
}
