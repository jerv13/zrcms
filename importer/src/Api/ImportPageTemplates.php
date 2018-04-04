<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Zrcms\CorePage\Model\PageTemplateCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPageTemplates
{
    protected $importUtilities;
    protected $importPageTemplate;

    public function __construct(
        ImportUtilities $importUtilities,
        ImportPageTemplate $importPageTemplate
    ) {
        $this->importUtilities = $importUtilities;
        $this->importPageTemplate = $importPageTemplate;
    }

    /**
     * @param array  $pageTemplatesData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return PageTemplateCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $pageTemplatesData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importUtilities->log(
            LogLevel::INFO,
            'Import PageTemplates:',
            $options
        );

        $pageTemplates = [];

        foreach ($pageTemplatesData as $pageTemplateData) {
            $pageTemplates[] = $this->importPageTemplate->__invoke(
                $pageTemplateData,
                $createdByUserId,
                $createdReason,
                $options
            );
        }

        return $pageTemplates;
    }
}
