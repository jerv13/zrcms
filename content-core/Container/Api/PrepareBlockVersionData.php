<?php

namespace Zrcms\ContentCore\Container\Api;

use Zrcms\ContentCore\Block\Fields\FieldsBlockVersion;
use Zrcms\ContentCore\GetGuidV4;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareBlockVersionData
{
    /**
     * @param array       $blockVersionData
     * @param string|null $containerVersionId
     *
     * @return array
     */
    public static function invoke(
        array $blockVersionData,
        $containerVersionId = null
    ):array {
        $blockVersionData[FieldsBlockVersion::CONTAINER_VERSION_ID] = $containerVersionId;

        if (empty($blockVersionData[FieldsBlockVersion::RENDER_DATA_ID])) {
            $blockVersionData[FieldsBlockVersion::RENDER_DATA_ID] = GetGuidV4::invoke();
        }

        return $blockVersionData;
    }
}
