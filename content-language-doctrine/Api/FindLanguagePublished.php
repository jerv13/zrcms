<?php

namespace Zrcms\ContentLanguageDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Language\Model\LanguagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLanguagePublished implements \Zrcms\Language\Api\FindLanguagePublished
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
     * @param string $iso639_2t
     * @param array  $options
     *
     * @return LanguagePublished|null
     */
    public function __invoke(
        string $iso639_2t,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            \Zrcms\ContentLanguageDoctrine\Language\Entity\LanguagePublished::class
        );

        return $repository->find(
            $iso639_2t
        );
    }
}
