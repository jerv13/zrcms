<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportRedirects
{
    protected $importUtilities;
    protected $importRedirect;

    public function __construct(
        ImportUtilities $importUtilities,
        ImportRedirect $importRedirect
    ) {
        $this->importUtilities = $importUtilities;
        $this->importRedirect = $importRedirect;
    }

    /**
     * @param array  $redirectsData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return RedirectCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $redirectsData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importUtilities->log(
            LogLevel::INFO,
            'Import Redirects:',
            $options
        );

        $redirects = [];

        foreach ($redirectsData as $redirectData) {
            $redirects[] = $this->importRedirect->__invoke(
                $redirectData,
                $createdByUserId,
                $createdReason,
                $options
            );
        }

        return $redirects;
    }
}
