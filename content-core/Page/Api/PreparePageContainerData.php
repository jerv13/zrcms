<?php

namespace Zrcms\ContentCore\Page\Api;

use Zrcms\ContentCore\Container\Api\PrepareBlockVersionsData;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;
use Zrcms\ContentCore\GetGuidV4;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PreparePageContainerData
{
    /**
     * @param string $pageContentId
     * @param array  $containersData
     *
     * @return array
     */
    public static function invoke(
        $pageContentId,
        array $containersData
    ):array {
        if (empty($pageContentId)) {
            $pageContentId = GetGuidV4::invoke();
        }

        foreach ($containersData as $containerName => $containerData) {
            $blockVersions = Param::getArray(
                $containerData,
                FieldsContainerVersion::BLOCK_VERSIONS,
                []
            );

            $containersData[$containerName][FieldsContainerVersion::BLOCK_VERSIONS] = PrepareBlockVersionsData::invoke(
                $blockVersions,
                BuildPageContainerVersionId::invoke($pageContentId, $containerName)
            );
        }

        return $containersData;
    }
}
