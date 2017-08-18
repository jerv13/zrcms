<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectVersionAbstract extends ContentVersionAbstract implements RedirectVersion
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            PropertiesRedirectVersion::REDIRECT_PATH
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getRedirectPath(): string
    {
        return $this->getProperty(
            PropertiesRedirectVersion::REDIRECT_PATH,
            null
        );
    }
}
