@todo
=====
8903 support pin

- Component Simplify #####
            
    - See about simplifying all common patterns (content, resource, etc...)?
    
        - CONFIG EXAMPLE:
            'zrcms-types' => [
                /* Default services and classes are defined here */
                'basic' => [
                    BuildComponentObject::class => BuildComponentObjectDefault::class,
                    PrepareComponentConfig::class => PrepareComponentConfigNoop::class,
                    ReadComponentConfig::class => ReadComponentConfigJsonFile::class,
                    'component-model-interface' => Component::class,
                    'component-model-class' => ComponentBasic::class,
                ],
            ],
         
     - Deal with 'zrcms-view-builders'
            
      as This;      


- Find service that end in "Basic" that determine the service to use and rename to ByStrategy
   
- Start zrcms-admin

- Add services to js

- PageDataService or LayoutDataService
    - get all the data for a specific page
    - will need the render tags too
      
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

##### GetViewLayoutTags interface could take on Request and use attributes #####

- Might simplify the interface
- View can be an attribute (see Zrcms\HttpViewRender\Request\RequestWithView)
- View does NOT have to be Content can be simple data model
- View could have ->addProperty()

##### Composition over Inheritance #####

- Might decouple a bit
    
    
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
