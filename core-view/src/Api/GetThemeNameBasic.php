<?php

namespace Zrcms\CoreView\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreView\Exception\ThemeNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetThemeNameBasic implements GetThemeName
{
    protected $findComponent;

    /**
     * @param FindComponent $findComponent
     */
    public function __construct(
        FindComponent $findComponent
    ) {
        $this->findComponent = $findComponent;
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     *
     * @return string
     * @throws ThemeNotFound
     */
    public function __invoke(
        SiteCmsResource $siteCmsResource
    ): string {
        $themeName = $siteCmsResource->getContentVersion()->getThemeName();

        $themeComponent = $this->findComponent->__invoke(
            'theme',
            $themeName
        );

        if (empty($themeComponent)) {
            throw new ThemeNotFound(
                'Theme not found (' . $themeName . ')'
                . ' for host: (' . $siteCmsResource->getHost() . ')'
                . ' with site ID: (' . (string)$siteCmsResource->getContentVersionId() . ')'
            );
        }

        return $themeName;
    }
}
