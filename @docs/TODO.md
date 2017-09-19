@todo
=====

##### Investigate reducing properties (might try a factory instead of constructor) #####

- Content (id) do we still need ID?
- ContentVersion (id)
- Component (name, configLocation)

    /**
     * @param string $classification
     * @param string $name
     * @param string $configLocation
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $classification,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
            parent::__construct(
                $classification,
                $name,
                $configLocation,
                $properties,
                $createdByUserId,
                $createdReason
            );
        }
    

- ContentVersion

    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

- CmsResource

    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param array          $properties
     * @param string         $createdByUserId
     * @param string         $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof ContainerVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . ContainerVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }


- x CmsResourceEntity


        $id,
        bool $publishe

- x CmsResourcePublishHistoryEntity

- ContentEntity

    extends ContentEntityAbstract 
    implements ContentEntity

    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
    
    

##### Switch to Fields #####

- Remove static Properties classes for Fields classes
- 'validator' => '{service}',
- LikeFieldsContainerCmsResource
- What about ComponentConfigFields (same?)





        
- APIs in http-expressive
    - Test

- Write implementation test
    - for each content type (Container with block, PageContainer, Site, ThemeLayout, View)
    - Get components
    - create content
    - publish content
    - unpublish content
    - re-publish content
    - find resource and version

- Refactor ResponseHandler as http-api-response-formatter

- ContentDoctrine SyncProperties needs to be done separately for CmsResourcePublishHistory

- For publish and unpublish, extra properties (like host) should not be required if there is an existing resource

- Move GetViewLayoutMetaPageData to view-head module
    - NOTE: this is coupled to the render controller - so need find a way

- Finish Zrcms\ContentDoctrine\Api\Repository\FindCmsResourceVersion

- Implement Content pattern for page templates PageTemplateResource extends PageContainer
    - Add NOOP services
    - Exporter needs updateing
    - Wire services
    
- Add NOOP services where needed 

- USE GetSiteCmsResourceVersionByRequest instead of FindSiteCmsResourceVersionByHost where possible

- Need a way to clear caches on registries and component configs

- Check ENTITIES 
    - Publish history entities, make sure they have the correct getters
    - Make sure all properties are getting synced back @see BasicCmsResourceTrait, BasicCmsResourceVersionTrait, BasicContentVersionTrait
    
- BuildView should use a component, not config
    
- Document the architecture and basics of how it works

- Doctrine FindXXXsBy need to be made to work better with properties

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- HandleResponse should be a pipe or composite

    - Could these just be middleware???
        - Could get options from request instead of passed in
        - Could get handlers from route options
    - If a handler returns a response, then return and done
    - Else handlers should call next
    - Allow handlers to be configured for pipe
    
- Check and update all composer dependencies

    
Features
--------

- Admin menus
    - Standard menus for admins using the properties and/or field definitions
    - include input-validations
    - create js/ui lib
    
Clean up - Refactoring
----------------------

##### Component Simplify #####

- Instead of categories for components, we could have types
  This could reduce or eliminate needing special repositories for each type

##### GetViewLayoutTags interface could take on Request and us attributes #####

- Might simplify the interface
- View can be an attribute (see Zrcms\HttpExpressive1\HttpAlways\RequestWithView)
- View does NOT have to be Content can be simple data model
- View could have ->addProperty()

##### Composition over Inheritance #####

- Might decouple a bit

##### Deal with properties #####

- Property definitions need to be defined somehow that is easy to understand from code
- Property definitions might be injectable or validated
    - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
- Properties need to be synced between Content and array
    
##### Check all component Properties and config values #####

- Add getters where required
    
##### Abstract ACL for ALL libraries #####

- Each LIB should have and ACL abstraction
- Write an injectable ACL and User service defaulting to RcmUser (decouple ACL and User)
    - @see Redirect-editor
    
    
OPTIMIZATION: api (after FindResourceVersion implemented)
---------------------------------------------------------

- Optimize queries
- Add indexes
- GetViewLayoutTagsBasic - See @todo in class
- view-head
    - reduce loops
    - optimize BC
    - Use const for strings
- Caching
    - Create file caching service (not just array cache)
