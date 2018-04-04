<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPages
{
    protected $importUtilities;
    protected $importPage;

    /**
     * @param ImportUtilities $importUtilities
     * @param ImportPage      $importPage
     */
    public function __construct(
        ImportUtilities $importUtilities,
        ImportPage $importPage
    ) {
        $this->importUtilities = $importUtilities;
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
        $this->importUtilities->log(
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
