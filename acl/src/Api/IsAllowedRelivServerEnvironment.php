<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\Server\Environment;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRelivServerEnvironment implements IsAllowed
{
    const OPTION_ALLOWED_ENVIRONMENTS = 'allowEnvironments';

    /**
     * @var array
     */
    protected $defaultAllowEnvironments;

    /**
     * @param array $defaultAllowEnvironments
     */
    public function __construct(
        array $defaultAllowEnvironments = []
    ) {
        $this->defaultAllowEnvironments = $defaultAllowEnvironments;
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
        $environment = Environment::getInstance()->getName();

        $allowEnvironments = Param::getArray(
            $options,
            self::OPTION_ALLOWED_ENVIRONMENTS,
            $this->defaultAllowEnvironments
        );

        if (in_array($environment, $allowEnvironments)) {
            return true;
        }
    }
}
