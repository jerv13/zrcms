<?php

namespace Zrcms\ValidationRatZrcms\Api;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateSiteCmsResourceData implements ValidateFields
{
    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        ContainerInterface $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param array $cmsResourceData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        array $cmsResourceData,
        array $options = []
    ): ValidationResultFields {
        // @todo Write me
        return new ValidationResultFieldsBasic();
    }
}
