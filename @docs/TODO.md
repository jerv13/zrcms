@todo
=====

- Multi Page container rendering
    - Containers path can be changed to name
    - PageCmsResource PageCmsResource

- PageDataService

- Rename Directories
    - CmsResourceHistory to CmsResourceHistory
    - Repository to CsmResource, Component, ContentVersion respectively
      
- APIs in http-expressive
    - Test

- Write implementation test
    - for each content type (Container with block, Page, Site, ThemeLayout, View)
    - Get components
    - create content
    - publish content
    - unpublish content
    - re-publish content
    - find resource and version

- Refactor ResponseHandler as http-api-response-formatter

- ContentDoctrine SyncProperties needs to be done separately for CmsResourceHistory

- For publish and unpublish, extra properties (like host) should not be required if there is an existing resource

- Move GetViewLayoutMetaPageData to view-head module
    - NOTE: this is coupled to the render controller - so need find a way

- Finish Zrcms\ContentDoctrine\Api\Repository\FindCmsResourceVersion

- Implement Content pattern for page templates PageTemplateResource extends Page
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
    
- Check and update all composer dependencies

- Trackable Date is not constructor injected which cause issues for low-level services
    - Needs to be able to be set at construct, auto set if null
    
Features
--------

- Admin menus
    - Standard menus for admins using the properties and/or field definitions
    - include input-validations
    - create js/ui lib
    
Clean up - Refactoring
----------------------

##### Component Simplify #####

- Use the 'classification' to categories component type (blocks, etc...)
- Instead of categories for components, we could have types
  This could reduce or eliminate needing special repositories for each type


##### GetViewLayoutTags interface could take on Request and us attributes #####

- Might simplify the interface
- View can be an attribute (see Zrcms\HttpExpressive\HttpAlways\RequestWithView)
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
