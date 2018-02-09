<?php

namespace Zrcms\CorePage\Api;

use Zrcms\CoreContainer\Api\PrepareBlockVersionsData;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Reliv\ArrayProperties\Property;

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
            $blockVersions = Property::getArray(
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
