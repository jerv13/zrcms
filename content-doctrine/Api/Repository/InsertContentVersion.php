<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstractContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
    extends ApiAbstractContentVersion
    implements \Zrcms\Content\Api\Repository\InsertContentVersion
{
    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): ContentVersion
    {
        $contentVersion->assertIsNew();

        $this->entityManager->persist($contentVersion);
        $this->entityManager->flush($contentVersion);

        return $contentVersion;
    }
}
