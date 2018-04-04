<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Reliv\Json\Json;

class Import
{
    protected $importUtilities;
    protected $importSites;
    protected $importRedirects;

    /**
     * @param ImportUtilities $importUtilities
     * @param ImportSites     $importSites
     * @param ImportRedirects $importRedirects
     */
    public function __construct(
        ImportUtilities $importUtilities,
        ImportSites $importSites,
        ImportRedirects $importRedirects
    ) {
        $this->importUtilities = $importUtilities;
        $this->importSites = $importSites;
        $this->importRedirects = $importRedirects;
    }

    /**
     * This imports sites, pages, and containers from an exported JSON array into ZRCMS.
     *
     * @param string $json
     * @param string $createdByUserId
     * @param array  $options
     *
     * @return void
     * @throws \Exception
     */
    public function __invoke(
        string $json,
        string $createdByUserId,
        array $options = []
    ) {
        $startTime = time();

        $data = Json::decode(
            $json,
            true
        );

        $createdReason = 'Import script ' . get_class($this);

        $redirectsData = Property::getArray(
            $data,
            'redirects',
            []
        );

        $sitesData = Property::getArray(
            $data,
            'sites',
            []
        );

        $this->importRedirects->__invoke(
            $redirectsData,
            $createdByUserId,
            $createdReason,
            $options
        );

        $this->importSites->__invoke(
            $sitesData,
            $createdByUserId,
            $createdReason,
            $options
        );

        $this->importUtilities->log(
            LogLevel::INFO,
            'Import COMPLETE in ' . (time() - $startTime) . ' seconds',
            $options
        );
    }
}
