<?php

namespace Zrcms\CoreContainer\Api;

use Zrcms\CoreApplication\Api\GetGuidV4;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareBlockVersionsData
{
    /**
     * @param array  $blockVersionsData
     * @param string $containerVersionId
     *
     * @return array
     */
    public static function invoke(
        array $blockVersionsData,
        $containerVersionId
    ):array {
        if (empty($containerVersionId)) {
            $containerVersionId = GetGuidV4::invoke();
        }

        foreach ($blockVersionsData as $key => $blockVersionData) {
            $blockVersionsData[$key] = PrepareBlockVersionData::invoke(
                $blockVersionData,
                $containerVersionId
            );
        }

        return $blockVersionsData;
    }
}
