<?php

namespace Zrcms\CoreBlock\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Phly\Mustache\Resolver\ResolverInterface;
use Reliv\WhiteRat\FilterInterface;
use Reliv\WhiteRat\Whitelist;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Exception\BlockComponentMissing;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockMustache implements RenderBlock
{
    const SERVICE_ALIAS = 'mustache';

    protected $findComponent;
    protected $resolver;
    protected $filterWithWhitelist;

    /**
     * RenderBlockMustache constructor.
     * @param FindComponent $findComponent
     * @param ResolverInterface $resolver
     * @param FilterInterface $filterWithWhitelist
     */
    public function __construct(
        FindComponent $findComponent,
        ResolverInterface $resolver,
        FilterInterface $filterWithWhitelist
    ) {
        $this->findComponent = $findComponent;
        $this->resolver = $resolver;
        $this->filterWithWhitelist = $filterWithWhitelist;
    }

    /**
     * @param Block|Content $block
     * @param array $renderTags ['render-tag' => '{html}']
     * @param array $options
     *
     * @return string
     * @throws BlockComponentMissing
     * @throws \Exception
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findComponent->__invoke(
            'block',
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            throw new BlockComponentMissing(
                "BlockComponent not found: (" . $block->getBlockComponentName() . ")"
            );
        }

        $templateFile = $this->getTemplateFile($blockComponent);

        $mustache = new Mustache();
        $mustache->getResolver()->attach($this->resolver);

        $renderTags['configJson'] = json_encode(
            $this->getWhitelistedJsonConfig($renderTags['config'], $blockComponent)
        );

        return $mustache->render($templateFile, $renderTags);
    }

    /**
     * Note: This functionality could be moved higher up into the ZRCMS render-tags chain in the future.
     *
     * @param array $config
     * @param BlockComponent $blockComponent
     * @return array
     */
    protected function getWhitelistedJsonConfig(array $config, BlockComponent $blockComponent)
    {
        if (array_key_exists('configJsonWhitelist', $blockComponent->getProperties())) {
            return $this->filterWithWhitelist->__invoke(
                $config,
                $blockComponent->getProperties()['configJsonWhitelist']

            );
        }

        return [];
    }

    /**
     * @param BlockComponent $blockComponent
     *
     * @return false|string
     * @throws \Exception
     */
    protected function getTemplateFile(BlockComponent $blockComponent)
    {
        $moduleDirectory = $blockComponent->getModuleDirectory();
        $templateFile = $blockComponent->findProperty(FieldsBlockComponent::TEMPLATE_FILE);

        // @todo @BC if we have no template directory, we assume it is next in the module directory
        if (empty($templateFile)) {
            $templateFile = $moduleDirectory . '/template.mustache';
        } else {
            $templateFile = $moduleDirectory . $templateFile;
        }

        $templateFileReal = realpath($templateFile);

        if ($templateFileReal === false) {
            throw new \Exception(
                'Block template directory not found'
                . ' for block: (' . $blockComponent->getName() . ')'
                . ' directory: (' . $templateFile . ')'
            );
        }

        return $templateFile;
    }
}
