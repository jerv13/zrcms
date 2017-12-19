<?php

namespace Zrcms\HttpApi\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IdAttributeZfInputFilterService extends AttributesZfInputFilterService
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
