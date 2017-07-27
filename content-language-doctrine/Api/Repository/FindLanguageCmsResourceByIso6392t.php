<?php

namespace Zrcms\ContentLanguageDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResourceBasic;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLanguageCmsResourceByIso6392t
    implements \Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResourceByIso6392t
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = LanguageCmsResourceEntity::class;
        $this->classCmsResourceBasic = LanguageCmsResourceBasic::class;
    }

    /**
     * @param string $iso639_2t
     * @param array  $options
     *
     * @return LanguageCmsResource|null
     */
    public function __invoke(
        string $iso639_2t,
        array $options = []
    ) {
        // @todo
    }
}
