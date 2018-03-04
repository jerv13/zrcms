<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Psr\Container\ContainerInterface;
use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Api\Validator\Validate;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;
use Zrcms\Core\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionExists implements Validate
{
    const CODE_MUST_BE_STRING = 'content-version-id-must-be-null-or-string';
    const CODE_NOT_FOUND = 'content-version-not-found';

    const OPTION_API_SERVICE_FIND_CONTENT_VERSION = 'api-service-find-content-version';

    protected $serviceContainer;
    protected $validateIsString;

    /**
     * @param ContainerInterface $serviceContainer
     * @param Validate           $validateIsString
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        Validate $validateIsString
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateIsString = $validateIsString;
    }

    /**
     * @param mixed $contentVersionId
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        $contentVersionId,
        array $options = []
    ): ValidationResult {
        $isStringResult = $this->validateIsString->__invoke(
            $contentVersionId,
            $options
        );

        if (!$isStringResult->isValid()) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_STRING
            );
        }

        $apiServiceFindVersion = $this->getFindContentVersionApiService(
            $options
        );

        $contentVersion = $apiServiceFindVersion->__invoke(
            $contentVersionId
        );

        if (empty($contentVersion)) {
            return new ValidationResultBasic(
                false,
                static::CODE_NOT_FOUND,
                ['Content version not found with id: ' . $contentVersionId]
            );
        }

        return new ValidationResultBasic();
    }

    /**
     * @param array $options
     *
     * @return FindContentVersion
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFindContentVersionApiService(
        array $options
    ): FindContentVersion {
        $apiServiceNameFindVersion = Property::getString(
            $options,
            static::OPTION_API_SERVICE_FIND_CONTENT_VERSION,
            null
        );

        if (empty($apiServiceNameFindVersion)) {
            throw new \Exception('api-service-find-content-version must be defined');
        }

        /** @var FindContentVersion $apiServiceFindVersion */
        $apiServiceFindVersion = $this->serviceContainer->get($apiServiceNameFindVersion);

        if (!$apiServiceFindVersion instanceof FindContentVersion) {
            throw new \Exception(
                'api-service-find-content-version must be instance of ' . FindContentVersion::class
            );
        }

        return $apiServiceFindVersion;
    }
}
