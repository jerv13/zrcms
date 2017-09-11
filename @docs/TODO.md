@todo
=====

- Might make ContentVersion a property of the CmsResource instead of relationship
    - Eliminate CmsResource for CmsResourceVersion
    - Syncing Properties simpler
    - CmsResources (id, contentVersionId, published)
    - impact
        - PublishCmsResource
        - Make sure HTTP APIs use id in array

    
- Refactor ResponseHandler as http-api-response-formatter

- ContentDoctrine SyncProperties needs to be done separately for CmsResourcePublishHistory

- APIs in http-expressive

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

    
## Features ##

- Admin menus
    - Standard menus for admins using the properties and/or field definitions
    - include input-validations
    - create js/ui lib
    
## Clean up - Refactoring ##

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
    
##### Investigate reducing properties (might try a factory instead of constructor) #####

- Content (id) do we still need ID?
- ContentVersion (id)
- Component (name, configLocation)
    
##### Check all component Properties and config values #####

- Add getters where required
    
##### Abstract ACL for libraries #####

- Each LIB should have and ACL abstraction
- Write an injectable ACL and User service defaulting to RcmUser (decouple ACL and User)
    - @see Redirect-editor
    
    
##### ResponseMutatorStatusPage ######

- Needs to be split into services (might use service alias)
- Needs to be optimized
    
## OPTIMIZATION: api (after FindResourceVersion implemented) ##

- Optimize queries
- Add indexes
- GetViewLayoutTagsBasic - See @todo in class
- view-head
    - reduce loops
    - optimize BC
    - Use const for strings
- Caching
    - Create file caching service (not just array cache)
