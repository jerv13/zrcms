<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceVersion;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceVersionBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Api\FallbackToComponentLayoutCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Api\FallbackToComponentLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceVersionTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourceVersionByThemeNameLayoutName
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceVersionByThemeNameLayoutName
{
    use BasicCmsResourceVersionTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classCmsResourceBasic;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var string
     */
    protected $classCmsResourceVersionBasic;

    /**
     * @var FallbackToComponentLayoutCmsResource
     */
    protected $fallbackToComponentLayoutCmsResource;

    /**
     * @var FallbackToComponentLayoutVersion
     */
    protected $fallbackToComponentLayoutVersion;

    /**
     * @param EntityManager                        $entityManager
     * @param FallbackToComponentLayoutCmsResource $fallbackToComponentLayoutCmsResource
     * @param FallbackToComponentLayoutVersion     $fallbackToComponentLayoutVersion
     */
    public function __construct(
        EntityManager $entityManager,
        FallbackToComponentLayoutCmsResource $fallbackToComponentLayoutCmsResource,
        FallbackToComponentLayoutVersion $fallbackToComponentLayoutVersion
    ) {
        $this->entityManager = $entityManager;
        $this->fallbackToComponentLayoutCmsResource = $fallbackToComponentLayoutCmsResource;
        $this->fallbackToComponentLayoutVersion = $fallbackToComponentLayoutVersion;

        $this->entityClassCmsResource = LayoutCmsResourceEntity::class;
        $this->classCmsResourceBasic = LayoutCmsResourceBasic::class;
        $this->entityClassContentVersion = LayoutVersionEntity::class;
        $this->classContentVersionBasic = LayoutVersionBasic::class;
        $this->classCmsResourceVersionBasic = LayoutCmsResourceVersionBasic::class;
    }

    /**
     * @param string $themeName
     * @param string $layoutName
     * @param array  $options
     *
     * @return LayoutCmsResourceVersion|CmsResourceVersion|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        array $options = []
    ) {
        $themeNamePropertyName = PropertiesLayoutCmsResource::THEME_NAME;
        $layoutNamePropertyName = PropertiesLayoutCmsResource::THEME_NAME;

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource, version FROM {$this->entityClassCmsResource} resource"
            . " LEFT JOIN {$this->entityClassContentVersion} version"
            . " WITH resource.contentVersionId = version.id"
            . " WHERE resource.{$themeNamePropertyName} = :themeName"
            . " AND resource.{$layoutNamePropertyName} = :name";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('themeName', $themeName);
        $dQuery->setParameter('name', $layoutName);

        $result = $dQuery->getResult();

        $layoutCmsResource = (empty($result[0]) ? null : $result[0]);

        $result[0] = $this->fallbackToComponentLayoutCmsResource->__invoke(
            $layoutCmsResource,
            $themeName,
            $layoutName,
            $options
        );

        $layoutVersion = (empty($result[1]) ? null : $result[1]);

        $result[1] = $this->fallbackToComponentLayoutVersion->__invoke(
            $layoutVersion,
            $result[0]->getContentVersionId(),
            $options
        );

        return $this->newBasicCmsResourceVersion(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $this->classCmsResourceVersionBasic,
            $result
        );
    }
}
