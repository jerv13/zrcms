<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionsToArrayBasic implements ContentVersionsToArray
{
    protected $contentVersionToArray;

    /**
     * @param ContentVersionToArray $contentVersionToArray
     */
    public function __construct(
        ContentVersionToArray $contentVersionToArray
    ) {
        $this->contentVersionToArray = $contentVersionToArray;
    }

    /**
     * @param ContentVersion[] $contentVersions
     * @param array            $options
     *
     * @return array
     */
    public function __invoke(
        array $contentVersions,
        array $options = []
    ): array {
        $array = [];

        foreach ($contentVersions as $contentVersion) {
            $array[] = $this->contentVersionToArray->__invoke(
                $contentVersion,
                Param::getArray(
                    $options,
                    self::OPTION_CONTENT_OPTIONS,
                    []
                )
            );
        }

        return $array;
    }
}
