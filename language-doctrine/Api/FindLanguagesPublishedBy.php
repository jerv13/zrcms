<?php

namespace Zrcms\LanguageDoctrine\Api;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLanguagesPublishedBy implements \Zrcms\Language\Api\FindLanguagesPublishedBy
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [LanguagePublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ):array
    {
        $repository = $this->entityManager->getRepository(
            \Zrcms\LanguageDoctrine\Language\Entity\LanguagePublished::class
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
