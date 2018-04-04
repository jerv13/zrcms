<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPages
{
    protected $importOptions;
    protected $importPage;

    /**
     * @param ImportUtilities $importOptions
     * @param ImportPage      $importPage
     */
    public function __construct(
        ImportUtilities $importOptions,
        ImportPage $importPage
    ) {
        $this->importOptions = $importOptions;
        $this->importPage = $importPage;
    }

    /**
     * @param array  $pagesData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return PageCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $pagesData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Pages:',
            $options
        );

        $pages = [];

        foreach ($pagesData as $pageData) {
            $pages[] = $this->importPage->__invoke(
                $pageData,
                $createdByUserId,
                $createdReason,
                $options
            );
        }

        return $pages;
    }
}
