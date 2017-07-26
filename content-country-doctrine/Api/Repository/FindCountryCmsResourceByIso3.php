<?php

namespace Zrcms\ContentCountryDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCountry\Model\CountryCmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResourceBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountryCmsResourceByIso3
    implements \Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourceByIso3
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
        $this->entityClass = CountryCmsResourceEntity::class;
        $this->classCmsResourceBasic = CountryCmsResourceBasic::class;
    }

    /**
     * @param string $host
     * @param array  $options
     *
     * @return CountryCmsResource|null
     */
    public function __invoke(
        string $host,
        array $options = []
    ) {
        // @todo
    }
}
