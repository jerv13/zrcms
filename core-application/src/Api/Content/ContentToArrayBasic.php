<?php

namespace Zrcms\CoreApplication\Api\Content;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\PropertiesToArray;
use Zrcms\Core\Model\Content;
use Zrcms\CoreApplication\Api\RemoveProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentToArrayBasic implements ContentToArray
{
    protected $propertiesToArray;

    /**
     * @param PropertiesToArray $propertiesToArray
     */
    public function __construct(
        PropertiesToArray $propertiesToArray
    ) {
        $this->propertiesToArray = $propertiesToArray;
    }

    /**
     * @param Content $content
     * @param array   $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $content,
        array $options = []
    ): array {
        $array = [];

        $array['id'] = $content->getId();
        $array['properties'] = $this->propertiesToArray->__invoke(
            $content->getProperties(),
            Property::getArray(
                $options,
                self::OPTION_PROPERTIES_OPTIONS,
                []
            )
        );

        return RemoveProperties::invoke(
            $array,
            Property::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}
