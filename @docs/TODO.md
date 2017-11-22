@todo
=====

- Rename http-expressive to http, http-core and others maybe

- content-language and content-country are components - rename them
    zrcms-language
    zrcms-country
    
- Component Simplify #####

    - Use the 'classification' to categories component type (blocks, etc...)
    - Instead of categories for components, we could have types
      This could reduce or eliminate needing special repositories for each type

- PageDataService or LayoutDataService
    - get all the data for a specific page
    - will need the render tags too
    

- Rename Directories Use model as directory
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

- Implement Content pattern for page templates PageTemplateResource extends Page
    - Add NOOP services
    - Exporter needs updateing
    - Wire services
    
- Add NOOP services where needed 

- Need a way to clear caches on registries and component configs

- BuildView should use a component, not config
    
- Document the architecture and basics of how it works

- Doctrine FindXXXsBy need to be made to work better with properties

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig
    
- Check and update all composer dependencies
    
Features
--------

- Admin menus
    - Standard menus for admins using the properties and/or field definitions
    - include input-validations
    - create js/ui lib
    
Clean up - Refactoring
----------------------

##### GetViewLayoutTags interface could take on Request and us attributes #####

- Might simplify the interface
- View can be an attribute (see Zrcms\HttpViewRender\Request\RequestWithView)
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
