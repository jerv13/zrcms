<?php

namespace Zrcms\SwaggerExpressiveZrcms\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\SwaggerExpressive\Api\IsAllowedSwagger;
use Zrcms\Acl\Api\IsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedSwaggerZrcms implements IsAllowedSwagger
{
    protected $isAllowed;
    protected $isAllowedOptions;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool {
        return $this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );
    }
}
