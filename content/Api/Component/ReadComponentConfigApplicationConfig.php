<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigApplicationConfig
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'app-config';

    /**
     * @param array $applicationConfig
     */
    public function __construct(array $applicationConfig)
    {
        parent::__construct($applicationConfig);
    }
}
