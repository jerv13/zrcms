<?php

namespace Zrcms\HttpApi\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIdAttributeZfInputFilterServiceHttpApi extends HttpApiAttributesZfInputFilterService
{
    /**
     * @param ServiceAwareFactory $factory
     * @param string              $idPropertyName
     */
    public function __construct(
        ServiceAwareFactory $factory,
        string $idPropertyName = 'id'
    ) {
        $inputFilterConfig = [
            $idPropertyName => [
                'name' => $idPropertyName,
                'required' => true,
                'validators' => [
                ],
            ],
        ];

        parent::__construct($factory, $inputFilterConfig);
    }
}
