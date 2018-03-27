<?php

namespace Zrcms\CoreSiteContainer\Model;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\ContainerVersionAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteContainerVersionAbstract extends ContainerVersionAbstract
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param null|string $createdDate
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $context = Property::getString(
            $properties,
            FieldsContainerVersion::CONTEXT
        );

        if ($context !== SiteContainerVersion::CONTAINER_CONTEXT) {
            throw new \Exception(
                'Invalid context for: (' . get_class($this) . ')'
                . ' content must be ' . SiteContainerVersion::CONTAINER_CONTEXT
            );
        }

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
