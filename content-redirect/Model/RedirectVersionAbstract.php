<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentRedirect\Fields\FieldsRedirectVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectVersionAbstract extends ContentVersionAbstract implements RedirectVersion
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsRedirectVersion::REDIRECT_PATH
        );

        parent::__construct(
            $id,
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
            FieldsRedirectVersion::REDIRECT_PATH,
            null
        );
    }
}
