<?php

namespace Zrcms\CorePage\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageVersionBasic extends PageVersionAbstract implements PageVersion
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     * @throws \Throwable
     * @throws \Zrcms\CorePage\Exception\InvalidPath
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
