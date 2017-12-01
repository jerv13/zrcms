<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigCallable extends ReadComponentConfigCallableAbstract implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'callable-service';

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(ContainerInterface $serviceContainer)
    {
        parent::__construct($serviceContainer);
    }
}
