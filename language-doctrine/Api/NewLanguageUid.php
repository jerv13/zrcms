<?php

namespace Zrcms\LanguageDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\LanguageDoctrine\Country\Entity\LanguageUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NewLanguageUid implements \Zrcms\Language\Api\NewLanguageUid
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * Unique identifier
     *
     * @param array $options
     *
     * @return string
     */
    public function __invoke(array $options = []): string
    {
        $uid = new LanguageUid();

        $this->entityManager->persist($uid);
        $this->entityManager->flush($uid);

        return $uid->__toString();
    }
}
